<?php

namespace hypeJunction\Wall;

use ElggObject;

$poster = elgg_get_logged_in_user_entity();
$status = strip_tags(get_input('status'), '');
$location = get_input('location', '');
$friend_guids = get_input('friend_guids', '');
if (!is_array($friend_guids)) {
	$friend_guids = string_to_tag_array($friend_guids);
}
$attachment_guids = get_input('attachment_guids', '');
if (!is_array($attachment_guids)) {
	$attachment_guids = string_to_tag_array($attachment_guids);
}
$upload_guids = get_input('upload_guids', array());
if (!is_array($upload_guids)) {
	$upload_guids = array();
}

$address = get_input('address');
$access_id = get_input('access_id');
$container_guid = get_input('container_guid');
if ($container_guid) {
	$container = get_entity($container);
	if (elgg_instanceof($container) && !$container->canWriteToContainer(0, 'object', 'hjwall')) {
		register_error(elgg_echo('wall:error:container_permissions'));
		forward(REFERER);
	}
}

if (!$container) {
	$container = $poster;
}

if (!$status && !$address) {
	register_error(elgg_echo('wall:error:empty_form'));
	forward(REFERER);
}

if ($poster->guid == $container_guid) {
	$title = elgg_echo('wall:post:status_udpate');
} else {
	$title = elgg_echo('wall:post:wall_to_wall', array(elgg_echo('wall:byline', array($poster->name))));
}

$wall_post = new ElggObject();
$wall_post->subtype = 'hjwall';
$wall_post->access_id = $access_id;
$wall_post->owner_guid = $poster->guid;
$wall_post->container_guid = $container->guid;
$wall_post->title = $title;
$wall_post->description = $status;

if ($wall_post->save()) {

	// Create a river entry for this wall post
	$river_id = add_to_river('river/object/hjwall/create', 'create', $poster->guid, $wall_post->guid);

	// Wall post access id is set to private, which means it should be visible only to the poster and tagged users
	// Creating a new ACL for that
	if ($access_id == ACCESS_PRIVATE && count($friend_guids)) {

		$user_guids = array($poster->guid, $container->guid);
		$user_guids = array_merge($user_guids, $friend_guids);
		$user_guids = array_unique($user_guids);
		sort($user_guids);

		$acl_hash = sha1(implode(':', $user_guids));
		$dbprefix = elgg_get_config('dbprefix');
		$query = "SELECT * FROM {$dbprefix}access_collections WHERE name = '$acl_hash'";
		$collection = get_data_row($query);
		$acl_id = $collection->id;
		if (!$acl_id) {
			$site = elgg_get_site_entity();
			$acl_id = create_access_collection($acl_hash, $site->guid);
			update_access_collection($acl_id, $user_guids);
		}
		$wall_post->access_id = $acl_id;
		$wall_post->save();
	}

	// Add 'tagged_in' relationships
	// If the access level for the post is not set to private, also create a river item with the access level specified in their settings by the tagged user
	if ($friend_guids) {
		foreach ($friend_guids as $friend_guid) {
			if (add_entity_relationship($friend_guid, 'tagged_in', $wall_post->guid)) {
				if (!in_array($access_id, array(ACCESS_PRIVATE, ACCESS_LOGGED_IN, ACCESS_PUBLIC))) {
					$river_access_id = elgg_get_plugin_user_setting('river_access_id', $friend_guid, PLUGIN_ID);
					if (!is_null($river_access_id) && $river_access_id !== ACCESS_PRIVATE) {
						add_to_river('river/relationship/tagged/create', 'tagged', $friend_guid, $wall_post->guid, $river_access_id);
					}
				}
			}
		}
	}

	if ($attachment_guids) {
		foreach ($attachment_guids as $attachment_guid) {
			add_entity_relationship($attachment_guid, 'attached', $wall_post->guid);
		}
	}

	// files being uploaded via $_FILES
	$new_file_guids = process_file_upload('files', 'file', null, $container_guid);
	if ($new_file_guids) {
		foreach ($new_file_guids as $name => $guid) {
			if (!$guid) {
				// upload has failed
				$failed[] = $name;
				unset($guids['name']);
			}
		}
	}

	if (is_array($new_file_guids)) {
		$upload_guids = array_merge($new_file_guids, $upload_guids);
	}

	if (count($upload_guids)) {
		foreach ($upload_guids as $upload_guid) {
			$upload = get_entity($upload_guid);
			$upload->description = $wall_post->description;
			$upload->origin = 'wall';
			$upload->access_id = $wall_post->access_id;
			$upload->save();
			add_entity_relationship($upload_guid, 'attached', $wall_post->guid);
		}
	}

	$wall_post->setLocation($location);
	$wall_post->address = $address;

	$message = format_wall_message($wall_post);
	$params = array(
		'entity' => $wall_post,
		'user' => $poster,
		'message' => $message,
		'url' => $wall_post->getURL(),
		'origin' => 'wall',
	);
	elgg_trigger_plugin_hook('status', 'user', $params);

	$tagged_friends = get_tagged_friends($object);
	foreach ($tagged_friends as $tagged_friend) {
		$to = $tagged_friend->guid;
		$from = $poster->guid;
		$subject = elgg_echo('wall:tagged:notification:subject', array($poster->name));
		$body = elgg_echo('wall:tagged:notification:message', array(
			$poster->name,
			$message,
			$wall_post->getURL()
		));

		notify_user($to, $from, $subject, $body);
	}

	if (elgg_is_xhr()) {
		echo elgg_list_river(array('object_guids' => $wall_post->guid));
	}

	system_message(elgg_echo('wall:create:success'));
	forward($wall_post->getURL());
} else {
	register_error(elgg_echo('wall:create:error'));
	forward(REFERER);
}

