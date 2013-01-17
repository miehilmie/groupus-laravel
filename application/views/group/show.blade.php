@layout('layout.hasleft')


@section('jshasleft')
{{ HTML::script('js/views/group.js') }}
@endsection

@section('right')
<div class="clearfix">
<div class="hasRight">
    <h2 style="text-align:center;">Welcome To {{ $group->name }}</h2>
    <ul class="student-update">
         <li class="header">Lecturer's Announcements</li>
         <li class="body">
            <ul>
            @forelse ($group->subject->subject_announcements() as $a)
                 <li class="update-item">
                     <ul>
                         <li class="titlebar"><a href="/subjects/{{ $group->subject->id }}" class="cls">{{ $group->subject->code }}</a><span class="time">{{ $a->created_at }}</span><span class="poster"><span class="hovercard" data-template="userHoverTmpl">
                            <?php echo $a->poster->user->name; ?>
<div class="hovercard-item">
<a href="/users/{{ $a->poster->user->id }}">
    <div class="clearfix">
        <div class="imgPrev">
            <img class="thumb" src="{{ Config::get('application.custom_img_thumbs_url')}}{{ $a->poster->user->img_url }}" width="25px" height="25px">
        </div>
        <div class="cData">
            <div class="author">
                <strong>{{ $a->poster->user->name }}</strong>
            </div>
        </div>
    </div>
</a>
<div class="panel">
    <a class="message-ico" href="/messages/new/{{ $a->poster->user->id }}"><img src="/img/message_ico.png" /></a>
</div>
</div>
                         </span></span></li>
                         <li class="messagebar"><?php echo $a->message; ?></li>
                         <li class="attachmentbar">
                            @if($a->has_attachment)
                            <div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment->filename }}" rel="nofollow">{{ $a->attachment->filename }}</a>
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
                            <span class="cls"></span>
                            <span class="time">{{ $a->created_at }}</span>
                            <span class="poster">
                                <span class="hovercard" data-id="{{ $a->poster->id }}" href="/users/{{ $a->poster->id }}" data-template="userHoverTmpl">
                                    <?php echo $a->poster->name; ?>
<!-- HOVERCARD -->
<div class="hovercard-item">
<a href="/users/{{ $a->poster->id }}">
    <div class="clearfix">
        <div class="imgPrev">
            <img class="thumb" src="{{ Config::get('application.custom_img_thumbs_url')}}{{ $a->poster->img_url }}" width="25px" height="25px">
        </div>
        <div class="cData">
            <div class="author">
                <strong>{{ $a->poster->name }}</strong>
            </div>
        </div>
    </div>
</a>
<div class="panel">
    <a class="message-ico" href="/messages/new/{{ $a->poster->id }}"><img src="/img/message_ico.png" /></a>
</div>
</div>
<!-- HOVERCARD ENDS -->
                             </span>
                            </span>
                        </li>
                         <li class="messagebar"><?php echo $a->message; ?></li>
                         <li class="attachmentbar">
                            @if($a->has_attachment)
                            <div class="attchmnt-ico"></div><a href="{{ Config::get('application.custom_attachment_url') }}{{ $a->attachment->filename }}" rel="nofollow">{{ $a->attachment->filename }}</a>
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