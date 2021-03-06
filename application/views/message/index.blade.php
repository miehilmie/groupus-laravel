@layout('layout.hasleft')



@section('jshasleft')
{{ HTML::script('js/views/message.js') }}
@endsection

@section('right')
<div id="messageContent">
<h1>Messages - Inbox</h1>
<div style="text-align:right; margin-bottom:7px; margin-right:15px">
<a class="btn btn-niceblue" href="/messages/sents">Sent Item</a>
<a class="composeNewMsg btn btn-niceblue" href="#">Compose New</a>
</div>
<ul class="messagesWrapper">
@if($messages->results)
<div style="min-height:430px">
	@foreach($messages->results as $m)
	<li class="messageItem">
		<div class="clearfix">
			<div class="imgPrev">
				<img src="{{ Config::get('application.custom_img_thumbs_url')}}{{ $m->sender->img_url }}" width="50px" height="50px" />
			</div>
			<div class="cData">
				<div class="author"><a href="/users/{{ $m->sender->id }}"><strong class="">{{ $m->sender->name }}</strong></a></div>
				<div clas="snippet clearfix"><span>{{ $m->subject }}</span>
					<ul class="rightMenu cleafix">
					<li>
						{{ Form::open('messages','DELETE') }}
						{{ Form::token() }}
						<div class="btn-group">
							{{ HTML::link_to_route('message', 'View', array($m->id), array('class' => 'btn btn-warning')) }}
							<button class="btn btn-danger">Delete</button>
						</div>
						{{ Form::hidden('id', $m->id) }}
						{{ Form::close() }}
					</li>
					</ul>
				</div>
			</div>
		</div>
	</li>
	@endforeach
</div>
	{{ $messages->links() }}
@else
<div id="oopsmsg">
	<li><img src="/img/oops.png" /></li>
	<li>
		Oops.. It seems like no one has sent you a message! Initiate them first!
	</li>
	<li>
		{{ HTML::link_to_route('new_message', 'Send Them Message!') }}
	</li>
</div>
@endif
<ul>
</div>
@endsection