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
			                    	@forelse (Subject::your_subjects() as $s)
			                    		<li>{{  HTML::link_to_route('subject_show', $s->code . '	 ' .$s->name, array($s->id)) }}</li>
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
			                    	<li><div class="messageComposeShrct"><a id="composeNewMsg" href="#" data-href="newMessageTmpl">Compose New</a></div></li>
			                    	@forelse (Directmessage::your_messages() as $m)
										<li>
				                    		<a class="messageContent" href="/messages/1">
				                    			<div class="clearfix">
				                    				<div class="imgPrev">
				                    					<img class="thumb" src="/uploads/1/thumbs/default.jpg" width="50px" height="50px">
				                    				</div>
				                    				<div class="cData">
				                    					<div class="author"><strong>{{ $m->sender->name }}</strong></div>
				                    					<div class="snippet">
				                    						<span>
				                    							{{ $m->subject }}
				                    						</span>
				                    					</div>
				                    					<abbr title="Tuesday" data-utime="0" class="timestamp">Tues</abbr>
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
			                    	<li><div class="messageViewAll">{{ HTML::link_to_route('messages', 'View All') }}</a></div></li>
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
<script type="text/template" id="newMessageTmpl">
<h3> Compose new message </h3>
{{ Form::open('messages', 'POST') }}
{{ Form::token() }}
<p> {{ Form::label('msgto', 'To: ') }}
{{ Form::select('msgto', array('1' => 'Muhammad Hilmi', '2' => 'Muhammad Hilmie')); }}
</p>
<p>
{{ Form::label('msgsubject', 'Subject: ') }}
{{ Form::text('msgsubject', ''); }}
</p>
<p>
{{ Form::label('msgbody', 'Message: ') }}<br />
{{ Form::textarea('msgbody', '') }}

</p>
<p>
{{ Form::submit('Send') }}
</p>
{{ Form::close() }}
</script>
{{ HTML::script('js/common.js') }}
{{ HTML::script('js/hasleft.js') }}
@endsection