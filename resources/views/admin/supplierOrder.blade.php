@extends('layouts.adminLogged') 
@section('title', 'Current Orders') 
@section('page', 'Current Orders') 
@section('content')
<div class="space50">
    <div class="col-md-6">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="suppliername">Name:</label>
                <div class="col-sm-9">
                    <input type="text" value="{{$supplier->name}}" name="suppliername" class="form-control" readonly/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="supplieraddress">Address:</label>
                <div class="col-sm-9">
                    <textarea id="supplieraddress" name="supplieraddress" class="form-control" cols="40" rows="3" readonly>{{$supplier->address}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="supplierdescription">Description:</label>
                <div class="col-sm-9">
                    <textarea id="supplierdescription" name="supplierdescription" class="form-control" cols="40" rows="3" readonly>{{$supplier->description}}</textarea>
                </div>
            </div>
        </form>
        <div style="margin: 10px;">
            <div class="space50"></div>

            <h3>Orders</h3>
            <table class='table-bordered tablePadded' style="width:100%">
                <tr>
                    <th>Order ID</th>
                    <th>Order Created</th>
                    <th>Description</th>
                    <th>Warehouse</th>
                    <th>Location</th>
                    <th></th>
                </tr>
                <?php
                    if(count($supplierorders) > 0) {
                        foreach($supplierorders as $supplierorder){
                            echo "
                                <tr>
                                    <td>".$supplierorder->supplierorderid."</td>
                                    <td>".date("M d Y | h:i a", strtotime($supplierorder->datecreated))."</td>
                                    <td>".$supplierorder->description."</td>
                                    <td>".$supplierorder->name."</td>
                                    <td>".$supplierorder->location."</td>
                                    <td><a href='/adminsupplierordermanageorder?supplierorderid=".$supplierorder->supplierorderid."' class='btn btn-info'>Manage</a></td>
                                </tr>
                            ";
                        }
                    } else {
                        echo "
                            <tr>
                                <td colspan='6'><p class='text-center'><em>Currently no orders</em></p></td>
                            </tr>
                        ";
                    }
                    
                ?>
            </table>
        </div>
    </div>
</div>
@endsection