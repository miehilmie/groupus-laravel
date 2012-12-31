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
		<td><img src="{{ URL::base().$user->img_url }}" width="180px" height="230px" ></td>
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
	<tr><td colspan="2">
		Friendly: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $friendly_value)
			<span class="star filled" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $friendly_votes }} votes)</span>
	</td></tr>
	<tr><td colspan="2">
		Overall proficiency: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $proficiency_value)
			<span class="star filled" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $proficiency_votes }} votes)</span>
	</td></tr>
	<tr><td colspan="2">
		Hardworking: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $hardwork_value)
			<span class="star filled" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $hardwork_votes }} votes)</span>
	</td></tr>
	<tr><td colspan="2">
		Leadership: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $leadership_value)
			<span class="star filled" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $leadership_votes }} votes)</span>
	</td></tr>
</table>
@endsection