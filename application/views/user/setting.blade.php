@layout('logged')

@section('styles')
@parent
{{ HTML::style('css/student.css') }}
@endsection

@section('content')
<div class="content-wrapper">
<h1>{{ HTML::image('img/settings.png') }}User Settings</h1>
</div>
@endsection