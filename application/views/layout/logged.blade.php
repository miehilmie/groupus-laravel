@layout('layout.master')

@section('nav')

<?php
// record last activity
$user = Auth::user();
$user->last_activity = date('Y-m-d H:i:s',time());
$user->save();
?>
<ul class="navbar clearfix">
    <li class="left"><a class="item" href="{{ URL::to_route('home') }}">{{ HTML::image('img/home.png') }}</a>
    	<span>Welcome, {{ HTML::link('profile', Auth::user()->name) }} !</span></li>
    <li class="right">{{ HTML::link('setting', 'Account Setting', array('class' => 'item')) }}{{ HTML::link('logout', 'Logout', array('class' => 'item')) }}</li>
</ul>
@endsection

@section('jsmaster')
@yield('jslogged')
@endsection