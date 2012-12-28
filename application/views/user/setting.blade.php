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
<h3>User Settings</h3>
@endsection
