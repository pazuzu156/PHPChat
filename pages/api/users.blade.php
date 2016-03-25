<p style="text-align:center;text-decoration:underline;font-weight:bold">
	Online Users
</p>

@if($users = api_get_users())
	@foreach($users->results() as $user)
		@if($user->admin)
			{{ $user->username }} (Admin)<br>
		@else
			{{ $user->username }}<br>
		@endif
	@endforeach
@endif