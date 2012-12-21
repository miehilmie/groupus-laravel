@layout('logged')

@section('styles')
@parent
{{ HTML::style('css/student.css') }} 
@endsection

@section('javascripts')
@parent
{{ HTML::script('js/student.js') }}
@endsection

@section('content')
<table border="1" align="center">
	<tr>
		<td colspan="2"><h1>{{ $name }} {{ HTML::link('setting', '[edit profile]') }}</h1></td>
	</tr>
	<tr>
		<td>{{ HTML::image('uploads/1/timestamp.png') }}</td>
		<td>
			<div>Name : {{ $name }}</div>
			<div>Age : 24</div>
			<div>Address: Unit 8-9-3, Blok 8, Fasa 2, Pantai Hillpark, Jalan Pantai Dalam, 52900 Kuala Lumpur</div>
			<div>Phone: {{ $phone }}</div>
			<div>Faculty: {{ $faculty->name }} ({{ $faculty->abbrevation }})</div>
			<div>University: {{ $university }}</div>
		</td>
	</tr>
	<tr><td colspan="2">Friendly: * * * *</td><tr>
	<tr><td colspan="2">Overall proficiency: * * * *</td><tr>
	<tr><td colspan="2">Hardworking: * * * *</td><tr>
	<tr><td colspan="2">Leadership: * * * *</td><tr>
</table>
@endsection