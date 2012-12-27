@layout('layout.hasleft')

@section('styles')
@parent
{{ HTML::style('css/student.css') }}
@endsection


@section('javascripts')
@parent
{{ HTML::script('js/student.js') }}
@endsection

@section('right')
<div class="right-content">
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
</div>
@endsection

@section('left')
    <div id="left-content">
        <ul class="section">
			<li class="title"><div class="title-text">My Menu!</div><div class="title-roof"></div></li>

			<li class="bullet">
			    <ul>
			        <li class="bullet-text bubbleTrigger" data-href="/student/subject/" data-target="subjectFlyout">
			            <a>Subjects</a>
			        </li>
			        <li class="bubble-wrapper" id="subjectFlyout">
			            <ul class="bubble">                    
			                <li class="bubble-caret">
			                    <div class="caret-outer" ></div>
			                    <div class="caret-inner" ></div>
			                </li>
			                <li class="bubble-item">
			                    <ul>
			                    	@forelse ($subjects as $s)
			                    		<li>{{  HTML::link_to_route('subject_show', $s->code, array($s->id)) }}</li>
			                    	@empty
			                    		<li><span>No Subject<span></li>
			                    	@endforelse
			                    </ul>

			                </li>
			            </ul>
			        </li>
			    </ul>
			</li>

			<li class="bullet">
			    <ul>
			        <li class="bullet-text bubbleTrigger" data-href="/message/" data-target="messageFlyout">
			            <a>Messages</a>
			        </li>
			        <li class="bubble-wrapper" id="messageFlyout">
			            <ul class="bubble">                    
			                <li class="bubble-caret">
			                    <div class="caret-outer" ></div>
			                    <div class="caret-inner" ></div>
			                </li>
			                <li class="bubble-item">
			                    <ul>
			                    	@forelse ($messages as $m)
			                    		<li>{{  HTML::link('message', $s) }}</li>
			                    	@empty
			                    		<li><span>No message<span></li>
			                    	@endforelse
			                    </ul>

			                </li>
			            </ul>
			        </li>
			    </ul>
			</li>
		</ul>
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
    </div>
@endsection

