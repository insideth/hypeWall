<?php

$english = array(

	'item:object:hjwall' => 'Wall posts',
	
	'wall' => 'Wall',

	'wall:settings:form' => 'Wall forms',
	'wall:settings:status' => 'Update status',
	'wall:settings:url' => 'Share a link',
	'wall:settings:photo' => 'Share a photo',
	'wall:settings:file' => 'Share a file',
	'wall:settings:content' => 'Share content',

	'wall:usersettings:river_access_id' => 'Visibility of wall tags',
	'wall:usersettings:river_access_id:help' => 'Who can see that you were tagged in someone else\'s wall post, if the original post was not shared with them?',

	'wall:write' => 'Post to the wall',

	'wall:tag:friends' => 'Tag friends',
	'wall:tag:friends:hint' => 'Tag friends: start search by typing their name',
	'wall:tag:location:hint' => 'Add a location: search for previously tagged locations or add a new one',
	'wall:tag:location:findme' => 'Find me - Your browser might request you to allow this site to use your current location',
	'wall:tag:river' => '%s tagged %s in a wall post',

	'wall:status:placeholder' => 'What\'s on your mind?',
	'wall:url:placeholder' => 'Add a link',

	'wall:tagged:notification:subject' => '%s tagged you in a wall post',
	'wall:tagged:notification:message' => '
		%s tagged you in a wall post: <br />
		<blockquote>
			%s
		</blockquote>
		You can view the post here:
		%s
	',

	'wall:owner:suffix' => ' on %s\'s wall',
	'wall:byline' => ' by %s',
	'wall:with' => '- with %s',
	'wall:at' => ' near %s',
	'wall:attached' => ' [%s attachments]',
	
	'wall:new:wall:post' => '%s posted on %s\'s wall: ',
	'wall:status' => 'Update status',
	'wall:url' => 'Share a link',
	'wall:content' => 'Share content',
	'wall:post' => 'Post',
	'wall:photo' => 'Share a photo',
	'wall:file' => 'Share a file',
	'wall:owner' => '%s\'s Wall',
	'wall:moreposts' => 'Most posts',
	'wall:filefolder' => 'Wall Uploads',
	'wall:upload' => 'Wall File Upload',
	'wall:photo:placeholder' => 'Tell something about this photo',
	'wall:file:placeholder' => 'Tell something about this file',
	'wall:filehasntuploaded' => 'Please wait for the file to upload',

	'wall:create:success' => 'Wall post was successfully saved',
	'wall:create:error' => 'Wall post could not be created',
	'wall:process:posting' => 'Posting...',

	'wall:error:ajax' => 'Remote page is not accessible',
	'wall:error:container_permissions' => 'You you do not have sufficient permissions to post here',
	'wall:error:empty_form' => 'Please tell us what\'s on your mind or add a link first',

	'wall:delete' => 'Delete wall post',
	'wall:delete:success' => 'Wall post was successfully deleted',
	'wall:delete:error' => 'Wall post could not be deleted',
	
	'wall:remove_tag' => 'Remove tag',
	'wall:remove_tag:success' => 'You are no longer tagged in this post',
	'wall:remove_tag:error' => 'Tag could not be removed',

	'wall:post:status_update' => 'Status update',
	'wall:post:wall_to_wall' => 'Wall post',

	'wall:ecml:url' => 'Wall URL address',
	'wall:ecml:attachment' => 'Wall attachment',
	'wall:ecml:river' => 'River layout',

	'wall:filedrop:instructions' => 'Drag and Drop your files into this area or %s them from your computer',
	'wall:filedrop:fallback' => 'select',
	'wall:filedrop:browsernotsupported' => 'Your browser does not support drag&drop functionality',
	'wall:filedrop:filetoolarge' => 'One or more files exceed allowed maximum file size',
	'wall:filedrop:filetypenotallowed' => 'One or more files do not have an allowed file type',

	'wall:upload:success' => 'File uploaded successfully',
	'wall:upload:error' => 'File could not be uploaded',
	
);

add_translation("en", $english);