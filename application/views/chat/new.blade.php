<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <div>
        <h1>New Conversation</h1>
        <div class="messages">

        </div>
        <div>
            {{ Form::open('/chats/create') }}
            {{ Form::select('to', $users) }}{{ Form::text('message') }}
            {{ Form::submit('Create') }}
            {{ Form::close() }}
        </div>
    </div>
</body>
</html>