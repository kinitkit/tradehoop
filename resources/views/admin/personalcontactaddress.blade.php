<?php 
    $addressline1 = "";
    $addressline2 = "";
    $city = "";
    $region = "";
    $country = "";
    foreach($store as $p){
        if($p->type == "addressline1"){
            $addressline1 = $p->address;
        }
        if($p->type == "addressline2"){
            $addressline2 = $p->address;
        }
        if($p->type == "region"){
            $region = $p->address;
        }
        if($p->type == "city"){
            $city = $p->address;
        }
        if($p->type == "country"){
            $country = $p->address;
        }
    }
?>

@extends('layouts.adminLogged')

@section('title', 'Contact and Address')

@section('page', 'Contact and Address setting')

@section('content')
    <br>
    <div class=".space100"></div>
    <div class="col-md-6">
        <form class="form-horizontal" method="post">
        <br>
        <p class="col-sm-offset-3 col-sm-9">Address Setting</p>
        {!! csrf_field() !!}
            <div class="form-group">
                <input type="hidden" name="address" value="address">
                <label class="control-label col-sm-3" for="addressline1">Address Line 1:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="addressline1" id="addressline1" placeholder="Address Line 1" pattern=".{2,}" maxlength="200" required value="{{$addressline1}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="addressline2">Address Line 2:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="addressline2" id="addressline2" placeholder="Address Line 2" pattern=".{2,}" maxlength="200" required value="{{$addressline2}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="city">City:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="city" id="city" placeholder="City" pattern=".{2,}" maxlength="200" required value="{{$city}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="region">Region | State:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="region" id="region" placeholder="Region | State" pattern=".{2,}" maxlength="200" required value="{{$region}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="country">Country:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="country" id="country" placeholder="Country" pattern=".{2,}" maxlength="200" required value="{{$country}}">
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="col-md-6">
    <br><br>
        <p class="col-sm-offset-3 col-sm-9">Contact Setting</p>
        <form class="form-horizontal" method="post">
        {!! csrf_field() !!}
             <input type="hidden" name="contact" value="contact">
            <div class="form-group">
                <label class="control-label col-sm-3" for="contactnumber">Contact Number:</label>
                <div class="col-sm-9">
                <input type="number" class="form-control" name="contactnumber" id="contactnumber" placeholder="Contact Number" pattern=".{2,}" maxlength="11" required value="">
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-info">Add</button>
                </div>
            </div>
        </form>
        <br>
        <p class="col-sm-offset-3 col-sm-9">Contact Numbers</p>
        <div class="col-sm-offset-3 col-sm-9">
            <table class="table">
                <?php
                    if(empty($contact)){
                        echo '<p class="label label-info">No contact number yet</p>';
                    }
                    foreach($contact as $c){
                        echo "<form method='post'>"; ?> {!! csrf_field() !!} <?php
                        echo "
                            <tr>
                                <input type='hidden' name='deletecontact' value='$c->contact'>
                                <td><span><p>$c->contact<p></span></td>
                                <td>&emsp;<button type='submit' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></button></td>
                            </tr>";
                        echo '</form>';
                    }
                ?>
            </table>
        </div>
    </div>
    
@endsection