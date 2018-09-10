@extends('layouts.adminLogged')

@section('title', 'Item Management')

@section('page', 'Create Item')

@section('content')
    

    <div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">Always see first if the item already exists</p>
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="code">Item Code:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="code" id="code" placeholder="Item Code" pattern=".{6,}" maxlength="30" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="image">Image:</label>
                <div class="col-sm-9">
                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Product Name:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" pattern=".{6,}" maxlength="100" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="description">Description:</label>
                <div class="col-sm-9">
                <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Short description of the product" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="price">Percentage Price:</label>
                <div class="col-sm-5">
                <input type="number" class="form-control" name="price" id="price" placeholder="Percentage Price" step="1" required>
                </div>
            </div>
 
            <div class="form-group">
                <label class="control-label col-sm-3" for="unit">Unit:</label>
                <div class="col-sm-9">
                <select class="form-control" name="unit" id="unit" required>
                    <?php
                        foreach($unit as $u){
                            echo "
                                <option value ='".$u->name."'>".$u->name."</option>
                            ";
                        }
                    ?>
                </select>
                </div>
            </div>


            <p class="col-sm-offset-3 col-sm-9">Please add categories later in the Manage Item section</p>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-info">Create Item</button>
            </div><br>
        </form>
    </div>
    <script type="text/javascript">
        $('#image').bind('change', function() {
            var fileSize = this.files[0].size/1024/1024;
            if(fileSize > .5){
                alert("The size is too big, please use another image. If you used a phone to get the image, kindly set the resolution to low. Allowed Size: 500KB or 0.5MB.");
                $('#image').val("");
            }
        });
    </script>

@endsection