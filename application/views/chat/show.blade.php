<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <div>
        <h1>Conversation with {{ $receiver }}</h1>
        <ul class="messages">
            @foreach ($messages as $message)
                @if($message->sender_id === $user->id)
                <li>
                    You : {{ $message->message }} <br/>
                    <abbr>{{ $message->created_at }}</abbr>
                </li>
                @else
                <li>
                    {{ $receiver }} : {{ $message->message }} <br />
                    <abbr>{{ $message->created_at }}</abbr>
                </li>
                @endif
            @endforeach
        </ul>
        <div>
            {{ Form::open('/chats/send') }}
            {{ Form::text('message') }}
            {{ Form::submit('Send') }}
            {{ Form::hidden('id', $id) }}
            {{ Form::close() }}
        </div>
    </div>
</body>
</html>