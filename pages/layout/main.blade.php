<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Chat V3</title>
	{{ style('style.css') }}
	{{ style('kbox.css') }}
	{{ script('jquery.min.js') }}
	{{ script('kbox.min.js') }}
	{{ script('chat.min.js') }}
</head>
<body>
	<h1>My Awesome Chat App</h1>
	@yield('content')
	<p class="footer">Client &copy; {{ date('Y') }} <a href="http://www.kalebklein.com" target="_blank">Kaleb Klein</a> - All Rights Reserved</p>
</body>
</html>