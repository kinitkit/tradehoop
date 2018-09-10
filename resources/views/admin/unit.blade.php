@extends('layouts.adminLogged')

@section('title', 'Units')

@section('page', 'Units')

@section('content')
    <div class="space50"></div>

    <div class="row">
        <form method="post">
        {!! csrf_field() !!}
            <div class="form-group col-md-6">
                <input type="text" name="unit" class="form-control" placeholder="Unit" required/>
            </div>    
            <div class="col-md-1">
                <input type="submit" class="btn btn-info" value="Register" />
            </div>
        </form>
    </div>

    <div class="vspace50"></div>

    <table class="table-bordered tablePadded">
        <tr>
            <th>Unit</th>
        </tr>
        <?php
        $count = 0;
        foreach($unit as $u){
            $count++;
            echo "
            <tr>
                <td>" . $u->name . "</td>
                <td><a class='btn btn-info' href='/adminunitmanage?id=".$u->id."'>Manage</a></td>
            </tr>
            ";
        }
        echo ($count == 0) ? "<tr><td>No Category Added Yet</td></tr>" :  "";
        ?>
    </table>
@endsection