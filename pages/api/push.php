<?php

$data['error'] = true;

if(isset($_POST['msg']))
{
	$data = api_push($_POST);
}
else
{
	$data['msg'] = 'No given content!';
}

echo @json_encode($data);