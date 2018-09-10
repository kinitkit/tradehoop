@extends('layouts.adminLogged')

@section('title', 'Item Management')

@section('page', 'Item Management')

@section('content')
<div style="margin: 10px;">
    <div class="space50"></div>
    <div class="row">
        <div class="form-group col-md-6">
            <form method="post">
                {!! csrf_field() !!}
                <input type="text" name="search" class="form-control" placeholder="search" required/>
            </form>
        </div>    
    </div>
    
    <table class="table-bordered tablePadded">
        <tr>
            <th></th>
            <th>Code</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price %</th>
            <th>Unit</th>
        </tr>
        <?php
            foreach($item as $i){
                echo "
                    <tr>
                        <td><img src='" . URL::to('/') . "/items/" .$i->image."' height='100px'/></td>
                        <td>".$i->code."</td>
                        <td>".$i->name."</td>
                        <td>".$i->description."</td>
                        <td>".$i->price."</td>
                        <td>".$i->unit."</td>
                        <td><a class='btn btn-info' href='/adminitemmanageitem?itemcode=$i->code'>Manage</a></td>
                    </tr>
                ";
            }
        ?>
    </table>

    {{ $item->links() }}
</div>
@endsection