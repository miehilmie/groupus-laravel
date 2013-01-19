@layout('layout.master')

@section('jsmaster')
{{ HTML::script('js/views/signup.js') }}
@endsection

@section('nav')
<ul class="navbar clearfix">
    <li class="left">
        <a class="item" href="{{ URL::to_route('home') }}">{{ HTML::image('img/home.png') }} LOGIN</a>
    </li>
</ul>
@endsection

@section('content')
<div class="content-wrapper">

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
        <h1>Registration</h1>
        {{ Form::open('signup','POST') }}
        {{ Form::token() }}
        <fieldset>
            <legend style="color:#6D6B79;font-weight:bold; font-size: 16px;">Information details:</legend>
            <fieldset>
                <legend>General Information:</legend>
            <table>
                <tr>
                    <td>
                        <label>Username<span class="required">*</span>: </label>
                    </td>
                    <td>
                        {{ Form::text('username', Input::old('username')) }}&nbsp;<span class="smallinfo">example@email.com</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Full Name<span class="required">*</span>: </label>
                    </td>
                    <td>
                        {{ Form::text('name', Input::old('name')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Password<span class="required">*</span>: </label>
                    </td>
                    <td>
                        {{ Form::password('password') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Re-Password<span class="required">*</span>: </label>
                    </td>
                    <td>
                        {{ Form::password('password2') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Age: </label>
                    </td>
                    <td>{{ Form::text('age', Input::old('age')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Contact: </label>
                    </td>
                    <td>
                        {{ Form::text('phone', Input::old('phone')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Address: </label>
                    </td>
                    <td>
                        {{ Form::text('address', Input::old('address')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Gender<span class="required">*</span>: </label>
                    </td>
                    <td>
                        {{ Form::radio('gender', '1', ((Input::old('gender') === '1') ? true : false) || true) }}
                        <label>Male</label>
                        {{ Form::radio('gender', '2', (Input::old('gender') === '2') ? true : false) }}
                        <label>Female</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Type<span class="required">*</span>: </label>
                    </td>
                    <td>
                        {{ Form::radio('usertype', '1', ((Input::old('usertype') === '1') ? true : false) || true) }}
                        <label>Student</label>
                        {{ Form::radio('usertype', '2', (Input::old('usertype') === '2') ? true : false) }}
                        <label>Lecturer</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>University<span class="required">*</span>: </label>
                    </td>
                    <td>
                        <select id="selUniversity" name="university">
                            <option value="none" {{ (Input::old('university', 'none') == 'none') ? 'selected=selected' : '' }}>-- Select University --</option>
                            @foreach($universities as $u)
                                <option value="{{ $u->id }}" {{ (Input::old('university') == $u->id) ? 'selected=selected' : '' }}>{{ $u->name }} ({{ $u->abbrevation }})</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Faculty<span class="required">*</span>: </label>
                    </td>
                    <td>
                        <select id="selFaculty" name="faculty">
                            <option value="none" {{ (Input::old('faculty', 'none') == 'none') ? 'selected=selected' : '' }}>-- Select Faculty --</option>
                            @foreach($faculties as $f)
                                <option value="{{ $f->id }}" {{ (Input::old('faculty') == $f->id) ? 'selected=selected' : '' }}>{{ $f->name }} ({{ $f->abbrevation }})</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
            </fieldset>
            <fieldset class="info-wrapper" {{ (Input::old('usertype') == 2) ? 'style="display:none;"' : ''}} data="1">
                <legend>Student Information:</legend>
                <table>
                    <tr>
                        <td>
                            <label>CGPA<span class="required">*</span>: </label>
                        </td>
                        <td>
                            <input style="width:100px" type="text" name="cgpa" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Distance from campus<span class="required">*</span>: </label>
                        </td>
                        <td>
                            <select name="dfc">
                                <option value="1">In campus</option>
                                <option value="2">10KM from campus</option>
                                <option value="3">Within 10 to 20KM from campus</option>
                                <option value="4">More than 20KM from campus</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset class="info-wrapper" {{ (Input::old('usertype') != 2) ? 'style="display:none;"' : ''}} data="2">
                <legend>Lecturer Information:</legend>
                <table>
                    <tr>
                        <td>
                            <label>Room No.<span class="required">*</span>: </label>
                        </td>
                        <td>
                            <input style="width:100px" type="text" name="roomno" value="" />
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br />
            <fieldset>
                <input id="lblTerm" name="agree" type="checkbox">
                <label for="lblTerm">I Agree with the terms and conditions
                    <span class="required">*</span>
                </label>
            </fieldset>
            <div class="submitpanel">
                <input class="submit" type="submit" value="Submit" />
            </div>
        </fieldset>
        {{ Form::close() }}
    </div>

</div>
@endsection