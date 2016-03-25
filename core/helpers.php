<?php

if(!function_exists('config'))
{
	function config()
	{
		return \Core\Config::from('app');
	}
}

/* ------- BEGIN: HTML Helpers ------- */
if(!function_exists('style'))
{
	function style($path)
	{
		$path = get_url('css/'.$path);
		return "<link rel=\"stylesheet\" type=\"text/css\" href=\"$path\">";
	}
}

if(!function_exists('script'))
{
	function script($path)
	{
		$path = get_url('js/'.$path);
        return "<script type=\"text/javascript\" src=\"$path\"></script>";
	}
}

if(!function_exists('image'))
{
	function image($path, $alt)
	{
		$path = get_url('img/'.$path);
		return "<img src=\"$path\" $alt=\"$alt\">";
	}
}

if(!function_exists('emote'))
{
	function emote($path, $alt, $title)
	{
		$path = get_url('img/'.$path);
		return "<img src=\"$path\" $alt=\"$alt\" title=\"$title\">";
	}
}
/* ------- END: HTML Helpers ------- */

/* ------- BEGIN: Session Helpers ------- */
if(!function_exists('session_has'))
{
	function session_has($key)
	{
		return \Core\Session::exists($key);
	}
}

if(!function_exists('session_get'))
{
	function session_get($key)
	{
		return \Core\Session::get($key);
	}
}

if(!function_exists('session_set'))
{
	function session_set($key, $value)
	{
		return \Core\Session::set($key, $value);
	}
}

if(!function_exists('session_delete'))
{
	function session_delete($key)
	{
		return \Core\Session::delete($key);
	}
}

if(!function_exists('flash'))
{
	function flash($key, $value='')
	{
		return \Core\Session::flash($key, $value);
	}
}
/* ------- END: Session Helpers ------- */

/* ------- BEGIN: Path Helpers ------- */
if(!function_exists('redir'))
{
	function redir($path)
	{
		header('Location: ' . get_url($path));
	}
}

if(!function_exists('get_url'))
{
	function get_url($path)
	{
		return rtrim(config()->get('baseurl'), '/').'/'.$path;
	}
}
/* ------- END: Path Helpers ------- */

/* ------- BEGIN: Input Helpers ------- */
if(!function_exists('input_get'))
{
	function input_get($key)
	{
		return \Core\Input::get($key);
	}
}
/* ------- END: Input Helpers ------- */

/* ------- BEGIN: Hash Helpers ------- */
if(!function_exists('hash_make'))
{
	function hash_make($string)
	{
		return \Core\Hash::make($string);
	}
}

if(!function_exists('hash_check'))
{
	function hash_check($string, $hash)
	{
		return \Core\Hash::check($string, $hash);
	}
}
/* ------- END: Hash Helpers ------- */

/* ------- BEGIN: User Helpers ------- */
if(!function_exists('register_user'))
{
	function register_user()
	{
		$db = \Core\Database::init();
		$valid = \Core\Validate::check();

		if($valid)
		{
			$admin = false;

			$db->get('users');
			if($db->count() == 0)
				$admin = true;

			$db->insert('users', [
				'username' => input_get('username'),
				'password' => hash_make(input_get('password')),
				'name' => input_get('name'),
				'admin' => $admin
			]);

			if(!$db->error())
			{
				$db->insert('prefs', [
					'username' => input_get('username'),
					'username_color' => '#000000',
				]);
				flash('smsg', 'You have successfully registered!');
			}
			else
			{
				flash('emsg', 'There was an issue registering you. Please try again');
			}
		}
		else
		{
			flash('emsg', 'Please fill the form out completely!');
		}
	}
}

if(!function_exists('login_user'))
{
	function login_user()
	{
		$db = \Core\Database::init();
		$valid = \Core\Validate::check();

		if($valid)
		{
			$user = $db->get('users', ['username', '=', input_get('username')]);
			if($user->count())
			{
				$user = $user->first();
				if($user->online)
				{
					flash('emsg', 'A user by that name is already logged in!');
				}
				else
				{
					$db->update('users', $user->id,['online' => true]);
					if(hash_check(input_get('password'), $user->password))
					{
						session_set('chat_login', $user->username);
						api_push(['user' => '', 'msg' => $user->username . ' has logged in!']);
						redir('');
					}
					else
					{
						flash('emsg', 'Invalid password!');
					}
				}
			}
			else
			{
				flash('emsg', 'That username does not exist!');
			}
		}
		else
		{
			flash('emsg', 'Please fill the form out completely!');
		}
	}
}

