@extends('layouts.adminLogged')

@section('title', 'Add Order and Manage Order')

@section('page', 'Add Order and Manage Order')

@section('content')
    <div class="space50"><div>

    <a href="/adminsupplierordermanage?supplierid={{$supplierorder->supplierid}}" class="btn btn-warning">&emsp;Back&emsp;</a>

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
                <label class="control-label col-sm-3" for="description">Description:</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Description of the order" readonly>{{$supplierorder->description}}</textarea>
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
                    $isOrderDetailsReadOnly = false;
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
            ?>
            <div class="form-group">
                <input type="hidden" id="inpstatustype" name="inpstatustype" class="form-control" readonly/>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="status">Status:</label>
                <div class="col-sm-4">
                    <big><big><label class="{{$statusType}}">{{$statusPresented}}</label></big></big>
                </div>
                <div class="col-sm-5">
                    <div class="text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" <?php echo $isOrderDetailsReadOnly ? "disabled" : ""; ?>>
                                    Finalize <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" onclick="onClickActionFinalize(1);">Yes</a></li>
                                <li><a href="javascript:void(0)">No</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                <br><br>
                
            </div><br>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" method="get" action="adminsupplierordermanagedetailssearch">
            {!! csrf_field() !!}
                <div class="form-group">
                    <label class="control-label col-sm-3" for="description">Search:</label>
                    <div class="col-md-7">
                        <input type="text" name="search" id="search" class="form-control" pattern=".{4,}" maxlength="20" placeholder="search by itemcode or name" <?php echo $isOrderDetailsReadOnly ? "readonly" : ""; ?> required />
                        <input type="hidden" value="{{$supplierorder->supplierorderid}}" name="supplierorderid" class="form-control" readonly/>
                    </div>
                    <div class="col-md-2">
                        <div class="text-right">
                            <button type="submit" name="create" value="create" class="btn btn-info" <?php echo $isOrderDetailsReadOnly ? "disabled" : ""; ?>>Search</button>
                        </div>
                    </div>
                    {{-- <div class="col-md-9">
                        <div class="col-md-9">
                            <input type="text" name="search" id="search" class="form-control" pattern=".{4,}" maxlength="20" placeholder="search by itemcode or name" required />
                            <input type="hidden" value="{{$supplierorder->supplierorderid}}" name="supplierorderid" class="form-control" readonly/>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="create" value="create" class="btn btn-info">Search</button>
                        </div>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>

    <div style="margin: 10px;">
        <div class="space50"></div>
        
        <h3>Order Details</h3>
        <p>(List of items that will be ordered)</p>
        <table class="table-bordered tablePadded">
            <tr>
                <th>Itemcode</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Qty</th>
            </tr>
            <?php
                // $isOrderDetailsReadOnly variable was instantiated above
                foreach($supplierorderdetailsitemview as $s){
                    /*foreach($supplierorderdetailsitemview as $s){
                        echo $s->code;
                    }*/
                    echo "
                        <tr>
                            <td>".$s->code."</td>
                            <td>".$s->name."</td>
                            <td>".$s->unit."</td>
                            <form method='post' action='adminsupplierordermanagedetailsupdate'>
                                ".csrf_field()."
                                <input type='hidden' name='orderdetailsid' value='{$s->orderdetailsid}'/>
                                <input type='hidden' name='supplierorderid' value='{$supplierorder->supplierorderid}'/>
                                <td>
                                    <input style='width:100px' name='qty' type='number' value={$s->qty} ". ($isOrderDetailsReadOnly ? "readonly" : "")." />
                                </td>
                                <td>
                                    <button class='btn btn-primary' ". ($isOrderDetailsReadOnly ? "disabled" : "").">Update</button>
                                </td>
                            </form>
                            <td>
                                <form method='post' action='adminsupplierordermanagedetailsdelete'>
                                    ".csrf_field()."
                                    <input type='hidden' name='orderdetailsid' value='{$s->orderdetailsid}'/>
                                    <input type='hidden' name='supplierorderid' value='{$supplierorder->supplierorderid}'/>
                                    <button class='btn btn-danger' ". ($isOrderDetailsReadOnly ? "disabled" : "").">Delete</button>
                                </form>
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