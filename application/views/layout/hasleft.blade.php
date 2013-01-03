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
			                    	<li><div class="subjectComposeShrct"><a id="addNewSubject" href="#">Add New Subject</a></div></li>
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
			                    	<li><div class="messageComposeShrct"><a id="composeNewMsg" href="#">Compose New</a></div></li>
			                    	@forelse (Directmessage::your_messages() as $m)
										<li>
				                    		<a class="messageContent" href="/messages/{{ $m->id }}">
				                    			<div class="clearfix">
				                    				<div class="imgPrev">
				                    					<img class="thumb" src="/uploads/thumbs/{{ $m->sender->img_url }}" width="50px" height="50px">
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
<select name="msgto"><%= users %></select>
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
<script type="text/template" id="newSubjectTmpl">
<h3> Compose new message </h3>
{{ Form::open('subjects', 'POST') }}
{{ Form::token() }}

<p> {{ Form::label('faculty', 'Faculty: ') }}
<select name="faculty"><%= users %></select>
</p>
<p>
<label for="subject1">Subject 1: </label><select class="subjectSelect" name="subject1"><option value="-1">----- NONE -----</option></select>
</p>
<p>
<label for="subject2">Subject 2: </label><select class="subjectSelect" name="subject2"><option value="-1">----- NONE -----</option></select>
</p>
<p>
<label for="subject3">Subject 3: </label><select class="subjectSelect" name="subject3"><option value="-1">----- NONE -----</option></select>
</p>
<p>
<label for="subject4">Subject 4: </label><select class="subjectSelect" name="subject4"><option value="-1">----- NONE -----</option></select>
</p>
<p>
{{ Form::submit('Submit') }}
</p>
{{ Form::close() }}
</script>
{{ HTML::script('js/underscore-min.js') }}
{{ HTML::script('js/common.js') }}
{{ HTML::script('js/hasleft.js') }}
@endsection