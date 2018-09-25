@extends('layouts.customer')

@section('title', 'Login')

@section('page', 'Login')

@section('content')
    <div class="login-register">
        <div class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form class="form-horizontal" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Email:</label>
                            <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="password">Password:</label>
                            <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group"> 
                            <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn login-btn">Login</button>
                            <a href="/adminForgetPassword" class="btn">Forgot password</a>
                            </div>
                            <p class="col-sm-offset-3 col-sm-9">
                                <?php echo '<span class="label label-danger">' . (isset($message) ? $message : '') . '</span>'; ?>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection