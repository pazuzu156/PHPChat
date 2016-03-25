@extends('layout.main')

@section('content')

	@if(session_has('chat_login'))
		{{ redir('') }}
	@endif

	@if(input_get('register'))
		{{ register_user() }}
	@endif

	<div id="loginform">
		<form action="{{ get_url('users.register') }}" method="post" autocomplete="off">
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
					<td><label for="name">Full Name:</label></td>
					<td><input type="text" id="name" name="name"></td>
				</tr>
				<tr>
					<td><label for="username">Username:</label></td>
					<td><input type="text" id="username" name="username"></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
					<td><input type="password" id="password" name="password"></td>
				</tr>
				<tr>
					<td><label for="cpass">Confirm Password:</label></td>
					<td><input type="password" id="cpass" name="cpass"></td>
				</tr>
				<tr>
					<td><input type="submit" name="register" value="Register" id="register"></td>
					<td><a href="{{ get_url('users.login') }}">Login</a></td>
				</tr>
			</table>
		</form>
	</div>

@stop