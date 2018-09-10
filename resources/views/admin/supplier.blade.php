@extends('layouts.adminLogged')

@section('title', 'Add Supplier')

@section('page', 'Add Supplier')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">Always see first if the supplier is already existing</p>
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Supplier Name:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" placeholder="Supplier or Company Name" pattern=".{6,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="address">Address:</label>
                <div class="col-sm-9">
                <textarea name="address" id="address" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Building Name, Street, Barangay, District, City, Region" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="description">Description:</label>
                <div class="col-sm-9">
                <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="What type of supplier and other information that might help in the future" required></textarea>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="create" value="create" class="btn btn-info">Add Supplier</button>
            </div><br>
        </form>
    </div>

    <div style="margin: 10px;">
        <div class="space50"></div>
        <div class="row">
            <div class="form-group col-md-6">
                <form method="post">
                    {!! csrf_field() !!}
                    <input type="text" name="search" class="form-control" placeholder="search" required/>
                </form>
            </div>    
        </div>
        
        <table class="table-bordered tablePadded">
            <tr>
                <th>Code</th>
                <th>Supplier</th>
            </tr>
            <?php
                foreach($suppliers as $s){
                    echo "
                        <tr>
                            <td>".$s->id."</td>
                            <td>".$s->name."</td>
                            <td><a class='btn btn-info' href='/adminsuppliermanage?supplierid=$s->id'>Manage</a></td>
                            <td><a class='btn btn-default' href='/adminsupplierordermanage?supplierid=$s->id' title='orders added will go to inventory right after it is delivered.'>Add and Manage Orders</a></td>
                        </tr>
                    ";
                }
            ?>
        </table>

        {{ $suppliers->links() }}
    </div>
@endsection