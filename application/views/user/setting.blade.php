@layout('layout.hasleft')

@section('jshasleft')
{{ HTML::script('js/views/setting.js') }}
@endsection

@section('right')
@if($errors->has())
    <div class="errormsg">
        @foreach ($errors->all('<p>:message</p>') as $e)
        {{ $e }}
        @endforeach
    </div>
@endif
@if($success = Session::get('success'))
<div class="successmsg">
    <p>{{ $success }}</p>
</div>
@endif
<div id="formfields">
<h3>User Settings</h3>
<fieldset>
            <legend style="color:#6D6B79;font-weight:bold; font-size: 16px;">Information details:</legend>
<ul class='tabs'>
    <li><a href='#tab1'>User Information</a></li>
    <li><a href='#tab2'>Upload Image</a></li>
    <li><a href='#tab3'>Change Password</a></li>
</ul>
<div id='tab1'>
{{ Form::open('setting/1', 'PUT') }}
{{ Form::token() }}
            <fieldset>
                <legend>General Information:</legend>
            <table>
                <tr><td><label>Full Name<span class="required">*</span>: </label></td><td>{{ Form::text('name', (Input::old('name') ? Input::old('name') : $user->name)) }}</td></tr>
                <tr><td><label>Age: </label></td><td>{{ Form::text('age', (Input::old('age') ? Input::old('age') : $user->age)) }}</td></tr>
                <tr><td><label>Contact: </label></td><td>{{ Form::text('phone', (Input::old('phone') ? Input::old('phone') : $user->phone)) }}</td></tr>
                <tr><td><label>Address: </label></td><td>{{ Form::text('address', (Input::old('address') ? Input::old('address') : $user->address)) }}</td></tr>
                <tr>
                    <td>
                    <label>Gender<span class="required">*</span>: </label>
                </td>
                    <td>
                        <div class="labelfix cleafix">
                        {{ Form::radio('gender', '1', (Input::old('gender') === '1' || $user->gender_id === '1') ? true : false, array()) }}
                        <label>
                            &nbsp;Male&nbsp;&nbsp;
                        </label>
                        {{ Form::radio('gender', '2', (Input::old('gender') === '2' || $user->gender_id === '2') ? true : false) }}
                        <label>&nbsp;Female</label>
                        </div>
                    </td></tr>
            </table>
            @if($user->usertype_id == 1)
            <fieldset class="info-wrapper">
                <legend>Student Information:</legend>
                <table>
                    <tr><td><label>CGPA<span class="required">*</span>: </label></td><td><input style="width:100px" type="text" name="cgpa" value="{{ Input::old('cgpa') ? Input::old('cgpa') : $user->student->cgpa }}" /></td></tr>
                    <tr><td><label>Distance from campus<span class="required">*</span>: </label></td><td>
                            <select name="dfc">
                                <option value="1" {{ ($user->student->distance_f_c == 1) ? 'selected' : '' }}>In campus</option>
                                <option value="2" {{ ($user->student->distance_f_c == 2) ? 'selected' : '' }}>10KM from campus</option>
                                <option value="3" {{ ($user->student->distance_f_c == 3) ? 'selected' : '' }}>Within 10 to 20KM from campus</option>
                                <option value="4" {{ ($user->student->distance_f_c == 4) ? 'selected' : '' }}>More than 20KM from campus</option>
                            </select></td></tr>
                </table>
            </fieldset>
            @elseif($user->usertype_id == 2)
            <fieldset class="info-wrapper">
                <legend>Lecturer Information:</legend>
            </fieldset>
            @endif
            </fieldset>
            <div class="submitpanel"><input class="submit" type="submit" value="Submit" /></div>
{{ Form::close() }}
</div>
<div id='tab2'>
{{ Form::open_for_files('setting/2','PUT') }}
{{ Form::token() }}
            <fieldset class="info-wrapper" data="3">
                <legend>Upload Image:</legend>
                <table><tr><td><label>Upload</span>: </label></td><td>{{ Form::file('image') }}</td></tr>
                </table>   
            </fieldset>
            <div class="submitpanel"><input class="submit" type="submit" value="Submit" /></div>
{{ Form::close() }}
</div>
<div id='tab3'>
{{ Form::open('setting/3','PUT') }}
{{ Form::token() }}
            <fieldset class="info-wrapper" data="3">
                <legend>Change Password:</legend>
                <table><tr><td><label>Old Password</span>: </label></td><td>{{ Form::password('oldpassword') }}</td></tr>
                    <tr><td><label>New Password</span>: </label></td><td>{{ Form::password('password') }}</td></tr>
                    <tr><td><label>Re-Password</span>: </label></td><td>{{ Form::password('password2') }}</td></tr>
                </table>   
            </fieldset>
            <div class="submitpanel"><input class="submit" type="submit" value="Submit" /></div>
{{ Form::close() }}
</div>
</fieldset>

</div>
@endsection
