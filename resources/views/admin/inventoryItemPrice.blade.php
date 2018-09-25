@extends('layouts.adminLogged') 
@section('title', 'Inventory\'s Item Prices') 
@section('page', 'Inventory\'s Item Prices')

@section('content')
<div class="space50"></div>

<a href="/admininventory?id={{$warehouse->id}}" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>

<br/><br/>

<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-1" for="warehousename">Name:</label>
                <div class="col-sm-9">
                    <input type="text" value="{{$warehouse->name}}" name="warehousename" class="form-control" readonly/>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>List of Items</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table-bordered tablePadded" style="width:100%;">
            <tr>
                <th>Item Code</th>
                <th>Name</th>
                <th>Description</th>
                <th>Current Price</th>
                <th>Category</th>
                <th>Unit</th>
            </tr>
            @php
                if(count($priceList) > 0) {
                    foreach($priceList as $priceListItem){
                        echo "
                            <tr>
                                <td>{$priceListItem->itemCode}</td>
                                <td>{$priceListItem->name}</td>
                                <td>{$priceListItem->description}</td>
                                <td>PHP {$priceListItem->price}</td>
                                <td></td>
                                <td>{$priceListItem->unit}</td>
                                <td>
                                    <a href='/admininventoryitempricemanage?id={$warehouse->id}&code={$priceListItem->itemCode}' class='btn btn-success'>View / Edit</a>
                                </td>
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
            @endphp
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {{ $priceList->appends($_GET)->links() }}
    </div>
</div>
@endsection