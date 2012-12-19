@layout('master')

@section('styles')
@parent
{{ HTML::style('css/signup.css') }}
@endsection

@section('javascripts')
@parent
{{ HTML::script('js/signup.js') }}        
@endsection

@section('content')
<div class="content-wrapper">

    @if($errors->has())
        <div id="register-error">
            @foreach ($errors->all('<p>:message</p>') as $e)
            {{ $e }}
            @endforeach
        </div>
    @endif
    <div id="register-info">
        <h1>Registration</h1>
        {{ Form::open('signup','POST', array('id'=>'register-form')) }}
        <fieldset>
            <legend style="color:#6D6B79;font-weight:bold; font-size: 16px;">Information details:</legend>
            <fieldset>
                <legend>General Information:</legend>
            <table>
                <tr><td><label>Username: </label></td><td>{{ Form::text('username', Input::old('username')) }}</td></tr>
                <tr><td><label>Full Name: </label></td><td>{{ Form::text('name', Input::old('name')) }}</td></tr>
                <tr><td><label>Password: </label></td><td>{{ Form::password('password') }}</td></tr>
                <tr><td><label>Re-Password: </label></td><td>{{ Form::password('password2') }}</td></tr>
                <tr><td><label>Gender: </label></td>
                    <td>{{ Form::radio('gender', '1', ((Input::old('gender') === '1') ? true : false) || true) }}
                        <label>Male</label>
                        {{ Form::radio('gender', '2', (Input::old('gender') === '2') ? true : false) }}
                        <label>Female</label></td></tr>
                <tr><td><label>Type: </label></td>
                    <td>{{ Form::radio('usertype', '1', ((Input::old('usertype') === '1') ? true : false) || true) }}
                        <label>Student</label>
                        {{ Form::radio('usertype', '2', (Input::old('usertype') === '2') ? true : false) }}
                        <label>Lecturer</label></td></tr>
                <tr><td><label>University: </label></td><td>
                        <select name="university">
                            <option value="none" <?php echo (!isset($_POST['university'])) ? 'selected=selected' : (($_POST['university'] == 'none') ? 'selected=selected' : ''); ?>>-- Select University --</option>
                            @if(isset($universities))

                            <?php foreach($universities as $u): ?>
                                <option value="<?php echo $u->id; ?>" <?php echo (!isset($_POST['university'])) ? '' : (($_POST['university'] == $u->id) ? 'selected=selected' : ''); ?>><?php echo $u->name; ?> (<?php echo $u->abbrevation; ?>)</option>
                            <?php endforeach; ?>
                            @endif
                        </select></td></tr>
            </table>
            </fieldset>
            <fieldset class="info-wrapper" data="1">
                <legend>Student Information:</legend>
                <table>
                    <tr><td><label>CGPA: </label></td><td><input style="width:100px" type="text" name="cgpa" value="" /></td></tr>
                    <tr><td><label>Distance from campus: </label></td><td>
                            <select name="dfc">
                                <option value="1">In campus</option>
                                <option value="2">10KM from campus</option>
                                <option value="3">Within 10 to 20KM from campus</option>
                                <option value="4">More than 20KM from campus</option>
                            </select></td></tr>
                </table>
            </fieldset>
            <fieldset class="info-wrapper" style="display:none;" data="2">
                <legend>Lecturer Information:</legend>
            </fieldset>
            <div class="submitpanel"><input class="submit" type="submit" value="Submit" /></div>
        </fieldset>
        {{ Form::close() }}
    </div>
    
</div>
@endsection