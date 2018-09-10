@extends('layouts.adminLogged') 
@section('title', 'Current Deliveries') 
@section('page', 'Current Deliveries') 
@section('content')
<div class="space50"></div>
<a href="/admininventory?id={{$warehouse->id}}" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>
<br/><br/>
<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-1" for="suppliername">Name:</label>
                <div class="col-sm-9">
                    <input type="text" value="{{$warehouse->name}}" name="suppliername" class="form-control" readonly/>
                </div>
            </div>
        </form>
        <div class="space50"></div>

        <h3>Deliveries</h3>
        <table class='table-bordered tablePadded' style="width:100%">
            <tr>
                <th>Order ID</th>
                <th>Order Created</th>
                <th>Delivery Date</th>
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
                                <td>".date("M d, Y | h:i a", strtotime($supplierorder->datecreated))."</td>
                                <td>".(isset($supplierorder->datedelivery) ? date("M d, Y", strtotime($supplierorder->datedelivery)) : "")."</td>
                                <td>".$supplierorder->description."</td>
                                <td>".$supplierorder->name."</td>
                                <td>".$supplierorder->location."</td>
                                <td><a href='/admininventorymanageorderdetails?supplierorderid=".$supplierorder->supplierorderid."' class='btn btn-info'>Manage</a></td>
                            </tr>
                        ";
                    }
                } else {
                    echo "
                        <tr>
                            <td colspan='6'><p class='text-center'><em>Currently no incoming deliveries</em></p></td>
                        </tr>
                    ";
                }
            ?>
        </table>
    </div>
</div>
@endsection