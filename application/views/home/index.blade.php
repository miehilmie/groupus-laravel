@layout('layout.master')
@section('styles')
@parent
{{ HTML::style('css/login.css') }}
@endsection

@section('nav')
            <div class="loginpanel clearfix">
                {{ Form::open('login','POST', array('id' => 'loginform')) }}
                    <ul id="logindata" class="clearfix">

                    @if(Session::get('status'))
                        <div class="error">{{ Session::get('status') }}</div>
                    @endif
                        <li><span>Username:&nbsp;</span>{{ Form::text('username', Input::old('username'), array('class' => 'input')) }}</li>
                        <li><span>Password:&nbsp;</span>{{ Form::password('password', array('class' => 'input')) }}</li>
                        <li><input class="submit" type="submit" name="login" value="Log In" /></li>
                    </ul>
                    <div id="remember" class="clearfix">
                    	<input type="checkbox" name="remember" id="persist_box" />
                    	<label for="persist_box" style="cursor: pointer; color:lightgrey;">Remember me?</label>
                    	<a style="color:lightgrey; float:left; margin-left:125px; font-size: 11px;" href="signup">Not a member? Join us now!</a></div>
                        {{ Form::token() }}
                {{ Form::close() }}
            </div>
@endsection

@section('content')
            <ul class="content-grid clearfix">
                <li class="systemann-container">
                    <ul class="systemann">
                        <li class="title">Experience Us! on Android!</li>
                        <li class="msg"><a href="http://android.groupusmalaysia.com/download/GroupUs_v1_1.apk"><img src="/img/groupus-android.png" /><br />Click This Robot</a><br />To Download our Android app</li>
                        <li class="postedtime">Posted on : <small>1-January-2013</small></li>
                    </ul>
                    <ul class="systemann">
                        <li class="title">Us! News!</li>
                        <li class="msg">Welcome to GroupUs!<br/>We are wishing you Selamat Hari Raya Aidilfitri</li>
                        <li class="postedtime">Posted on : <small>30-October-2012</small></li>
                    </ul>

                    <ul class="systemann">
                        <li class="title">We are now on twitter!</li>
                        <li class="msg">Find us on twitter! <a href="http://twitter.com/groupusmy">@groupusmy</a></li>
                        <li class="postedtime">Posted on : <small>1-September-2012</small></li>
                    </ul>


                <li class="peopleimg"></li>
            </ul>
@endsection