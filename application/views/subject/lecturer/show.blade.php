@layout('layout.hasleft')


@section('jshasleft')
{{ HTML::script('js/views/subject.js') }}
@endsection

@section('right')
<div class="clearfix">
<div class="rSide">
	<div class="title">User's List</div>
	<ul class="userList">
		@foreach($subject->get_only_onlineusers() as $s)
		<li class="userContainer {{ ($s->usertype_id == 2) ? 'lecturer' : '' }}">
			<a href="#" title="{{ $s->name }}"><div class="indicator online"></div>{{ $s->name }}</a>
		</li>
		@endforeach
		@foreach($subject->get_only_offlineusers() as $s)
		<li class="userContainer {{ ($s->usertype_id == 2) ? 'lecturer' : '' }}">
			<a href="#" title="{{ $s->name }}"><div class="indicator"></div>{{ $s->name }}</a>
		</li>
		@endforeach
	</ul>
</div>
<div class="hasRight">
	<h2 style="text-align:center;">Welcome To {{ $subject->code }}</h2>
	<h3 style="text-align:center;">{{ $subject->name }}</h3>
	<div style="text-align:right; margin-bottom:5px;"><a id="subjectSetting" class="btn btn-nicewhite" data-id="{{ $subject->id }}" href="#">Subject Settings</a></div>
	<ul class="student-update">
	     <li class="header">Lecturer's Announcements<a class="actionOnTitle" id="newAnnounce" href="#">New Announcement</a></li>
	     <li class="body">
	     	<ul>
	        @forelse ($subject->get_only_announcements() as $a)
		         <li class="update-item">
			         <ul>
			             <li class="titlebar"><span class="cls">{{ $subject->code }}</span><span class="time">{{ $a->created_at }}</span><span class="poster"><span class="hovercard" data-template="userHoverTmpl">
			             	<?php echo $a->poster->user->name; ?>
<div class="hovercard-item">
<a href="/users/{{ $a->poster->user->id }}">
	<div class="clearfix">
		<div class="imgPrev">
			<img class="thumb" src="{{ Config::get('application.custom_img_thumbs_url')}}{{ $a->poster->user->img_url }}" width="25px" height="25px">
		</div>
		<div class="cData">
			<div class="author">
				<strong>{{ $a->poster->user->name }}</strong>
			</div>
		</div>
	</div>
</a>
<div class="panel">
	<a href="/messages/new/{{ $a->poster->user->id }}"><img src="/img/message_ico.png" /></a>
</div>
</div>
			             </span></span></li>
			             <li class="messagebar"><?php echo $a->message; ?></li>
			             <li class="attachmentbar">
			             	@if($a->has_attachment)
			             	<div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment->filename }}" rel="nofollow">{{ $a->attachment->filename }}</a>
			             	@endif
			             </li>
			         </ul>
			     </li>
		         @empty
		         	<li class="no-item"><span>You have no announcement yet</span></li>
		         @endforelse
	         <?php
	         /**
	          * $a as announcement item
	          * attributes:
	          * code - subject code
	          * time - announcement time
	          * poster - poster
	          * body - announcement conent
	          **/
	         ?>
	     </ul>
	     </li>
	 </ul>
	 <ul class="student-update">
	     <li class="header">Discussion board<a class="actionOnTitle" id="newPost" href="#">Post New</a></li>
	     <li class="body">
	         <ul>
		         @forelse ($subject->get_only_discussions() as $a)
		         <li class="update-item">
			         <ul class="{{ ($a->poster->usertype_id == 2) ? 'lect' : ''  }}">
			             <li class="titlebar"><span class="cls">{{ $subject->code }}</span><span class="time">{{ $a->created_at }}</span><span class="poster"><a href="/users/{{ $a->poster->id }}" ><?php echo $a->poster->name; ?></a></span></li>
			             <li class="messagebar"><?php echo $a->message; ?></li>
			             <li class="attachmentbar">
			             	@if($a->has_attachment)
			             	<div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment->filename }}" rel="nofollow">{{ $a->attachment->filename }}</a>
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
	<ul class="groupsetting-form">
	{{ Form::open('/subjects/settings') }}
	{{ Form::token() }}
	<li class="inlinefields clearfix">
		<label>Max groups in class: </label>
		<select name="max_groups">
			<%= maxgroups %>
		</select>
	</li>
	<li class="inlinefields clearfix">
		<label>Max students per group: </label>
		<select name="max_students">
			<%= maxstudents %>
		</select>
	</li>
	<li><span>Mode: </span></li>
	<li>
		<ul class="radiooptions clearfix">
		<li class="labelfix clearfix">
			<input id="mode1" type="radio" name="mode" value="1" <%= (mode == 1) ? 'checked' : '' %> /><label for="mode1">&nbsp;Manual&nbsp;&nbsp;</label>
		</li>
		<li class="labelfix clearfix">
			<input id="mode2" type="radio" name="mode" value="2" <%= (mode == 2) ? 'checked' : '' %> /><label for="mode2">&nbsp;Auto&nbsp;&nbsp;</label>
		</li>
		</ul>
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
@endsection