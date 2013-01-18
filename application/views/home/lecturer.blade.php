@layout('layout.hasleft')

@section('right')
	<ul class="student-update">
	     <li class="header">Your Announcements</li>
	     <li class="body">
	     	<ul>
		         @forelse ($announcements as $a)
	         <li class="update-item">
		         <ul>
		             <li class="titlebar"><span class="cls"><a href="/subjects/{{ $a->subject_id}}">{{ $a->subject_code }}</a></span><span class="time">{{ $a->created_at }}</span><span class="poster"><a href="/users/{{ $a->poster_user_id }}" ><?php echo $a->poster_user_name; ?></a></span></li>
		             <li class="messagebar"><?php echo $a->message; ?></li>
		             <li class="attachmentbar">
		             	@if($a->has_attachment)
		             	<div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment->filename }}" rel="nofollow">{{ $a->attachment_filename }}</a>
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
	 <ul class="student-update">
	     <li class="header">My Updates</li>
	     <li class="body">
	         <ul class="update-item">
		         @forelse ($updates as $a)
		         <li class="update-item">
			         <ul class="{{ ($a->poster_usertype_id == 2) ? 'lect' : ''  }}">
			             <li class="titlebar"><span class="cls">{{ $a->subject_code }}</span><span class="time">{{ $a->created_at }}</span><span class="poster"><a href="/users/{{ $a->poster_user_id }}" ><?php echo $a->poster_user_name; ?></a></span></li>
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

