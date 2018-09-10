@extends('layouts.adminLogged')

@section('title', 'User Management')

@section('page', 'User Management')

@section('content')
    <div class="space50"><div>

    <div class="row"><div class="col-md-5">
        <form method="post">
            {!! csrf_field() !!}
            <input name="search" value="{{session('search')}}" class="form-control" type="text" placeholder="search user" required  pattern=".{3,}" maxlength="15"/>
        </form>
    </div></div>

    <br/>

    <div class="row"><div class="col-md-12">
        <table class="table-bordered tablePadded">
            <tr>
                <th>Username</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Status</th>
            </tr>
            <?php
                foreach($users as $u){
                    $gender = ($u->gender == "m") ? "Male" : "Female";
                    $status = ($u->status == 1) ? "Active" : "Deactivated";
                    $color = ($u->status == 1) ? "label-success" : "label-danger";
                    if($u->username != session('tradehoopusername')){
                        echo '
                            <tr>
                                <td>'.$u->username.'</td>
                                <td>'.$u->firstname.'</td>
                                <td>'.$u->middlename.'</td>
                                <td>'.$u->lastname.'</td>
                                <td>'.$u->email.'</td>
                                <td>'.$gender.'</td>
                                <td><span class="label '.$color.'">'.$status.'</span></td>
                                <td><a class="btn btn-primary" href="/adminusermanagementmanageuser?username='.$u->username.'">Manage</a></td>
                            </tr>
                        ';
                    }
                }
            ?>
        </table>
    </div></div>

    <div class="row"><div class="col-md-5">
        {{$users->links()}}
    </div></div>

@endsection