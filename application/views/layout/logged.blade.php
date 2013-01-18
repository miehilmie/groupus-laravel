@layout('layout.master')

@section('nav')

<ul class="navbar clearfix">
    <li class="left"><a class="item" href="{{ URL::to_route('home') }}">{{ HTML::image('img/home.png') }}</a>
    	<span>Welcome, {{ HTML::link('profile', $user->name) }} !</span></li>
    <li class="right">{{ HTML::link('setting', 'Account Setting', array('class' => 'item')) }}{{ HTML::link('logout', 'Logout', array('class' => 'item')) }}</li>
</ul>
@endsection

@section('jsmaster')
{{ HTML::script('js/views/chat.js') }}

<script type="text/javascript">
    $('.hovercard-item').hover(function() {
        $(this).stop(true, false).show();
    }, function() {
        $('.hovercard-item').hide();
    });
    $('.hovercard').hover(function() {
        $(this).find('.hovercard-item').delay(100).show(); // show() doesn't seem to work with delay
    }, function() {
        $(this).find('.hovercard-item').delay(100).fadeOut('fast');
    });
</script>
@yield('jslogged')
@endsection

@section('chatbar')
<div id="chatbar">
<div class="chatbarwrapper">
    <ul class="chatitems clearfix">
        @foreach($user->chats() as $chat)
        <li>
            <div class="chat-jewel"><span style="{{ ($chat->toggle == '1' || $chat->jewel() == 0) ? 'display:none;' : '' }}">{{ $chat->jewel() }}</span></div>
            <div id="chatid-{{ $chat->receiver->id }}" class="chat {{ ($chat->toggle) ? 'open' : '' }}">
                <div class="title clearfix"><a class="chatclose" href="#">X</a><span>{{ $chat->receiver->name }}</span></div>
                <div class="body">
                    <ul>
                    @foreach($chat->messages as $msg)
                    <li>
                        <b>{{ ($msg->sender_id == $user->id) ? 'You' : Str::limit($chat->receiver->name, 10); }}:</b> {{ $msg->message }}
                    </li>
                    @endforeach
                    </ul>
                </div>
                <div class="message"><input type="text" /></div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
</div>
@endsection