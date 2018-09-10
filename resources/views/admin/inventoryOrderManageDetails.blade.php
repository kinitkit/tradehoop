@extends('layouts.adminLogged') 
@section('title', 'Current Delivery') 
@section('page', 'Current Delivery') 
@section('content')

<div class="space50"></div>
<a href="/admininventorymanageorder?id={{$supplierorder->warehouseid}}" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>
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
                    $time = date("M d Y | h:i a", $time)
                ?>
                    <input value="{{$time}}" type="text" name="datecreated" id="datecreated" class="form-control" readonly/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="datedelivery">Date of Delivery:</label>
            <div class="col-sm-9">
                <input value="{{isset($supplierorder->datedelivery) ? date('M d, Y', strtotime($supplierorder->datedelivery)) : ''}}" type="text"
                    name="datedelivery" id="datedelivery" class="form-control" min="{{$supplierorder->dateMin}}" max="{{$supplierorder->dateMax}}"
                    readonly />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3" for="description">Description:</label>
            <div class="col-sm-9">
                <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Description of the order"
                    readonly>{{$supplierorder->description}}</textarea>
            </div>
        </div>
        <div class="form-group" style="display: none;">
            <div class="col-sm-9">
                <input id="btnSubmit" type="submit" value="Submit" />
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
                    $isOrderDetailsReadOnly = true;
                } else if($status == 2){
                    $statusPresented = "On Delivery";
                    $dropdownText = "Mark as delivered";
                    $statusType = "label label-primary";
                    $isOrderDetailsReadOnly = false;
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
                <input type="hidden" value="3" id="inpstatustype" name="inpstatustype" class="form-control" readonly/>
            </div>
            <div class="form-group">
                <input type="hidden" id="inpCurrentUrl" name="inpCurrentUrl" class="form-control" readonly/>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="status">Status:</label>
                <div class="col-sm-4">
                    <big><big><label class="{{$statusType}}">{{$statusPresented}}</label></big></big>
                </div>
                <div class="col-sm-5">
                    <div class="text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                <?php echo $isOrderDetailsReadOnly ? "disabled" : ""; ?>>
                                        Mark as delivered <span class="caret"></span>
                                </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick="document.getElementById('btnSubmit').click();">Yes</a></li>
                                <li><a href="javascript:void(0)">No</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#" onclick="onClickActionFinalize(4);">Cancel this order</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
<div style="margin: 10px;">
    <div class="space50"></div>

    <h3>Delivery Details</h3>
    <p>(List of items that are delivered)</p>
    <table class="table-bordered tablePadded">
        <tr>
            <th>Itemcode</th>
            <th>Name</th>
            <th>Unit</th>
            <th>Qty Demanded</th>
            <th>Qty Provided</th>
            <th>Qty Received</th>
        </tr>
        <?php
            foreach($supplierorderdetailsitemview as $s){
                echo "
                    <tr>
                        <td>".$s->code."</td>
                        <td>".$s->name."</td>
                        <td>".$s->unit."</td>
                        <form method='post' action='admininventorymanageorderdetailsupdateqtyprovided'>
                            ".csrf_field()."
                            <input type='hidden' name='orderdetailsid' value='{$s->orderdetailsid}'/>
                            <input type='hidden' name='supplierorderid' value='{$supplierorder->supplierorderid}'/>
                            <td>
                                <input style='width:100px' name='qty' type='number' value={$s->qty} readonly/>
                            </td>
                            <td>
                                <input style='width:100px' name='qtyprovided' type='number' min='0' value={$s->qtyprovided} readonly />
                            </td>
                            <td>
                                <input style='width:100px' name='qtyactual' type='number' min='0' value={$s->qtyactual} ". ($isOrderDetailsReadOnly ? "readonly" : "")." />
                            </td>
                            <td>
                                <button class='btn btn-primary' ". ($isOrderDetailsReadOnly ? "disabled" : "").">Update</button>
                            </td>
                        </form>
                        <!--<td>
                            <form method='post' action='adminsupplierordermanagedetailsdelete'>
                                ".csrf_field()."
                                <input type='hidden' name='orderdetailsid' value='{$s->orderdetailsid}'/>
                                <input type='hidden' name='supplierorderid' value='{$supplierorder->supplierorderid}'/>
                                <button class='btn btn-danger' ". ($isOrderDetailsReadOnly ? "disabled" : "").">Delete</button>
                            </form>
                        </td>-->
                    </tr>
                ";
                    
            }
        ?>
    </table>
    <script>
        window.onload = () => {
            let inpCurrentUrl = document.getElementById("inpCurrentUrl"),
                windowLocation = window.location;

            inpCurrentUrl.value = windowLocation.pathname + windowLocation.search;
        }

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