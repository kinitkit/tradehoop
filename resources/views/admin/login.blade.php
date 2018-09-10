@extends('layouts.admin')

@section('title', 'Login')

@section('page', 'Login')

@section('content')
<div class="contentAdmin">
    <img src="{{'images/tradehoop-med.png'}}" width="200px"/>
    <br>
    <div class="line"></div>
    <br>
    <div class="panel panel-default login">
        <div class="panel-body row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="rightAlign"><img src="{{'images/tradehoop-med.png'}}" width="100px"/> Login</div>
                <hr><div class="space50" />
                
                <form class="form-horizontal" method="post">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="username">Username:</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="username">Password:</label>
                        <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-info">Login</button>
                        <a href="/adminForgetPassword" class="btn">Forgot password</a>
                        <a href="/adminContact" class="btn">Having trouble Logging in?</a>
                        </div>
                        <p class="col-sm-offset-3 col-sm-9">
                            <?php echo '<span class="label label-danger">' . (isset($message) ? $message : '') . '</span>'; ?>
                        </p>
                    </div>
                </form>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
@endsection