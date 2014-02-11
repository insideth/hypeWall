<?php

/**
 * Form that allows users to update their status
 */

namespace hypeJunction\Wall;

$status = elgg_view('input/plaintext', array(
	'name' => 'status',
	'class' => 'wall-input-status',
	'placeholder' => elgg_echo('wall:status:placeholder')
		));

$url = elgg_view('input/wall/url', array(
	'name' => 'address',
	'placeholder' => elgg_echo('wall:url:placeholder'),
		));

$friends = elgg_view('input/wall/friend', array(
	'name' => 'friend_guids',
	'data-hint-text' => elgg_echo('wall:tag:friends:hint'),
		));

$location = elgg_view('input/wall/location', array(
	'name' => 'location',
	'data-hint-text' => elgg_echo('wall:tag:location:hint'),
		));


$access = elgg_view('input/access', array(
	'class' => 'wall-access',
	'name' => 'access_id'
		));

$button = elgg_view('input/submit', array(
	'value' => elgg_echo('wall:post'),
	'class' => 'elgg-button elgg-button-submit',
		));

$hidden .= elgg_view('input/hidden', array(
	'name' => 'origin',
	'value' => 'wall',
		));

$html = <<<HTML
	<fieldset class="wall-fieldset-status">$status</fieldset>
	<fieldset class="wall-fieldset-attachment">
		<div class="wall-input-url hidden">$url</div>
		<div class="wall-url-preview"></div>
	</fieldset>
	<fieldset class="wall-fieldset-tags">
		<div class="wall-input-tag-location">$location</div>
		<div class="wall-input-tag-friends">$friends</div>
	</fieldset>
	<fieldset class="elgg-foot">
		<ul class="wall-bar-controls">
			<li>$access</li>
			<li>$button</li>
		</ul>
	</fieldset>
	$hidden
HTML;

echo $html;