if(!function_exists('logout_user'))
{
	function logout_user()
	{
		$db = \Core\Database::init();
		$db->update('users', user()->id, ['online' => false]);
		api_push(['user' => '', 'msg' => user()->username . ' has logged out!']);
		session_delete('chat_login');
		redir('');
	}
}

if(!function_exists('user'))
{
	function user()
	{
		$db = \Core\Database::init();

		return $db->get('users', ['username', '=', session_get('chat_login')])->first();
	}
}

if(!function_exists('prefs'))
{
	function prefs($username='', $returnDB=false)
	{
		if(empty($username))
			$username = user()->username;

		$db = \Core\Database::init();
		$db->get('prefs', ['username', '=', $username]);

		$user = $db->first();

		if($returnDB)
			return $db;
		else
			return $user;
	}
}

if(!function_exists('is_admin'))
{
	function is_admin()
	{
		return user()->admin;
	}
}
/* ------- END: User Helpers ------- */

/* ------- BEGIN: API Helpers ------- */
if(!function_exists('api_push'))
{
	function api_push($data)
	{
		$db = \Core\Database::init();
		$db->insert('log', [
			'username' => $data['user'],
			'message' => $data['msg'],
			'posttime' => date('Y-m-d H:i:s')
		]);

		if(!$db->error())
		{
			return ['error' => false];
		}

		return [
			'error' => true,
			'msg' => 'There was an issue sending your message. Please try again.'
		];
	}
}

if(!function_exists('api_get_log'))
{
	function api_get_log()
	{
		$db = \Core\Database::init();
		return $db->get('log');
	}
}

if(!function_exists('api_get_users'))
{
	function api_get_users()
	{
		$db = \Core\Database::init();
		return $db->get('users', ['online', '=', '1']);
	}
}

if(!function_exists('api_parse_log'))
{
	function api_parse_log($line)
	{
		$line = api_parse_emote($line);
		$line = api_parse_language($line);

		return $line;
	}
}

if(!function_exists('api_parse_emote'))
{
	function api_parse_emote($line)
	{
		$emotes = array(
			':angry:'   => 'angry',
			':arrow:'   => 'arrow',
			':\)\)'     => 'big grin',
			';;\)'      => 'blink',
			'8\)'       => 'cool',
			':dunno:'   => 'dry',
			':!:'       => 'exclamation',
			'0.o'       => 'huh',
			':D'       => 'laugh',
			':o'        => 'oh my',
			':ninja:'   => 'ninja',
			':puke:'    => 'puke',
			'\?\?'      => 'question',
			':we:'      => 'roll eyes',
			':\('       => 'sad',
			':\)'       => 'smile',
			':p'        => 'tongue',
			':123:'     => 'unsure',
			';\)'       => 'wink'
		);

		foreach($emotes as $emote => $name)
		{
			$regex = '/'.$emote.'/i';
			$line = preg_replace_callback($regex, function($m)
				use ($name)
			{
				$namenospace = str_replace(' ', '', $name);
				$img = str_replace('ninja', 'ph34r', $namenospace);
				$image = emote($img.'.gif', $name, $namenospace);
				return $image;
			}, $line);
		}

		return $line;
	}
}

if(!function_exists('api_parse_language'))
{
	function api_parse_language($line)
	{
		$lang = array(
			'ass',
			'shit',
			'fuck',
			'damn',
			'hell',
			'asshole',
			'fucker',
			'motherfucker',
			'bitch',
			'goddamn',
			'damnit',
			'goddamnit',
		);

		$words = '';
		foreach($lang as $word)
		{
			$words .= $word.'|';
		}
		$words = rtrim($words, '|');

		$regex = '/\b('.$words.')\b/i';

		$line = preg_replace_callback($regex, function($m)
		{
			return str_repeat('*', strlen($m[0]));
		}, $line);

		return $line;
	}
}
/* ------- END: API Helpers ------- */

if(!function_exists('carbon_date'))
{
	function carbon_date($timestamp)
	{
		return \Carbon\Carbon::createFromTimestamp(strtotime($timestamp));
	}
}

if(!function_exists('carbon_human'))
{
	function carbon_human($timestamp)
	{
		return carbon_date($timestamp)->diffForHumans();
	}
}