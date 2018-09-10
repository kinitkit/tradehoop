@extends('layouts.adminLogged')

@section('title', 'Warehouse')

@section('page', 'Add Warehouse')

@section('content')
    

    <div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">Always see first if the item already exists</p>
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Name:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name of Warehouse" pattern=".{3,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="location">Location:</label>
                <div class="col-sm-9">
                <textarea name="location" id="location" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Building Name, Street, Barangay, District, City, Region" required></textarea>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-info">Add Warehouse</button>
            </div><br>
        </form>
    </div>
@endsection