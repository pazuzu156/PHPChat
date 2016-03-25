@if($log = api_get_log())
	@foreach($log->results() as $msgln)
		<div class="msgln">
			({{ carbon_date($msgln->posttime)->toDateTimeString() }})
			<b>{{ $msgln->username }}</b>: {{ api_parse_log($msgln->message) }}
			<br/>
		</div>
	@endforeach
@endif