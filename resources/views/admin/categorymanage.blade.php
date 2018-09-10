@extends('layouts.adminLogged')

@section('title', 'Manage Category')

@section('page', 'Manage Category')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">Do not override other categories</p>
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <input value="{{ $category->id }}" type="hidden" readonly class="form-control" name="id">
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Category Name:</label>
                <div class="col-sm-9">
                <input value="{{ $category->category }}" type="text" class="form-control" name="category" id="category" placeholder="Category" pattern=".{4,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="update" class="btn btn-info">Update Category</button>
                <a href="/admincategory" class="btn btn-danger">Back</a>
            </div><br>
            <p class="col-sm-offset-3 col-sm-9">
                <br>
            </p>
        </form>
    </div>
@endsection