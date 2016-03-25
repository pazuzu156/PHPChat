@extends('layout.main')

@section('content')

	@if(session_has('chat_login'))
		{{ redir('') }}
	@endif

	@if(input_get('login'))
		{{ login_user() }}
	@endif

	<div id="loginform">
		<form action="{{ get_url('users.login') }}" method="post" autocomplete="off">
			<span class="version">Client v {{ config()->get('version') }}</span>
			<table align="center">
				@if(session_has('emsg'))
					<tr>
						<td colspan="2">
							<span class="error">{{ flash('emsg') }}</span>
						</td>
					</tr>
				@elseif(session_has('smsg'))
					<tr>
						<td colspan="2">
							<span class="success">{{ flash('smsg') }}</span>
						</td>
					</tr>
				@endif
				<tr>
					<td><label for="username">Username:</label></td>
					<td><input type="text" id="username" name="username"></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" id="password" name="password"></td>
				</tr>
				<tr>
					<td><input type="submit" name="login" value="Login" id="login"></td>
					<td><a href="{{ get_url('users.register') }}">Register</a></td>
				</tr>
			</table>
		</form>
	</div>

@stop