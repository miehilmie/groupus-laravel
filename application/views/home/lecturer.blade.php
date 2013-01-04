@layout('layout.hasleft')

@section('styles')
@parent
{{ HTML::style('css/student.css') }}
@endsection


@section('right')
	<ul class="lecturer-announcement">
	     <li class="header">Lecturer's Announcements</li>
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
	     <li class="header">My Updates</li>
	     <li class="body">
	         <ul class="update-item">
	         	<li>
		         @forelse ($updates as $u)
			         <ul class="update-item">
			             <li class="item-1"><span class="cls"><?php echo $a->code ?></span><span class="time"><?php echo $a->time; ?></span><span class="poster"><?php echo $a->poster; ?></span></li>
			             <li class="item-2"><?php echo $a->body; ?></li>
			         </ul>
		         @empty
		         	<span>You have no update</span>
		         @endforelse
		        </li>
	         </ul>
	     </li>
	 </ul>
@endsection

@section('left')
		<ul class="section">
		    <li class="title"><div class="title-text">My Group!</div><div class="title-roof"></div></li>
			<li class="bullet">
			    <ul><li class="bullet-text" data-href="/message/">
			            <a>Group 1</a></li>
			    </ul>
			</li>
			<li class="bullet">
			    <ul><li class="bullet-text" data-href="/message/">
			            <a>Group 2</a></li>
			    </ul>
			</li>
			<li class="bullet">
			    <ul><li class="bullet-text" data-href="/message/">
			            <a>Group 3</a></li>
			    </ul>
			</li>
		</ul>
		<ul class="searches">
		    <li></li>
		</ul>
@endsection
