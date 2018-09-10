@extends('layouts.adminLogged')

@section('title', 'Add Item to Order')

@section('page', 'Add Item to Order')

@section('content')
    <div class="space50"><div>
    <a class="btn btn-warning" href="adminsupplierordermanagedetails?supplierorderid={{$supplierorderid}}">Back</a>
    <div style="margin: 10px;">

        <h3>Specify QUANTITY and click ADD</h3>
        <table class="table-bordered tablePadded">
            <tr>
                <th>Itemcode</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            <?php
                foreach($item as $i){
                    echo "
                        <tr>
                            <td>".$i->code."</td>
                            <td>".$i->name."</td>
                            <td>".$i->unit."</td>
                            <td>".$i->price."</td>
                            
                                <form method='post' action='adminsupplierordermanagedetailssearch'>
                                    " . csrf_field() ."
                                    <td>
                                        <input name='supplierorderid' type='hidden' value='".$supplierorderid."'>
                                        <input name='code' type='hidden' value='".$i->code."'>
                                        <input name='code' type='hidden' value='".$i->code."'>
                                        <input name='qty' type='number' value='1'>
                                    </td>
                                    <td>
                                        <button class='btn btn-info'>Add</button>
                                    </td>
                                </form>
                            
                        </tr>
                    ";
                     
                }
            ?>
        </table>

        
    </div>
@endsection