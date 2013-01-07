@layout('layout.logged')

@section('content')
<div class="content-wrapper hasleft">
<div id="left-content">
<ul class="section">
<li class="title"><div class="title-text">My Menu!</div><div class="title-roof"></div></li>

<li class="bullet">
<ul>
<li class="bullet-text bubbleTrigger" data-href="/student/subject/" data-target="subjectFlyout">
<a>Subjects</a>
</li>
<li class="bubble-wrapper" id="subjectFlyout">
<ul class="bubble">                    
<li class="bubble-caret">
<div class="caret-outer" ></div>
<div class="caret-inner" ></div>
</li>
<li class="bubble-item">
<ul>
	<li><div class="subjectComposeShrct"><a id="addNewSubject" href="#">New Subject</a></div></li>
	@forelse (Subject::your_subjects() as $s)
	<li class="subj-item">{{  HTML::link_to_route('subject_show', $s->code . '	 ' .$s->name, array($s->id)) }}</li>
	@empty
	<li>
		<div class="emptyContent">
			<span>You don't have any subject yet.</span>
		</div>
	</li>
	@endforelse
</ul>

</li>
</ul>
</li>
</ul>
</li>

<li class="bullet">
<ul>
<li class="jewel-notify">{{ Auth::user()->get_message_jewel() }}</li>
<li class="bullet-text bubbleTrigger" data-href="/message/" data-target="messageFlyout">
<a>Messages</a>
</li>
<li class="bubble-wrapper" id="messageFlyout">
<ul class="bubble">                    
<li class="bubble-caret">
<div class="caret-outer" ></div>
<div class="caret-inner" ></div>
</li>
<li class="bubble-item">
<ul>
	<li>
		<div class="messageComposeShrct">
			<a class="composeNewMsg" href="#">Compose New</a>
		</div>
	</li>
	@forelse (Directmessage::your_messages() as $m)
	<li>
		<a class="{{ (!$m->has_read) ? 'unread' : '' }} messageContent" href="/messages/{{ $m->id }}">
			<div class="clearfix">
				<div class="imgPrev">
					<img class="thumb" src="{{ Config::get('application.custom_img_thumbs_url')}}{{ $m->sender->img_url }}" width="50px" height="50px">
				</div>
				<div class="cData">
					<div class="author">
						<strong>{{ $m->sender->name }}</strong>
					</div>
					<div class="snippet">
						<span>
							{{ $m->subject }}
						</span>
					</div>
					<abbr title="Tuesday" data-utime="0" class="timestamp">Tues
					</abbr>
				</div>
			</div>
		</a>
	</li>
	@empty
	<li>
		<div class="emptyContent">
			<span>You don't have any message yet.</span>
		</div>
	</li>
	@endforelse
	<li>
		<div class="messageViewAll">
			{{ HTML::link_to_route('messages', 'View All') }}
		</div>
	</li>
</ul>

</li>
</ul>
</li>
</ul>
</li>
</ul>
@yield('left')
</div>
<div class="right-content">
@yield('right')
</div></div>
@endsection

@section('jslibs')
{{ HTML::script('js/libs/essentials.js') }}
@endsection

@section('jslogged')
{{ HTML::script('js/views/hasleft.js') }}
@yield('jshasleft')
@endsection