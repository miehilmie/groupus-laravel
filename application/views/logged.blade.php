@layout('master')

@section('nav')
<ul class="navbar clearfix">
    <li class="left"><a class="item" href="{{ URL::to_route('home') }}">{{ HTML::image('img/home.png') }}</a>
    	<span>Welcome, {{ HTML::link('profile', Auth::user()->name) }} !</span></li>
    <li class="right">{{ HTML::link('setting', 'Account Setting', array('class' => 'item')) }}{{ HTML::link('logout', 'Logout', array('class' => 'item')) }}</li>
</ul>
@endsection