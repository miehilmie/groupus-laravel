@layout('layout.hasleft')


@section('jshasleft')
{{ HTML::script('js/views/subject.js') }}
@endsection

@section('right')
<div class="clearfix">
<div class="rSide">
	<div class="title">User's List</div>
	<ul class="userList">
		@foreach($subject->subject_onlineusers() as $s)
		<li class="userContainer {{ ($s->usertype_id == 2) ? 'lecturer' : '' }}">
			<a class="{{ ($s->id != $user->id) ? 'openchat' : '' }}" data-id="{{ $s->id }}" href="#" title="{{ $s->name }}"><div class="indicator {{ $s->status }}"></div>{{ $s->name }}</a>
		</li>
		@endforeach
	</ul>
</div>
<div class="hasRight">
	<h2 style="text-align:center;">Welcome To {{ $subject->code }}</h2>
	<h3 style="text-align:center;">{{ $subject->name }}</h3>
	<div style="text-align:right; margin-bottom:5px;"><a class="subjectSetting btn btn-nicewhite" data-id="{{ $subject->id }}" href="#">Subject Settings</a></div>
	<ul class="student-update">
	     <li class="header">Lecturer's Announcements<a class="actionOnTitle" id="newAnnounce" href="#">New Announcement</a></li>
	     <li class="body">
	     	<ul>
	        @forelse ($subject->subject_announcements() as $a)
		         <li class="update-item">
			         <ul>
			             <li class="titlebar"><span class="cls">{{ $subject->code }}</span><span class="time">{{ $a->created_at }}</span>
			             	<span class="poster">
			             		<span class="hovercard" data-id="{{ $a->poster_user_id }}" href="/users/{{ $a->poster_user_id }}" data-template="userHoverTmpl">
			             			<?php echo $a->poster_user_name; ?>
			             		</span>
			             	</span></li>
			             <li class="messagebar"><?php echo $a->message; ?></li>
			             <li class="attachmentbar">
			             	@if($a->has_attachment)
			             	<div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment_filename }}" rel="nofollow">{{ $a->attachment_filename }}</a>
			             	@endif
			             </li>
			         </ul>
			     </li>
		         @empty
		         	<li class="no-item"><span>You have no announcement yet</span></li>
		         @endforelse
	     </ul>
	     </li>
	 </ul>
	 <ul class="student-update">
	     <li class="header">Discussion board<a class="actionOnTitle" id="newPost" href="#">Post New</a></li>
	     <li class="body">
	         <ul>
		         @forelse ($subject->subject_discussions() as $a)
		         <li class="update-item">
			         <ul class="{{ ($a->poster_usertype_id == 2) ? 'lect' : ''  }}">
						<li class="titlebar"><span class="cls">{{ $subject->code }}</span><span class="time">{{ $a->created_at }}</span><span class="poster">
				             	<span class="hovercard" data-id="{{ $a->poster_user_id }}" href="/users/{{ $a->poster_user_id }}" data-template="userHoverTmpl">
			             			<?php echo $a->poster_user_name; ?>
			             		</span>
			         </span></li>
			             <li class="messagebar"><?php echo $a->message; ?></li>
			             <li class="attachmentbar">
			             	@if($a->has_attachment)
			             	<div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment_filename }}" rel="nofollow">{{ $a->attachment_filename }}</a>
			             	@endif
			             </li>
			         </ul>
			     </li>
		         @empty
		         	<li class="no-item"><span>You have no update</span></li>
		         @endforelse
	         </ul>
	     </li>
	 </ul>
</div>
</div>
@endsection

@section('left')
		<ul class="section">
		    <li class="title"><div class="title-text">Subject Menu!</div><div class="title-roof"></div></li>
			@if($hasgroup)
			<li class="bullet">
			    <ul><li class="bullet-text group-wrap" data-href="/message/">
			            <a id="viewGroup" data-id="{{ $subject->id }}" >View Student Groups</a></li>
			    </ul>
			</li>
			@else
			<li class="bullet">
			    <ul><li class="bullet-text group-wrap" data-href="/message/">
			            <a class="subjectSetting" data-id="{{ $subject->id }}" >Subject Settings</a></li>
			    </ul>
			</li>
			@endif
		</ul>
@endsection

