@layout('layout.hasleft')


@section('right')
<div id="messageContent">
<h2>Message</h2>
<a style="font-weight:bold; font-size:14px" href="/messages">&lt; back</a>
<div class="messagesWrapper">
	<ul class="messageContainer">
		{{ Form::open('messages', 'DELETE')}}
		{{ Form::token() }}
		<li><a href="{{ URL::to_route('reply_message',$message->sender->id) }}"><span class="reply-ico"></span></a><button class="delete-ico"></button></li>
		<li><strong>From: </strong><div>{{ $message->sender->name }}</div></li>
		<li><strong>Subject: </strong><div>{{ $message->subject }}</div></li>
		<li><div class="msgBody">{{ $message->message }}</div></li>
		{{ Form::hidden('id', $message->id)}}
		{{ Form::close() }}
	</ul>
</div>
</div>
@endsection
