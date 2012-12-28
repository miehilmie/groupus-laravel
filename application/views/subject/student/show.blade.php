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
 <h3>Subject view</h3>
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
