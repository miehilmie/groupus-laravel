@layout('layout.hasleft')


@section('jshasleft')
{{ HTML::script('js/views/group.js') }}
@endsection

@section('right')
<div class="clearfix">
<div class="rSide">
    <div class="title">User's List</div>
    <ul class="userList">
        @foreach($group->group_onlinestudents() as $s)
        <li class="userContainer {{ ($s->usertype_id == 2) ? 'lecturer' : '' }}">
            <a class="{{ ($s->id != $user->id) ? 'openchat' : '' }}" data-id="{{ $s->id }}" href="#" title="{{ $s->name }}"><div class="indicator {{ $s->status }}"></div>{{ $s->name }}</a>
        </li>
        @endforeach
    </ul>
</div>
<div class="hasRight">
    <h2 style="text-align:center;">Welcome To {{ $group->name }}</h2>
    <ul class="student-update">
         <li class="header">Lecturer's Announcements</li>
         <li class="body">
            <ul>
            @forelse ($group->subject->subject_announcements() as $a)
                 <li class="update-item">
                     <ul>
                         <li class="titlebar"><a href="/subjects/{{ $group->subject->id }}" class="cls">{{ $group->subject->code }}</a><span class="time">{{ $a->created_at }}</span>
                            <span class="poster">
                                <span class="hovercard" data-id="{{ $a->poster_user_id }}" href="/users/{{ $a->poster_user_id }}" data-template="userHoverTmpl">
                                    <?php echo $a->poster_user_name; ?>
                                </span>
                            </span></li>
                         <li class="messagebar"><?php echo $a->message; ?></li>
                         <li class="attachmentbar">
                            @if($a->has_attachment)
                            <div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment_filename }}" rel="nofollow">{{ $a->attachment_filename }}</a>
                            @endif
                         </li>
                     </ul>
                 </li>
                 @empty
                    <li class="no-item"><span>You have no announcement yet</span></li>
                 @endforelse
            </ul>
         </li>
     </ul>
     <ul class="student-update">
         <li class="header">Discussion board<a class="actionOnTitle" id="newPost" href="#">Post New</a></li>
         <li class="body">
             <ul>
                 @forelse ($group->group_discussions() as $a)
                 <li class="update-item">
                     <ul>
                         <li class="titlebar">
                            <a href="/subjects/{{ $group->subject->id }}" class="cls">{{ $group->subject->code }}</a>
                            <span class="time">{{ $a->created_at }}</span>
                            <span class="poster">
                                <span class="hovercard" data-id="{{ $a->poster_user_id }}" href="/users/{{ $a->poster_user_id }}" data-template="userHoverTmpl">
                                    <?php echo $a->poster_user_name; ?>
                             </span>
                            </span>
                        </li>
                         <li class="messagebar"><?php echo $a->message; ?></li>
                         <li class="attachmentbar">
                            @if($a->has_attachment)
                            <div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment_filename }}" rel="nofollow">{{ $a->attachment_filename }}</a>
                            @endif
                         </li>
                     </ul>
                 </li>
                 @empty
                    <li class="no-item"><span>You have no update</span></li>
                 @endforelse
             </ul>
         </li>
     </ul>
</div>
</div>
@endsection

@section('left')
        <ul class="section">
            <li class="title"><div class="title-text">My Group!</div><div class="title-roof"></div></li>
            @forelse($groups as $g)
            <li class="bullet">
                <ul><li class="bullet-text group-wrap" data-href="/message/">
                        <a href="/groups/{{ $g->id }}">{{ $g->name }}</a></li>
                </ul>
            </li>
            @empty
            <li class="empty">
                <span>No group yet!</span>
            </li>
            @endforelse
        </ul>
@endsection


@section('pagespecific-templates')
<script type="text/template" id="newPostGroupTmpl">
    <h3> Discuss anything.. </h3>
    {{ Form::open_for_files('/groups/posts') }}
    {{ Form::token() }}
    <textarea name="message"></textarea><br /><br />
    <span>Attachment: </span><br/>
    {{ Form::file('attachment') }}
    <br /><br />
    <div class="clearfix" style="float:right;">
        {{ Form::submit('Submit', array('class' => 'btn btn-niceblue')) }}
    </div>
    <input type="hidden" name="id" value="{{ $group->id }}" />
    {{ Form::hidden('redirect', URL::current()) }}
    {{ Form::close() }}
</script>

@endsection