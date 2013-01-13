@layout('layout.hasleft')

@section('right')
	<ul class="student-update">
	     <li class="header">Lecturer's Announcements</li>
	     <li class="body">
	     	<ul>
		         @forelse ($announcements as $a)
	         <li class="update-item">
		         <ul>
		             <li class="titlebar"><span class="cls"><a href="/subjects/{{ $a->subject->id}}">{{ $a->subject->code }}</a></span><span class="time">{{ $a->created_at }}</span><span class="poster"><a href="/users/{{ $a->poster->user->id }}" ><?php echo $a->poster->user->name; ?></a></span></li>
		             <li class="messagebar"><?php echo $a->message; ?></li>
		             <li class="attachmentbar">
		             	@if($a->has_attachment)
		             	<div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment->filename }}" rel="nofollow">{{ $a->attachment->filename }}</a>
		             	@endif
		             </li>
		         </ul>
		     </li>
	         @empty
	         	<li><span>You have no update</span></li>
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
	     <li class="header">My Updates</li>
	     <li class="body">
	         <ul class="update-item">
		         @forelse ($updates as $a)
		         <li class="update-item">
			         <ul class="{{ ($a->poster->usertype_id == 2) ? 'lect' : ''  }}">
			             <li class="titlebar"><span class="cls"><a href="/subjects/{{ $a->subject->id}}">{{ $a->subject->code }}</a></span><span class="time">{{ $a->created_at }}</span><span class="poster"><a href="/users/{{ $a->poster->id }}" ><?php echo $a->poster->name; ?></a></span></li>
			             <li class="messagebar"><?php echo $a->message; ?></li>
			             <li class="attachmentbar">
			             	@if($a->has_attachment)
			             	<div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment->filename }}" rel="nofollow">{{ $a->attachment->filename }}</a>
			             	@endif
			             </li>
			         </ul>
			     </li>
		         @empty
		         	<li><span>You have no update</span></li>
		         @endforelse
	         </ul>
	     </li>
	 </ul>
@endsection

@section('left')
		<ul class="section">
		    <li class="title"><div class="title-text">My Group!</div><div class="title-roof"></div></li>
			@forelse($groups as $g)
			<li class="bullet">
			    <ul><li class="bullet-text group-wrap" data-href="/message/">
			            <a>{{ $g->name }}</a></li>
			    </ul>
			</li>
			@empty
			<li class="empty">
				<span>No group yet!</span>
			</li>
			@endforelse
		</ul>
@endsection

