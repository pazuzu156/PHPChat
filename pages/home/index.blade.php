@extends('layout.main')

@section('content')

	@if(!session_has('chat_login'))
		{{ redir('users.login') }}
	@endif

	<div id="wrapper">
		<p class="version">Client v{{ config()->get('version') }}</p>
		<div id="menu">
			<p class="welcome">Welcome <strong>{{ user()->username }}</strong>!</p>
			<p class="nav"><a href="#kb-init">Preferences</a> | <a href="{{ get_url('users.logout') }}">Logout</a></p>
			<div style="clear:both;"></div>
		</div>
		<div id="chatbox"></div>
		<div id="users">
			<p style="text-align:center;text-decoration:underline;font-weight:bold;">
				Online Users
			</p>
		</div>
		<div style="clear:both;"></div>
		<form name="message" action="" autocomplete="off">
			<div id="emo">
				<a href="javascript:Smiles(':angry:');" class="emote">{{ emote('angry.gif', 'angry', ':angry:') }}</a>
				<a href="javascript:Smiles(':arrow:');" class="emote">{{ emote('arrow.gif', 'arrow', ':arrow:') }}</a>
				<a href="javascript:Smiles(':))');" class="emote">{{ emote('biggrin.gif', 'big grin', ':))') }}</a>
				<a href="javascript:Smiles(';;)');" class="emote">{{ emote('blink.gif', 'blink', ';;)') }}</a>
				<a href="javascript:Smiles('8)');" class="emote">{{ emote('cool.gif', 'cool', '8)') }}</a>
				<a href="javascript:Smiles(':dunno:');" class="emote">{{ emote('dry.gif', 'dry', ':dunno:') }}</a>
				<a href="javascript:Smiles(':!:');" class="emote">{{ emote('exclamation.gif', 'exclamation', ':!:') }}</a>
				<a href="javascript:Smiles('0.o');" class="emote">{{ emote('huh.gif', 'huh', '0.o') }}</a>
				<a href="javascript:Smiles(':D');" class="emote">{{ emote('laugh.gif', 'laugh', ':D') }}</a>
				<a href="javascript:Smiles(':o');" class="emote">{{ emote('ohmy.gif', 'oh my', ':o') }}</a>
				<a href="javascript:Smiles(':ninja:');" class="emote">{{ emote('ph34r.gif', 'ninja', ':ninja:') }}</a>
				<a href="javascript:Smiles(':puke:');" class="emote">{{ emote('puke.gif', 'puke', ':puke:') }}</a>
				<a href="javascript:Smiles(':??:');" class="emote">{{ emote('question.gif', 'question', ':??:') }}</a>
				<a href="javascript:Smiles(':we:');" class="emote">{{ emote('rolleyes.gif', 'roll eyes', ':we:') }}</a>
				<a href="javascript:Smiles(':(');" class="emote">{{ emote('sad.gif', 'sad', ':(') }}</a>
				<a href="javascript:Smiles(':)');" class="emote">{{ emote('smile.gif', 'smile', ':)') }}</a>
				<a href="javascript:Smiles(':p');" class="emote">{{ emote('tongue.gif', 'tongue', ':p') }}</a>
				<a href="javascript:Smiles(':123:');" class="emote">{{ emote('unsure.gif', 'unsure', ':123:') }}</a>
				<a href="javascript:Smiles(';)');" class="emote">{{ emote('wink.gif', 'wink', ';)') }}</a>
			</div>
			<input name="usermsg" id="usermsg" size="63" type="text">
			<input type="submit" name="submitmsg" id="submitmsg" value="Send">
			<input type="hidden" name="username" id="username" value="{{ user()->username }}">
		</form>
		<div style="clear:both;"></div>
		@if(is_admin())
			<a href="#" id="clear">Clear Chat History</a>
		@endif
	</div>
	<div name="kb-modal" title="Preferences">
		<p>Not in working order yet!</p>
	</div>
	
@stop