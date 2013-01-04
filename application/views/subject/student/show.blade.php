@layout('layout.hasleft')


@section('jshasleft')
{{ HTML::script('js/views/subject.js') }}
@endsection

@section('right')
<div class="clearfix">
<div class="rSide">
	<div class="title">Student's List</div>
	<div class="userList">
	<?php for ($i=0; $i < 5; $i++) { 
		?>
		<div class="userContainer">
			<a href="#" title="Muhammad Hilmi bin HASDAdasd ad asdasdasdas Hassan"><div class="indicator online"></div>Muhammad Hilmi bin HASDAdasd ad asdasdasdas Hassan</a>
		</div>
		<?php
	} ?>
	<?php for ($i=0; $i < 15; $i++) { 
		?>
		<div class="userContainer">
			<a href="#" title="Muhammad Hilmi bin HASDAdasd ad asdasdasdas Hassan"><div class="indicator"></div>Muhammad Hilmi bin HASDAdasd ad asdasdasdas Hassan</a>
		</div>
		<?php
	} ?>
	</div>
</div>
<div class="hasRight">
	<h2 style="text-align:center;">Welcome To {{ $subject->code }}</h2>
	<h3 style="text-align:center;">{{ $subject->name }}</h3>
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
	     <li class="header">Discussion board<a class="actionOnTitle" id="newPostSubject" href="#">Post New</a></li>
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
			<li class="bullet">
			    <ul><li class="bullet-text" data-href="/message/">
			            No group yet!</li>
			    </ul>
			</li>
			@endforelse
		</ul>
		<ul class="searches">
		    <li></li>
		</ul>
@endsection


@section('pagespecific-templates')
<script type="text/template" id="newPostSubjectTmpl">
	<h3> Post anything.. </h3>
	{{ Form::open('/subjects/posts') }}
	{{ Form::token() }}
	<textarea></textarea><br /><br /><br />
	<div class="clearfix" style="float:right;">
		{{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
	</div>
	<input type="hidden" name="id" value="{{ $subject->id }}" />
	{{ Form::hidden('redirect', URL::current()) }}
	{{ Form::close() }}
</script>
@endsection