@extends('layouts.adminLogged')

@section('title', 'Add Supplier')

@section('page', 'Add Supplier')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Supplier Name:</label>
                <div class="col-sm-9">
                <input value="{{$supplier->name}}" type="text" class="form-control" name="name" id="name" placeholder="Supplier or Company Name" pattern=".{6,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="address">Address:</label>
                <div class="col-sm-9">
                <textarea name="address" id="address" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Building Name, Street, Barangay, District, City, Region" required>{{$supplier->address}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="description">Description:</label>
                <div class="col-sm-9">
                <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="What type of supplier and other information that might help in the future" required>{{$supplier->description}}</textarea>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="create" value="create" class="btn btn-info">Update Supplier</button>
                <a href="/adminsupplier" class="btn btn-warning">Back</a>
            </div><br>
        </form>
    </div>
@endsection