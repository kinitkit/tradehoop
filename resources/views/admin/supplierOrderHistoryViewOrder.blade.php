@extends('layouts.adminLogged') 
@section('title', 'Order and Deliver History') 
@section('page', 'Order and Deliver History')

@section('content')

<div class="space50">
    <div>
        <a href="/adminsupplierorderhistory" class="btn btn-warning">&emsp;Back&emsp;</a>

        <br/><br/>

        <div class="col-md-6">
            <form id="form-admin-details" class="form-horizontal" method="post" action="adminsupplierordermanagedetailsupdatestatus">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label class="control-label col-sm-3" for="orderid">Order ID:</label>
                    <div class="col-sm-9">
                        <input type="text" value="{{$supplierorder->supplierorderid}}" name="supplierorderid" class="form-control" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="datecreated">Date Ordered:</label>
                    <div class="col-sm-9">
                        <?php
                                $time = strtotime($supplierorder->datecreated);
                                $time = date("M d, Y | h:i a", $time)
                            ?>
                            <input value="{{$time}}" type="text" name="datecreated" id="datecreated" class="form-control" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="datedelivery">Date of Delivery:</label>
                    <div class="col-sm-9">
                        <input value="{{isset($supplierorder->datedelivery) ? date('M d, Y', strtotime($supplierorder->datedelivery)) : ''}}" type="text"
                            name="datedelivery" id="datedelivery" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="description">Description:</label>
                    <div class="col-sm-9">
                        <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Description of the order"
                            readonly>{{$supplierorder->description}}</textarea>
                    </div>
                </div>
                <?php
                    $status = $supplierorder->status;
                    $statusPresented = "";
                    $statusType = "";
                    $dropdownText = "";
                    $isOrderDetailsReadOnly = false;
    
                    if($status == 0){
                        $statusPresented = "Not Finalized";
                        $dropdownText = "Finalize";
                        $statusType = "label label-warning";
                        $isOrderDetailsReadOnly = true;
                    } else if($status == 1){
                        $statusPresented = "Finalized";
                        $statusType = "label label-info";
                        $isOrderDetailsReadOnly = false;
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
                ?>
                    <div class="form-group">
                        <input type="hidden" id="inpstatustype" name="inpstatustype" class="form-control" readonly/>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="status">Status:</label>
                        <div class="col-sm-4">
                            <big><big><label class="{{$statusType}}">{{$statusPresented}}</label></big></big>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<div style="margin: 10px;">
    <div class="space50"></div>

    <h3>Order Details</h3>
    <table class="table-bordered tablePadded">
        <tr>
            <th>Itemcode</th>
            <th>Name</th>
            <th>Unit</th>
            <th>Qty Demanded</th>
            <th>Qty Provided</th>
        </tr>
        <?php
            foreach($supplierorderdetailsitemview as $s){
                echo "
                    <tr>
                        <td>".$s->code."</td>
                        <td>".$s->name."</td>
                        <td>".$s->unit."</td>
                        <td>
                            <input style='width:100px' name='qty' type='number' value={$s->qty} readonly/>
                        </td>
                        <td>
                            <input style='width:100px' name='qtyprovided' type='number' value={$s->qtyprovided} readonly />
                        </td>
                    </tr>
                ";
                    
            }
        ?>
    </table>
    <script>
        function onClickActionFinalize(type){
            let inpStatusTypeElement = document.getElementById('inpstatustype'),
                form = document.getElementById('form-admin-details');
            
            if(type != null) {
                inpStatusTypeElement.value = type;
                form.submit();
            }
        }
    </script>
</div>
@endsection