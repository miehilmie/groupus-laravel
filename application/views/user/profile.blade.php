@layout('layout.logged')

@section('styles')
@parent
{{ HTML::style('css/student.css') }} 
@endsection

@section('javascripts')
@parent
{{ HTML::script('js/student.js') }}
@endsection

@section('content')
<table id="profile-tbl" border="1" align="center" cellspacing="0" cellpadding="8px">
	<tr class="head">
		<td colspan="2"><h1>{{ $user->name }} {{ HTML::link('setting', '[edit profile]') }}</h1></td>
	</tr>
	<tr>
		<td><img src="{{ $user->img_url }}" width="180px" height="230px" ></td>
		<td>
			<ul id="profile-info">
			<li><label>Name :</label> {{ $user->name }}</li>
			<li><label>Age :</label> {{ $user->age ? $user->age : '<span class="not">Not Specified</span>' }}</li>
			<li><label>Address:</label> {{ $user->address ? $user->address : '<span class="not">Not Specified</span>' }}</li>
			<li><label>Phone:</label> {{ $user->phone ? $user->phone : '<span class="not">Not Specified</span>' }}</li>
			<li><label>Faculty:</label> {{ $user->faculty->name }} ({{ $user->faculty->abbrevation }})</li>
			<li><label>University:</label> {{ $user->university->name }}</li></ul>
		</td>
	</tr>
	<tr><td colspan="2">{{ Form::open('users/'.$user->id.'/1') }}{{ Form::token() }}Friendly: <span class="star filled clickable" data-value="1"></span><span class="star clickable" data-value="2"></span><span class="star clickable" data-value="3"></span><span class="star clickable" data-value="4"></span><span class="star clickable" data-value="5"></span></span><span class="votescount">({{ User::votecount($user->id) }} votes)</span>{{ Form::hidden('id',$user->id) }}{{ Form::close() }}</td><tr>
	<tr><td colspan="2">Overall proficiency: <span><span class="star filled clickable" data-value="1"></span><span class="star clickable" data-value="2"></span><span class="star clickable" data-value="3"></span><span class="star clickable" data-value="4"></span><span class="star clickable" data-value="5"></span></span><span class="votescount">(100 votes)</span></td><tr>
	<tr><td colspan="2">Hardworking: <span><span class="star filled clickable" data-value="1"></span><span class="star clickable" data-value="2"></span><span class="star clickable" data-value="3"></span><span class="star clickable" data-value="4"></span><span class="star clickable" data-value="5"></span></span><span class="votescount">(100 votes)</span></td><tr>
	<tr><td colspan="2">Leadership: <span><span class="star filled clickable" data-value="1"></span><span class="star filled clickable" data-value="2"></span><span class="star clickable" data-value="3"></span><span class="star clickable" data-value="4"></span><span class="star clickable" data-value="5"></span></span><span class="votescount">(100 votes)</span></td><tr>
</table>
@endsection