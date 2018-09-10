@extends('layouts.adminLogged')

@section('title', 'Manage Unit')

@section('page', 'Manage Unit')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">Do not override other units</p>
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <input value="{{ $unit->id }}" type="hidden" readonly class="form-control" name="id">
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Unit Name:</label>
                <div class="col-sm-9">
                <input value="{{ $unit->name }}" type="text" class="form-control" name="name" id="name" placeholder="Category" pattern=".{4,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="update" class="btn btn-info">Update Unit</button>
                <a href="/adminunit" class="btn btn-danger">Back</a>
            </div><br>
        </form>
    </div>
@endsection