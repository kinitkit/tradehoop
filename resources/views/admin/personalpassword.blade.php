@extends('layouts.adminLogged')

@section('title', 'Change Password')

@section('page', 'Change Password')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">All fields are required</p>
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="oldpassword">Old Password:</label>
                <div class="col-sm-9">
                <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password" maxlength="30" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="newpassword">New Password:</label>
                <div class="col-sm-9">
                <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New Password" pattern=".{6,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="confirmpassword">Confirm:</label>
                <div class="col-sm-9">
                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" pattern=".{6,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-info">Change</button>
            </div><br>
        </form>
    </div>
@endsection