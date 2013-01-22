<script type="text/template" id="newMessageTmpl">
	<h3> Compose new message </h3>
	{{ Form::open('messages', 'POST') }}
	{{ Form::token() }}

	<div> {{ Form::label('msgto', 'To: ') }}
		<div class="ajaxSearchUser">
			<input type="text" name="searchuser" />
			<ul class="ajaxSearchUserList"></ul>
		</div>
	</div>
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
	{{ Form::hidden('redirect', URL::current()) }}
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
<script type="text/template" id="searchUserTmpl">
	<li data-id="<%= id %>" title="<%= name %>">
    <div class="clearfix">
        <div class="imgPrev">
            <img class="thumb" src="{{ Config::get('application.custom_img_thumbs_url')}}<%= img_url %>" width="25px" height="25px">
        </div>
        <div class="cData">
            <div class="author">
                <strong><%= name %></strong>
            </div>
        </div>
    </div>
	</li>
</script>

<script type="text/template" id="chatBodyTmpl">
            <div class="chat-jewel"><span style="<%= (jewel === 0) ? 'display:none;' : '' %>"><%= jewel %></span></div>
            <div id="<%= chatid %>" class="chat <%= toggle %>">
                <div class="title clearfix"><a class="chatclose" href="#">X</a><span><%= receivername %></span></div>
                <div class="body">
                    <ul>
                    	<%= chats %>
                    </ul>
                </div>
                <div class="chatmessage"><input type="text" /></div>
            </div>
</script>

<script type="text/template" id="userHoverTmpl">
<div class="hovercard-inside" id="hovercardid-<%= id %>">
    <div class="clearfix">
        <div class="imgPrev">
            <img class="thumb" src="{{ Config::get('application.custom_img_thumbs_url')}}<%= img_url %>" width="30px" height="30px">
        </div>
        <div class="cData">
            <div class="author">
                <a href="/users/<%= id %>"><strong><%= name %></strong></a><br/>
                    <% var i; for(i = 0; i < 5; i++) { %>
                    <% if(i < starvalue) { %>
                        <span class="starsml filled" data-value="<%= i + 1 %>"></span>
                    <% } else { %>
                        <span class="starsml" data-value="<%= i + 1 %>"></span>
                    <% }} %>
            </div>
        </div>
    </div>
<div class="panel">
    <a class="message-ico" href="/messages/new/<%= id %>"><img src="/img/message_ico.png" /></a>
</div>
</div>
</script>