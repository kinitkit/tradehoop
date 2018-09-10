@extends('layouts.adminLogged')

@section('title', 'Category Management')

@section('page', 'Category Management')

@section('content')
    <div class="space50"></div>

    <div class="row">
        <form method="post">
        {!! csrf_field() !!}
            <div class="form-group col-md-6">
                <input type="text" name="category" class="form-control" placeholder="Category" required/>
            </div>    
            <div class="col-md-1">
                <input type="submit" class="btn btn-info" value="Register" />
            </div>
        </form>
    </div>

    <div class="vspace50"></div>

    <table class="table-bordered tablePadded">
        <tr>
            <th>Category</th>
        </tr>
        <?php
        $count = 0;
        foreach($category as $c){
            $count++;
            echo "
            <tr>
                <td>" . $c->category . "</td>
                <td><a class='btn btn-info' href='/admincategorymanage?id=".$c->id."'>Manage</a></td>
            </tr>
            ";
        }
        echo ($count == 0) ? "<tr><td>No Category Added Yet</td></tr>" :  "";
        ?>
    </table>
@endsection