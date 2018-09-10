@extends('layouts.adminLogged')

@section('title', 'Manage Item')

@section('page', 'Manage Item')

@section('content')
<div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">Always see first if the item already exists</p>
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="code">Item Code:</label>
                <div class="col-sm-9">
                <input value="{{ $item->code }}" type="text" readonly class="form-control" name="code" id="code" placeholder="Item Code" pattern=".{6,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Product Name:</label>
                <div class="col-sm-9">
                <input value="{{ $item->name }}" type="text" class="form-control" name="name" id="name" placeholder="Product Name" pattern=".{6,}" maxlength="100" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="description">Description:</label>
                <div class="col-sm-9">
                <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Short descript of the product" required>{{ $item->description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="price">Price:</label>
                <div class="col-sm-9">
                <input value="{{ $item->price }}" type="number" class="form-control" name="price" id="price" placeholder="Percentage Price" step="1" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="unit">Unit:</label>
                <div class="col-sm-9">
                <select class="form-control" name="unit" id="unit" required>
                    <?php
                        echo "<option value='". $item->unit ."'>". $item->unit ."</option>";

                        foreach($unit as $u){
                            echo "
                                <option value ='".$u->name."'>".$u->name."</option>
                            ";
                        }
                    ?>
                </select>
                </div>
            </div>
            
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="update" class="btn btn-info">Update Item</button>
                <a href="/adminitemmanage" class="btn btn-danger">Back</a>
            </div><br>
        </form>
    </div>
@endsection