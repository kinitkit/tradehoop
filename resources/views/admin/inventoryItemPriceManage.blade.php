@extends('layouts.adminLogged') 
@section('title', 'Item Price Management') 
@section('page', 'Item Price Management')

@section('content')
<div class="space50"></div>

<a href="/admininventoryitemprice?id={{$warehouse->id}}" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>

<br/><br/>

<div class="row">
    <div class="col-md-6">
        <form action="admininventoryitempricemanage" method="POST" class="form-horizontal" data-toggle="validator">
            {!! csrf_field() !!}
            <div class="form-group">
                <div class="col-sm-9">
                    <h3>Set New Price</h3>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="warehousename">Amount:</label>
                <div class="col-md-7">
                    <input type='hidden' name='warehouseid' value='{{ $warehouse->id }}'/>
                    <input type='hidden' name='itemcode' value='{{ $itemcode }}'/>
                    <input id="amount" type="text" class="form-control" name="amount" data-amount="amount" required>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9">
                    <button type="submit" name="set" value="set" class="btn btn-success">Set</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Price History</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table-bordered tablePadded">
            <tr>
                <th>Revision Date</th>
                <th>Price</th>
                <th>Revised By</th>
            </tr>
            @php
                if(count($priceList) > 0) {
                    foreach($priceList as $priceListItem){
                        $time = strtotime($priceListItem->DT_revision);
                        $time = date("M d, Y | h:i a", $time);
                        $price = number_format($priceListItem->price, 2, ".", ",");

                        echo "
                            <tr>
                                <td>{$time}</td>
                                <td>PHP {$price}</td>
                                <td>{$priceListItem->username}</td>
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
@push('scripts-content')
    @include('partials.scripts.currency_mask')
    <script src="{{ asset('vendor/bootstrap-validator/dist/validator.min.js') }}"></script>

    <script>
        $(function () {
            let validatorOptions = {
                custom: {
                    amount: function ($el) {
                        let amount = $el.val().trim().replace(",", "");
                        
                        if(amount <= 0) {
                            $el.val('');
                            return "Amount should not be less than or equal to 0";
                        }
                    }
                },
                focus: false
            }
            $('form').validator(validatorOptions).on('submit', function (e) {
                if (!e.isDefaultPrevented())
                    return true;
            });
        });
    </script>
@endpush