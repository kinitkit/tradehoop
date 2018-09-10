@extends('layouts.adminLogged')

@section('title', 'Add Order and Manage Order')

@section('page', 'Add Order and Manage Order')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <p class="col-sm-offset-3 col-sm-9">After adding the order, manage the items under it.</p>
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="id">Supplier ID:</label>
                <div class="col-sm-9">
                <input value="{{$supplier->id}}" type="text" class="form-control" name="id" id="id" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Supplier Name:</label>
                <div class="col-sm-9">
                <input value="{{$supplier->name}}" type="text" class="form-control" name="name" id="name" pattern=".{6,}" maxlength="50" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="address">Address:</label>
                <div class="col-sm-9">
                    <textarea name="address" id="address" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Address of supplier" readonly>{{$supplier->address}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="supplierdescription">Supplier's Description:</label>
                <div class="col-sm-9">
                    <textarea name="supplierdescription" id="supplierdescription" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Supplier's Description" readonly>{{$supplier->description}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="warehouse">Receiving Warehouse:</label>
                <div class="col-sm-9">
                    <select name="warehouseid" id="warehouseid" class="form-control">
                        <?php
                            foreach($warehouse as $w){
                                echo '<option value="'.$w->id.'">'.$w->name.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="description">Description:</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Description of the order" required></textarea>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="create" value="create" class="btn btn-info">Add Order</button>
                <a href="/adminsupplier" class="btn btn-warning">Back</a>
            </div><br>
        </form>
    </div>

    <div style="margin: 10px;">
        <div class="space50"></div>
        
        <h3>Orders</h3>
        <table class="table-bordered tablePadded">
            <tr>
                <th>Order ID</th>
                <th>Order Created</th>
                <th>Status</th>
                <th></th>
            </tr>
            <?php
                foreach($supplierorder as $s){
                    $statusPresented = "";
                    $statusType = "";
                    $status = $s->status;
                    // if($s->status == 0){
                    //     $statusPresented = "Not Delivered";
                    //     $statusType = "label label-warning";
                    // }else if($s->status == 1){
                    //     $statusPresented = "Delivered";
                    //     $statusType = "label label-success";
                    // }else if($s->status == 2){
                    //     $statusPresented = "Cancelled";
                    //     $statusType = "label label-danger";
                    // }
                    if($status == 0){
                        $statusPresented = "Not Finalized";
                        $statusType = "label label-warning";
                    } else if($status == 1){
                        $statusPresented = "Finalized";
                        $statusType = "label label-info";
                        $isOrderDetailsReadOnly = true;
                    } else if($status == 2){
                        $statusPresented = "On Delivery";
                        $dropdownText = "Mark as delivered";
                        $statusType = "label label-primary";
                        $isOrderDetailsReadOnly = true;
                    } else if($status == 3){
                        $statusPresented = "Delivered";
                        $statusType = "label label-success";
                        $isOrderDetailsReadOnly = true;
                    } else if($status == 4){
                        $statusPresented = "Cancelled";
                        $statusType = "label label-danger";
                        $isOrderDetailsReadOnly = true;
                    }
                    $time = strtotime($s->datecreated);
                    echo "
                        <tr>
                            <td>".$s->supplierorderid."</td>
                            <td>".date("M d Y | h:i a", $time)."</td>
                            <td><label class='".$statusType."'>".$statusPresented."</label></td>
                            <td>
                                <a href='/adminsupplierordermanagedetails?supplierorderid=".$s->supplierorderid."' class='btn btn-info'>Manage</a>
                            </td>
                        </tr>
                    ";
                     
                }
            ?>
        </table>

        {{$supplierorder->links()}}
        
    </div>
@endsection