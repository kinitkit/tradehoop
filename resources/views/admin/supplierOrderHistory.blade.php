@extends('layouts.adminLogged') 
@section('title', 'Order and Deliver History') 
@section('page', 'Order and Deliver History')

@section('content')
<?php
?>
<div class="space50">
    <div>
        <h3>Orders</h3>
        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-2">
                    <select id="viewby" name="viewby" class="form-control" onChange="window.location.href=this.value">
                        <option value="?status=0">All</option>
                        <option value="?status=1">Finalized</option>
                        <option value="?status=2">On Delivery</option>
                        <option value="?status=3">Delivered</option>
                        <option value="?status=4">Cancelled</option>
                    </select>
                </div>
            </div>
        </form>
        <table class="table-bordered tablePadded">
            <tr>
                <th>Order ID</th>
                <th>Order Created</th>
                <th>Delivery Date</th>
                <th>Description</th>
                <th>Warehouse</th>
                <th>Location</th>
                <th>Status</th>
                <th></th>
            </tr>
            <?php
                if(count($supplierorders) > 0) {
                    foreach($supplierorders as $supplierorder){
                        $statusPresented = "";
                        $statusType = "";
                        $status = $supplierorder->supplierorderstatus;

                        if($status == 0){
                            $statusPresented = "Not Finalized";
                            $statusType = "label label-warning";
                        } else if($status == 1){
                            $statusPresented = "Finalized";
                            $statusType = "label label-info";
                        } else if($status == 2){
                            $statusPresented = "On Delivery";
                            $dropdownText = "Mark as delivered";
                            $statusType = "label label-primary";
                        } else if($status == 3){
                            $statusPresented = "Delivered";
                            $statusType = "label label-success";
                        } else if($status == 4){
                            $statusPresented = "Cancelled";
                            $statusType = "label label-danger";
                        }

                        echo "
                            <tr>
                                <td>".$supplierorder->supplierorderid."</td>
                                <td>".date("M d, Y | h:i a", strtotime($supplierorder->datecreated))."</td>
                                <td>".(isset($supplierorder->datedelivery) ? date("M d, Y", strtotime($supplierorder->datedelivery)) : "")."</td>
                                <td>".$supplierorder->description."</td>
                                <td>".$supplierorder->name."</td>
                                <td>".$supplierorder->location."</td>
                                <td><label class='".$statusType."'>".$statusPresented."</label></td>
                                <td><a href='/adminsupplierorderhistoryvieworder?supplierorderid=".$supplierorder->supplierorderid."' class='btn btn-info'>View</a></td>
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
<script>
    function onBeforeOnLoad(){
        let viewby = document.getElementById("viewby"),
            windowLocationSearch = window.location.search.substring(1),
            searchFilterStr = "status=";

        
        if(viewby) {
            if(windowLocationSearch) {
                let windowLocationSearchArr = windowLocationSearch.split("&");
                windowLocationSearchArr.forEach(item => {
                    if(item.startsWith(searchFilterStr)) {
                        let itemArr = item.split(searchFilterStr);
                        if(itemArr.length > 1) {
                            let index = itemArr[1];
                            viewby.selectedIndex = index && index > 0 && index < 5 ? index : -1;
                        }
                    }
                });
            } else {
                viewby.selectedIndex = 0;
            }
        }
    }

    onBeforeOnLoad();

</script>
@endsection