@extends('layouts.adminLogged')

@section('title', 'Manage User')

@section('page', 'Manage User')

@section('content')
    <div class="space50"><div>
    <div class="col-md-6">
        <form id="form-userinfo" class="form-horizontal" method="POST" action="adminusermanagementmanageuserUpdate" onsubmit="return onSubmitForm(event);">
        {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3">Username:</label>
                <div class="col-sm-9">
                <input value="{{$user->username}}" type="text" class="form-control" name="username" placeholder="username" pattern=".{5,}" maxlength="30" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">First name:</label>
                <div class="col-sm-9">
                <input value="{{$user->firstname}}" type="text" class="form-control" name="firstname" placeholder="First name" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Middle name:</label>
                <div class="col-sm-9">
                <input value="{{$user->middlename}}" type="text" class="form-control" name="middlename" placeholder="Middle name" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Last name:</label>
                <div class="col-sm-9">
                <input value="{{$user->lastname}}" type="text" class="form-control" name="lastname" placeholder="Last name" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Email:</label>
                <div class="col-sm-9">
                <input value="{{$user->email}}" type="email" class="form-control" name="email" placeholder="Email" pattern=".{2,}" maxlength="50" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Birthdate:</label>
                <div class="col-sm-9">
                <input value="{{$user->birthdate}}" type="date" class="form-control" name="birthdate"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Gender:</label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label><input name="gender" type="radio" class="radio-inline" <?php echo ($user->gender == "m") ? "checked" : "" ?> value="m">Male</label>
                        <label><input name="gender" type="radio" class="radio-inline" <?php echo ($user->gender == "f") ? "checked" : "" ?> value="f">Female</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Status:</label>
                <div class="col-sm-9">
                    <div class="radio">
                        <label><input name="status" type="radio" class="radio-inline" <?php echo ($user->status == "1") ? "checked" : "" ?> value="1">Active</label>
                        <label><input name="status" type="radio" class="radio-inline" <?php echo ($user->status == "0") ? "checked" : "" ?> value="0">Deactivated</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">User Type:</label>
                <div class="col-sm-9">
                    <select id="usertype" class="form-control" name="usertype" value="{{$user->usertype}}" onchange="onChangeUserType(event);">
                        <option <?php echo ($user->usertype == 0) ? "selected" : "" ?> value="0">Master Administrator</option>
                        <option <?php echo ($user->usertype == 1) ? "selected" : "" ?> value="1">Administrator</option>
                        <option <?php echo ($user->usertype == 2) ? "selected" : "" ?> value="2">Inventory Manager</option>
                        <option <?php echo ($user->usertype == 3) ? "selected" : "" ?> value="3">Sales Manager</option>
                        <option <?php echo ($user->usertype == 4) ? "selected" : "" ?> value="4">Warehouse Manager</option>
                        <option <?php echo ($user->usertype == 5) ? "selected" : "" ?> value="5">Supplier</option>
                        <option <?php echo ($user->usertype == 6) ? "selected" : "" ?> value="6">Web Clerk</option>
                        <option <?php echo ($user->usertype == 7) ? "selected" : "" ?> value="7">Inventory Clerk</option>
                        <option <?php echo ($user->usertype == 8) ? "selected" : "" ?> value="8">Sales Clerk</option>
                        <option <?php echo ($user->usertype == 9) ? "selected" : "" ?> value="9">Packing Clerk</option>
                        <option <?php echo ($user->usertype == 10) ? "selected" : "" ?> value="10">Delivery Clerk</option>
                    </select>
                </div>
            </div>
            <?php
                echo (strlen($user->supplierid) > 0 ? 
                    "<div class='form-group'>
                        <label class='control-label col-sm-3' for='supplier'>Supplier:</label>
                        <div class='col-md-9'>
                            <input id='supplier' value='{$user->suppliername}' type='text' name='supplier' class='form-control' placeholder='Supplier' readonly />
                        </div>
                    </div>" : "");
            ?>
            <div id="divSearchContainer" class="form-group" style="display:none;">
                <label class="control-label col-sm-3" for="search">Search:</label>
                <div class="col-md-7">
                    <input type="text" name="search" id="search" class="form-control" maxlength="20" placeholder='search supplier | "*" to view all' />
                </div>
                <div class="col-md-2">
                    <div class="text-right">
                        <button type="button" name="create" value="create" class="btn btn-info" onclick="onClickSubmitSearch();">Search</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input id="inpNewSupplier" type="hidden" class="form-control" name="newsupplier" />
            </div>
            <div id="divSearchResultContainer" class="form-group">
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" name="create" value="create" class="btn btn-info">Update User</button>
                <a href="/adminusermanagement" class="btn btn-warning">Back</a>
            </div><br/>
        </form>
    </div>

    <script>
        window.onload = function() {
            let userType = "<?php echo $user->usertype ?>";

            processUserType(userType);
        }

        function onSubmitForm(event) {
            let selectUserType = document.getElementById("usertype"),
                inpNewSupplier = document.getElementById("inpNewSupplier"),
                inpSupplier =  document.getElementById("supplier"),
                userType = selectUserType.value,
                newSupplierValue = inpNewSupplier.value;
                supplierValue = "";

            if(inpSupplier == null) {
                supplierValue = inpSupplier.value;
            }

            if(userType == 5 && newSupplierValue == "" && supplierValue.trim() == "") {
                alert("Please choose a supplier!");
                event.preventDefault();
                return false;
            }
        }

        function onClickSubmitSearch() {
            let formUserinfo = document.getElementById("form-userinfo"),
                username = "<?php echo $user->username ?>",
                inpSearch = document.getElementById("search"),
                inpSearchVal = inpSearch.value.trim();

            
            if(inpSearchVal.length > 0) {
                inpSearchVal = inpSearchVal == "*" ? "" : inpSearchVal;
                $.ajax({
                    type: 'GET',
                    url: '/searchsupplierforuser',
                    data: {username: username, searchQuery: inpSearchVal},
                    success: function(result, status, xhr) {
                        console.log(result);
                        let suppliers = result;

                        processSearchResults(suppliers);
                    },
                    error: function(xhr,status,error) {
                        alert(error);
                    }
                });
            } else {
                processSearchResults([]);
            }
        }

        function onClickSubmitUpdate() {

        }

        function onChangeUserType(event) {
            let divSearchContainer = document.getElementById("divSearchContainer"),
                selectUserType = event.target,
                userType = selectUserType.value;

            processUserType(userType);
        }

        function processUserType(userType){
            let inpNewSupplier = document.getElementById("inpNewSupplier");
            inpNewSupplier.value = "";

            switch(userType){
                case "5":
                    divSearchContainer.style.display = "block";
                    break;
                default:
                    divSearchContainer.style.display = "none";
                    break;
            }
        }

        function processSearchResults(suppliers){
            let divSearchResultContainer = document.getElementById("divSearchResultContainer");
            divSearchResultContainer.innerHTML = "";

            if(suppliers.length > 0) {
                let tableHtmlStr = `
                        <div class='col-sm-offset-3 col-sm-9'>
                            <table id='tbSearchResult' class='table-bordered tablePadded'>
                                <tr>
                                    <th>Selection</th>
                                    <th>Supplier</th>
                                </tr>
                            </table>
                        </div>
                    `,
                    tbSearchResult = null;
                
                divSearchResultContainer.insertAdjacentHTML('beforeend', tableHtmlStr);
                tbSearchResult = document.getElementById("tbSearchResult");

                suppliers.forEach(supplier => {
                    let trHtml = `
                        <tr>
                            <td><input id='supplier-`+ supplier.id +`' type='checkbox' name='cb-supplier' value='`+ supplier.id +`' onclick='onClickCheckBoxSupplier(event);' /></td>
                            <td>`+ supplier.name +`</td>
                        </tr>
                    `;

                    tbSearchResult.insertAdjacentHTML('beforeend', trHtml);
                });
            }
        }

        function onClickCheckBoxSupplier(event){
            let targetElement = event.target,
                targetElementID = targetElement.id,
                targetElementValue = targetElement.value,
                isChecked = targetElement.checked,
                inpNewSupplier = document.getElementById("inpNewSupplier");

            if(isChecked) {
                let suppliersCB = document.getElementsByName("cb-supplier");
                inpNewSupplier.value = targetElementValue;
                suppliersCB.forEach(supplierCB => {
                    if(supplierCB.id != targetElementID) {
                        supplierCB.checked = false;
                    }
                })
            } else {
                inpNewSupplier.value = "";
            }
            
            // console.log(event, isChecked, document.getElementById(targetElement.id).checked);
        }
    </script>
@endsection