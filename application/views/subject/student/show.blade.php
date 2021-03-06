@layout('layout.hasleft')

@section('jshasleft')
{{ HTML::script('js/views/subject.js') }}
{{ HTML::script('js/libs/hovercard.js') }}
@endsection

@section('right')
<div class="clearfix">
<div class="rSide">
	<div class="title">Student's List</div>
	<ul class="userList">
		@foreach($subject->subject_onlinestudents() as $s)
		<li class="userContainer">
			<a class="{{ ($s->id != $user->id) ? 'openchat' : '' }}" data-id="{{ $s->id }}" href="#" title="{{ $s->name }}"><div class="indicator {{ $s->status }}"></div>{{ $s->name }}</a>
		</li>
		@endforeach
	</ul>
</div>
<div class="hasRight">
	<h2 style="text-align:center;">Welcome To {{ $subject->code }}</h2>
	<h3 style="text-align:center;">{{ $subject->name }}</h3>
	@if($subject->IsGroupingEnable() && !$user->student->IsJoinGroup($subject->id))
	<div style="text-align:right; margin-bottom:5px;"><a id="joinGroup" class="btn btn-nicewhite" data-id="{{ $subject->id }}" href="#">Join a group!</a></div>
	@endif
	<ul class="student-update">
	     <li class="header">Lecturer's Announcements</li>
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
			             <li class="titlebar">
			             	<span class="cls">{{ $subject->code }}</span>
			             	<span class="time">{{ $a->created_at }}</span>
			             	<span class="poster">
			             		<span class="hovercard" data-id="{{ $a->poster_user_id }}" href="/users/{{ $a->poster_user_id }}" data-template="userHoverTmpl">
			             			<?php echo $a->poster_user_name; ?>
			             		</span>
			         		</span>
			         	</li>
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
		    <li class="title"><div class="title-text">My Group!</div><div class="title-roof"></div></li>
			@forelse($groups as $g)
			<li class="bullet">
			    <ul><li class="bullet-text group-wrap" data-href="/message/">
			            <a href="/groups/{{ $g->id }}">{{ $g->name }}</a></li>
			    </ul>
			</li>
			@empty
			<li class="empty">
				<span>No group yet!</span>
			</li>
			@endforelse
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

<script type="text/template" id="joinGroupTmpl">
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
		<div class="clearfix" style="text-align:right;"><input type="radio" name="group_num" value="<%= group_id %>" <%= enable %> ><span class="joinGp <%= enable %>">&nbsp;Join Group</span></div>
</dd>
</script>

<script type="text/template" id="userGroupTmpl">
<li>
	<a class="userGroupContent" href="/users/<%= id %>">
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
	</a>
</li>
</script>
@endsection