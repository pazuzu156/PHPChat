@if($log = api_get_log())
	@foreach($log->results() as $msgln)
		<?php $prefs = \Core\Database::init()->get('prefs', ['username', '=', user()->username]) ?>
		<div class="msgln">
			({{ carbon_date($msgln->posttime)->toDateTimeString() }})
			<b>
				<span style="color:{{ prefs($msgln->username)->username_color }};">
					{{ $msgln->username }}
				</span>
			</b>: {{ api_parse_log($msgln->message) }}
			<br/>
		</div>
	@endforeach
@endif