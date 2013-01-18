@layout('layout.hasleft')



@section('right')
<div id="messageContent">
<h2>Message</h2>
<div class="messagesWrapper">
	@if($errors->has())
	    <div class="errormsg-textonly">
	        @foreach ($errors->all('<p>*:message</p>') as $e)
	        {{ $e }}
	        @endforeach
	    </div>
	@endif
	@if($success = Session::get('success'))
	<div class="successmsg">
	    <p>{{ $success }}</p>
	</div>
	@endif
	<ul class="messageContainer">
		{{ Form::open('messages', 'POST')}}
		{{ Form::token() }}
		<li><button class="btn btn-niceblue">Send</button>&nbsp;<a href="/messages" class="btn btn-niceblue">Discard</a></li>
		<li><strong>To: </strong><div class="newMsg">
			@if(!($newuser))
			<div class="ajaxSearchUser">
				<input type="text" name="searchuser" />
				<ul class="ajaxSearchUserList"></ul>
			</div>
		@else{{ $newuser->name }}@endif</div></li>
		<li><strong>Subject: </strong><div class="newMsg"><input type="text" name="msgsubject" /></div></li>
		<li><textarea name="msgbody" class="msgBody">{{ Input::old('msgbody') }}</textarea></li>
		@if($newuser)
		{{ Form::hidden('msgto', $newuser->id)}}
		@endif
		{{ Form::close() }}
	</ul>
</div>
</div>
@endsection