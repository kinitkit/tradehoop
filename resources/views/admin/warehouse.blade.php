@extends('layouts.adminLogged')

@section('title', 'Warehouse Listing')

@section('page', 'Warehouse Listing')

@section('content')
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
            <th>Warehouse</th>
            <th>Location</th>
            <th>Status</th>
        </tr>
        <?php
            foreach($warehouse as $w){
                echo "
                    <tr>
                        <td>".$w->name."</td>
                        <td>".$w->location."</td>
                        <td>".(($w->status == 1) ? "<span title='warehouse is active and on operation' class='label label-success'>on use</span>": "<span title='warehouse is inactive and closed' class='label label-danger'>unused</span>")."</td>
                        <td><a class='btn btn-info' href='/admininventory?id=$w->id'>Inventory</a></td>
                        <td><a class='btn btn-info' href='/adminwarehousemanage?id=$w->id'>Manage</a></td>
                    </tr>
                ";
            }
        ?>
    </table>

    {{ $warehouse->links() }}
</div>
@endsection