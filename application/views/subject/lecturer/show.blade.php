@layout('layout.hasleft')


@section('jshasleft')
{{ HTML::script('js/views/subject.js') }}
@endsection

@section('right')
<div class="clearfix">
<div class="rSide">
	<div class="title">User's List</div>
	<ul class="userList">
		@foreach($subject->get_only_students_and_lecturers() as $s)
		<li class="userContainer {{ ($s->usertype_id == 2) ? 'lecturer' : '' }}">
			<a href="#" title="{{ $s->name }}"><div class="indicator online"></div>{{ $s->name }}</a>
		</li>

		@endforeach
		<!-- <li class="userContainer">
			<a href="#" title="Mohd Farid bin Rossle"><div class="indicator"></div>Mohd Farid bin Rossle</a>
		</li>
		<li class="userContainer">
			<a href="#" title="Syuhaida Ahmad Ariffin"><div class="indicator"></div>Syuhaida Ahmad Ariffin</a>
		</li> -->
	</ul>
</div>
<div class="hasRight">
	<h2 style="text-align:center;">Welcome To {{ $subject->code }}</h2>
	<h3 style="text-align:center;">{{ $subject->name }}</h3>
	<div style="text-align:right; margin-bottom:5px;"><a id="subjectSetting" class="btn btn-nicewhite" data-id="{{ $subject->id }}" href="#">Subject Settings</a></div>
	<ul class="lecturer-announcement">
	     <li class="header">Lecturer's Announcements<a class="actionOnTitle" id="newAnnounce" href="#">New Announcement</a></li>
	     <li class="body">
	         @forelse ($announcements as $a)
		         <ul class="announcement-item">
		             <li class="item-1"><span class="cls"><?php echo $a->code ?></span><span class="time"><?php echo $a->time; ?></span><span class="poster"><?php echo $a->poster; ?></span></li>
		             <li class="item-2"><?php echo $a->body; ?></li>
		         </ul>
	         @empty
	         	<div><span>You have no announcement yet</span></div>
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

@section('left')
		<ul class="section">
		    <li class="title"><div class="title-text">My Group!</div><div class="title-roof"></div></li>
			@forelse($groups as $g)
			<li class="bullet">
			    <ul><li class="bullet-text" data-href="/message/">
			            <a>Group 1</a></li>
			    </ul>
			</li>
			@empty
			<li class="empty">
				<span>No group yet!</span>
			</li>
			@endforelse
		</ul>
		<!-- 
		<ul class="section">
		    <li class="title"><div class="title-text">Search!</div><div class="title-roof"></div></li>
			<li class="searchbox">
				<span>Search:</span>
				<ul class="searchoptions clearfix">
				<li class="labelfix clearfix">
					<input id="searchsubject" type="radio" value="1" name="searchtype" checked /><label for="searchsubject" />Subject</label>
				</li>
				<li class="labelfix clearfix">
					<input id="searchgroup" type="radio" value="1" name="searchtype" /><label for="searchgroup">Group</label>
				</li></ul>

			</li>
		</ul> -->
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
	<li  class="labelfix clearfix"><br /><label>Enable:&nbsp;</label><input type="checkbox" name="enable" <%= (enable == 1) ? 'checked' : '' %> /></li>
	<li class="clearfix" style="float:right;">
		<br />
		{{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
	</li>
	<input type="hidden" name="id" value="{{ $subject->id }}" />
	{{ Form::hidden('redirect', URL::current()) }}
	{{ Form::close() }}
	</ul>
</script>
@endsection