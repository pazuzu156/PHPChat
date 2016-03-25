<?php

if(user()->admin)
{
	$db = \Core\Database::init();
	$delete = $db->truncate('log');

	if($delete)
	{
		$data['msg'] = 'Chat log has been cleared!';
	}
	else
	{
		$data['msg'] = 'There was an error clearing the chat log. Please try again';
	}
}
else
{
	$data['msg'] = 'You\'re not allowed here!';
}

echo @json_encode($data);