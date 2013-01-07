@layout('layout.hasleft')


@section('right')
<div id="messageContent">
<h2>Message</h2>
<a style="font-weight:bold; font-size:14px" href="/messages/sents">&lt; back</a>
<div class="messagesWrapper">
	<ul class="messageContainer">
		{{ Form::open('messages/sents', 'DELETE')}}
		{{ Form::token() }}
		<li><button class="delete-ico"></button></li>
		<li><strong>To: </strong><div>{{ $message->receiver->name }}</div></li>
		<li><strong>Subject: </strong><div>{{ $message->subject }}</div></li>
		<li><div class="msgBody">{{ $message->message }}</div></li>
		{{ Form::hidden('id', $message->id)}}
		{{ Form::close() }}
	</ul>
</div>
</div>
@endsection