@section('pagespecific-templates')
<script type="text/template" id="newPostSubjectTmpl">
	<h3> Post anything.. </h3>
	{{ Form::open_for_files('/subjects/posts') }}
	{{ Form::token() }}
	<textarea name="message"></textarea><br /><br />
	<span>Attachment: </span><br/>
	{{ Form::file('attachment') }}
	<br /><br />
	<div class="clearfix" style="float:right;">
		{{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
	</div>
	<input type="hidden" name="id" value="{{ $subject->id }}" />
	{{ Form::hidden('redirect', URL::current()) }}
	{{ Form::close() }}
</script>

<script type="text/template" id="subjectSettingTmpl">
	<br />
	<h3> Subject Setting </h3>
	<p>Number of students&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<%= n_students %></p><br />

	<ul class="groupsetting-form">
	{{ Form::open('/subjects/settings') }}
	{{ Form::token() }}
	<li class="inlinefields clearfix">
		<label>Number of groups in class: </label>
		<select name="max_groups">
			<%= maxgroups %>
		</select>
	</li>
	<li><span>Mode: </span></li>
		<ul class="radiooptions clearfix">
			<li class="labelfix clearfix">
				<input id="mode1" type="radio" name="mode" value="1" <%= (mode == 1) ? 'checked' : '' %> /><label for="mode1">&nbsp;Manual&nbsp;&nbsp;</label>
			</li>
			<li class="labelfix clearfix">
				<input id="mode2" type="radio" name="mode" value="2" <%= (mode == 2 || mode == 3) ? 'checked' : '' %> /><label for="mode2">&nbsp;Auto&nbsp;&nbsp;</label>
			</li>
		</ul>
	</li>
	<li class="inlinefields clearfix auto-extras <%= (mode != 1) ? 'hidden' : '' %>">
		<label>Max students per group: </label>
		<select name="max_students">
			<%= maxstudents %>
		</select>
	</li>
	<li class="inlinefields clearfix auto-extras <%= (mode == 1) ? 'hidden' : '' %>">
		<label>Based on: </label>
		<select name="characteristic">
			<option value="0" <%= (mode == 2) ? 'selected' : '' %>>CGPA</option>
			<option value="1" <%= (mode == 3) ? 'selected' : '' %>>Distance from Campus</option>
		</select>
	</li>
	<li class="inlinefields clearfix">
		<label>Group Prefix Name: </label>
		<input name="prefix" type="text" />
	</li>
	<br /><br />
	{{ Form::submit('Generate', array('class' => 'ajaxGenerate btn btn-success')) }}

	<input type="hidden" name="id" value="{{ $subject->id }}" />
	{{ Form::hidden('redirect', URL::current()) }}
	{{ Form::close() }}
	</ul>
</script>
<script type="text/template" id="newPostAnnounceTmpl">
	<h3> Post announcement.. </h3>
	{{ Form::open_for_files('/subjects/announcements') }}
	{{ Form::token() }}
	<textarea name="message"></textarea><br /><br />
	<span>Attachment: </span><br/>
	{{ Form::file('attachment') }}
	<br /><br />
	<div class="clearfix" style="float:right;">
		{{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
	</div>
	<input type="hidden" name="id" value="{{ $subject->id }}" />
	{{ Form::hidden('redirect', URL::current()) }}
	{{ Form::close() }}
</script>

<script type="text/template" id="viewGroupTmpl">
	<h3> Select Group: </h3>
	{{ Form::open('/subjects/groups') }}
	{{ Form::token() }}
	<table>
		<tr><td>Number of groups&nbsp;&nbsp;&nbsp;</td><td>:</td><td><%= ngroup %></td></tr>
		<tr><td>Number of student per group&nbsp;&nbsp;&nbsp;</td><td>:</td><td><%= maxstudents %></td></tr>
	</table>
	<dl class="accordion">

	<%= group_list %>


	</dl>
	<br /><br />
	<div class="clearfix" style="float:right;">
		{{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
	</div>
	<input type="hidden" name="id" value="{{ $subject->id }}" />
	{{ Form::hidden('redirect', URL::current()) }}
	{{ Form::close() }}
</script>

<script type="text/template" id="groupTmpl">
<dt><a href=""><%= group_name %></a></dt>
	<dd>
		<ul>
			<%= group_userlist %>
		</ul>
</dd>
</script>

<script type="text/template" id="userGroupTmpl">
<li>
	<div class="userGroupContent">
		<div class="clearfix">
			<div class="imgPrev">
				<img class="thumb" src="{{ Config::get('application.custom_img_thumbs_url')}}<%= img_url %>" width="25px" height="25px">
			</div>
			<div class="cData">
				<div class="author">
					<strong  class="hovercard" data-id="<%= id %>"  data-template="userHoverTmpl" href="/users/<%= id %>"><%= name %></strong>
				</div>
			</div>
		</div>
	</div>
</li>
</script>
@endsection