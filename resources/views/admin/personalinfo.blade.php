@extends('layouts.adminLogged')

@section('title', 'Personal Information')

@section('page', 'Personal Information')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="username">Username:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" id="username" value="{{session('tradehoopusername')}}" readonly title="you cannot change your username">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="firstname">Firstname:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" pattern=".{2,}" maxlength="100" required value="{{session('tradehoopfirstname')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="middlename">Middlename:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle Name" pattern=".{2,}" maxlength="50" required value="{{session('tradehoopmiddlename')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="lastname">Lastname:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" pattern=".{2,}" maxlength="50" required value="{{session('tradehooplastname')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="email">Email:</label>
                <div class="col-sm-9">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{session('tradehoopemail')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="birthdate">Birthdate:</label>
                <div class="col-sm-9">
                <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="Birthdate" value="{{session('tradehoopbirthdate')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="gender">Gender:</label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label><input type="radio" class="radio-inline" <?php echo (session('tradehoopgender')=="m"?"checked":""); ?> name="gender" value="m">Male</label>
                        <label><input type="radio" class="radio-inline" <?php echo (session('tradehoopgender')=="f"?"checked":""); ?> name="gender" value="f">Female</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Account:</label>
                <div class="col-sm-9">
                    <label class="form-control"><?php echo (session('tradehoopstatus')=="1"?"Active":"Inactive"); ?></label>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-info">Update</button>
            </div><br>
        </form>
    </div>
@endsection