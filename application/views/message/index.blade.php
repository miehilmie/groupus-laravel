@layout('layout.hasleft')
@section('right')
<div id="messageContent">
<h1>Messages</h1>
@if($messages->results)
	{{ $messages->links() }}
	@foreach($messages->results as $m)
	<p>
		{{ $m->subject }}
	</p>
	@endforeach
@endif
</div>
@endsection