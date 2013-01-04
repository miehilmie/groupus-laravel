@layout('layout.logged')

@section('styles')
@parent
{{ HTML::style('css/student.css') }} 
@endsection

@section('jslogged')
@parent
{{ HTML::script('js/views/user.js') }}
@endsection


@section('content')
<table id="profile-tbl" border="1" align="center" cellspacing="0" cellpadding="8px">
	<tr class="head">
		<td colspan="2"><h1>{{ $user->name }}</h1></td>
	</tr>
	<tr>
		<td><img src="/uploads/{{ $user->img_url }}" width="180px" height="180px" ></td>
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
		@if($friendly_click)
			{{ Form::open('users/'.$user->id.'/friendly') }}{{ Form::token() }}
		@endif
		Friendly: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $friendly_value)
			<span class="star filled {{ $friendly_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star {{ $friendly_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $friendly_votes }} votes)</span>
		@if($friendly_click)
			{{ Form::close() }}
		@endif
	</td></tr>
	<tr><td colspan="2">
		@if($proficiency_click)
			{{ Form::open('users/'.$user->id.'/proficiency') }}{{ Form::token() }}
		@endif
		Overall proficiency: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $proficiency_value)
			<span class="star filled {{ $proficiency_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star {{ $proficiency_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $proficiency_votes }} votes)</span>
		@if($proficiency_click)
			{{ Form::close() }}
		@endif
	</td></tr>
	<tr><td colspan="2">
		@if($hardwork_click)
			{{ Form::open('users/'.$user->id.'/hardwork') }}{{ Form::token() }}
		@endif
		Hardworking: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $hardwork_value)
			<span class="star filled {{ $hardwork_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star {{ $hardwork_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $hardwork_votes }} votes)</span>
		@if($hardwork_click)
			{{ Form::close() }}
		@endif
	</td></tr>
	<tr><td colspan="2">
		@if($leadership_click)
			{{ Form::open('users/'.$user->id.'/leadership') }}{{ Form::token() }}
		@endif
		Leadership: 
		<span>
			@for($i = 0; $i < 5; $i++)
			@if($i < $leadership_value)
			<span class="star filled {{ $leadership_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@else
			<span class="star {{ $leadership_click ? 'clickable' : '' }}" data-value="{{ $i+1 }}"></span>
			@endif
			@endfor
		</span>
		<span class="votescount">({{ $leadership_votes }} votes)</span>
		@if($leadership_click)
			{{ Form::close() }}
		@endif
	</td></tr>
</table>
@endsection