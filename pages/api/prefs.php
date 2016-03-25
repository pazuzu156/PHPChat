<?php

$return = '';

if(isset($_POST['color']) && !empty($_POST['color']))
{
	$prefs = \Core\Database::init();

	if(!is_numeric($_POST['color']))
		$color = $_POST['color'];
	else
		$color = '#'.$_POST['color'];

	$prefs->update('prefs', user()->id, ['username_color' => $color]);

	if($prefs->error())
		$return = 'There was an error updating your preferences. Please try again later';
	else
		$return = 'Preferences updated! You may now close the preferences box.';
}
else
{
	$return = 'You forgot to supply a color!';
}

echo $return;