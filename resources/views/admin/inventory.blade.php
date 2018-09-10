@extends('layouts.adminLogged') 
@section('title', 'Inventory') 
@section('page', 'Inventory') 
@section('content')
<div class="space50"></div>

<a href="/adminwarehouse" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>

<br/><br/>

<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal">
            <!--<div class="form-group">
                <label class="control-label col-sm-3" for="orderid">Warehouse ID:</label>
                <div class="col-sm-9">
                    <input type="text" value="{{$warehouse->id}}" name="warehouseid" class="form-control" readonly/>
                </div>
            </div>-->
            <div class="form-group">
                <label class="control-label col-sm-1" for="warehousename">Name:</label>
                <div class="col-sm-9">
                    <input type="text" value="{{$warehouse->name}}" name="warehousename" class="form-control" readonly/>
                </div>
            </div>
            <!--<div class="form-group">
                <label class="control-label col-sm-3" for="warehouselocation">Location:</label>
                <div class="col-sm-9">
                    <textarea name="warehouselocation" class="form-control" cols="40" rows="3" maxlength="300" readonly>{{$warehouse->location}}</textarea>
                </div>
            </div>-->
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Current List of Items</h3>
    </div>
</div>
<div class="row" style="margin-bottom:10px;">
    <div class="col-md-12">
        <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <a role="button" href="/admininventorymanageorder?id={{$warehouse->id}}" class="btn btn-info">View Incoming deliveries</a>
            <a role="button" href="/admininventoryitem?id={{$warehouse->id}}" class="btn btn-info">View Inventory's Item History</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table-bordered tablePadded" style="width:100%;">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Unit</th>
            </tr>
            <?php
                if(count($inventory) > 0) {
                    foreach($inventory as $inventoryItems){
                        // $typePresented = "";
                        // $typeType = "";
                        // $type = $inventoryItems->type;

                        // if($type == 0){
                        //     $typePresented = "In";
                        //     $typeType = "label label-success";
                        // } else if($type == 1){
                        //     $typePresented = "Out";
                        //     $typeType = "label label-info";
                        // } else if($type == 2){
                        //     $typePresented = "Lost";
                        //     $typeType = "label label-warning";
                        // } else if($type == 3){
                        //     $typePresented = "Damaged";
                        //     $typeType = "label label-danger";
                        // } else if($type == 4){
                        //     $typePresented = "Returned";
                        //     $typeType = "label label-primary";
                        // }

                        $totalQty = $inventoryItems->totalQty;
                        $totalQty = isset($totalQty) ? intval($totalQty) : "0";
                        $totalQty = $totalQty < 0 ? 0 : $totalQty;

                        echo "
                            <tr>
                                <td>".$inventoryItems->code."</td>
                                <td>".$inventoryItems->name."</td>
                                <td>".$inventoryItems->description."</td>
                                <td>".$totalQty."</td>
                                <td>".$inventoryItems->price."</td>
                                <td>".$inventoryItems->unit."</td>
                            </tr>
                        ";
                    }
                } else {
                    echo "
                        <tr>
                            <td colspan='8'><p class='text-center'><em>Currently no items</em></p></td>
                        </tr>
                    ";
                }
            ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {{ $inventory->appends($_GET)->links() }}
    </div>
</div>
@endsection