@extends('layouts.adminLogged')

@section('title', 'Add User')

@section('page', 'Add User')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3">Username:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="username" placeholder="Username" pattern=".{5,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">First name:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="firstname" placeholder="First name" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Middle name:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="middlename" placeholder="Middle name" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Last name:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="lastname" placeholder="Last name" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Email:</label>
                <div class="col-sm-9">
                <input type="email" class="form-control" name="email" placeholder="Email" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Birthdate:</label>
                <div class="col-sm-9">
                <input type="date" class="form-control" name="birthdate"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Gender:</label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label><input name="gender" type="radio" class="radio-inline" value="m" checked>Male</label>
                        <label><input name="gender" type="radio" class="radio-inline" value="f" >Female</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">User Type:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="usertype">
                        <option value="0">Master Administrator</option>
                        <option value="1">Administrator</option>
                        <option value="2">Inventory Manager</option>
                        <option value="3">Sales Manager</option>
                        <option value="4">Warehouse Manager</option>
                        <option value="5">Supplier</option>
                        <option value="6">Web Clerk</option>
                        <option value="7">Inventory Clerk</option>
                        <option value="8">Sales Clerk</option>
                        <option value="9">Packing Clerk</option>
                        <option value="10">Delivery Clerk</option>
                    </select>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="create" value="create" class="btn btn-info">Add User</button>
            </div><br/>
        </form>
    </div>
@endsection