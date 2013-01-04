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
		{{ Form::submit('Send', array('class' => 'btn btn-niceblue')) }}
	</p>
	{{ Form::close() }}
</script>

<script type="text/template" id="newSubjectTmpl">
	<h3> Subject Enrollment </h3>
	{{ Form::open('subjects/enroll', 'POST') }}
	{{ Form::token() }}

	<p>
		<label for="subject1">Subject 1: </label><select class="subjectSelect" name="subject1"><%= subjects %></select>
	</p>
	<p>
		<label for="subject2">Subject 2: </label><select class="subjectSelect" name="subject2"><%= subjects %></select>
	</p>
	<p>
		<label for="subject3">Subject 3: </label><select class="subjectSelect" name="subject3"><%= subjects %></select>
	</p>
	<p>
		<label for="subject4">Subject 4: </label><select class="subjectSelect" name="subject4"><%= subjects %></select>
	</p>
	<p>
		{{ Form::hidden('redirect', URL::current()) }}
		{{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
	</p>
	{{ Form::close() }}
</script>

<script type="text/template" id="newPostSubjectTmpl">
	<h3> Post anything.. </h3>
	{{ Form::('/subjects/posts') }}
	{{ Form::token() }}
	<textarea></textarea><br /><br /><br />
	<div class="clearfix" style="float:right;">
		{{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
	</div>
	{{ Form::hidden('redirect', URL::current()) }}
	{{ Form::close() }}
</script>