@extends('layouts.adminLogged') 
@section('title', 'Manage Warehouse') 
@section('page', 'Manage Warehouse') 
@section('content')
<div class="space50">
    <div class="row">
        <div class="col-md-7">
            <form class="form-horizontal" method="post">
                {!! csrf_field() !!}
                <input value="{{ $warehouse->id }}" type="hidden" readonly class="form-control" name="id">
                <div class="form-group">
                    <label class="control-label col-sm-3" for="name">Name:</label>
                    <div class="col-sm-9">
                        <input value="{{ $warehouse->name }}" type="text" class="form-control" name="name" id="name" placeholder="Name of Warehouse"
                            pattern=".{3,}" maxlength="30" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="location">Location:</label>
                    <div class="col-sm-9">
                        <textarea name="location" id="location" class="form-control" cols="40" rows="5" maxlength="300" placeholder="Building Name, Street, Barangay, District, City, Region"
                            required>{{$warehouse->location}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="status">Status:</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="status">
                                    <option value="{{(($warehouse->status == 1) ? 1:0)}}">{{(($warehouse->status == 1) ? "Active":"Inactive")}} (current)</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="status">Locations Served:</label>
                    <div class="col-sm-9">
                        <table class="table-bordered tablePadded" style="width:100%;">
                            <tr>
                                <th>Parent Location</th>
                                <th>Location</th>
                            </tr>
                            <?php
                                if(count($warehouselocation) > 0) {
                                    foreach($warehouselocation as $loc) {
                                        echo "
                                            <tr>
                                                <td>".$loc->parentName."</td>
                                                <td>".$loc->mainName."</td>
                                                <form method='post' action='warehousemanageremovelocation'></form>
                                                <td>
                                                    <form method='post' action='warehousemanageremovelocation'>
                                                        ".csrf_field()."
                                                        <input type='hidden' name='warehouseid' value='{$loc->warehouseID}'/>
                                                        <input type='hidden' name='warehouselocationid' value='{$loc->warehouselocationID}'/>
                                                        <button type='submit' class='btn btn-danger'>Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                } else {
                                    echo "
                                        <tr>
                                            <td colspan='3'><p class='text-center'><em>Currently no locations</em></p></td>
                                        </tr>
                                    ";
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" name="update" value="update" class="btn btn-info">Update Warehouse Information</button>
                        <a href="/adminwarehouse" class="btn btn-danger">Back</a>
                    </div><br>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <form class="form-horizontal" method="post">
                {!! csrf_field() !!}
                <div id="divSearchContainer" class="form-group">
                    <label class="control-label col-sm-3" for="search">Search:</label>
                    <div class="col-md-7">
                        <input type="text" name="search" id="search" class="form-control" maxlength="20" placeholder='search a barangay | "*" to view all'
                        />
                    </div>
                    <div class="col-md-2">
                        <div class="text-right">
                            <button type="button" name="create" value="create" class="btn btn-info" onclick="onClickSubmitSearch();">Search</button>
                        </div>
                    </div>
                </div>
                <div id="divSearchResultContainer" class="form-group">
                </div>
            </form>
        </div>
    </div>

    <script>
        function onClickSubmitSearch() {
            let inpSearch = document.getElementById("search"),
                divSearchResultContainer = document.getElementById("divSearchResultContainer");
                inpSearchVal = inpSearch.value.trim();

            
            if(inpSearchVal.length > 0) {
                inpSearchVal = inpSearchVal == "*" ? "" : inpSearchVal;
                $.ajax({
                    type: 'GET',
                    url: '/adminwarehousemanagegetlocationsearch',
                    data: {searchQuery: inpSearchVal},
                    success: function(result, status, xhr) {
                        console.log(result);

                        processSearchResults(result);
                    },
                    error: function(xhr,status,error) {
                        alert(error);
                    }
                });
            } else {
                divSearchResultContainer.innerHTML = "";
            }
        }

        function processSearchResults(results){
        let divSearchResultContainer = document.getElementById("divSearchResultContainer"),
            tableHtmlStr = `
                <div class='col-sm-offset-3 col-sm-9'>
                    <table id='tbSearchResult' class='table-bordered tablePadded' style='width:100%'>
                        <tr>
                            <th>Parent Location</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </table>
                </div>
            `,
            tbSearchResult = null;

        divSearchResultContainer.innerHTML = "";
        divSearchResultContainer.insertAdjacentHTML('beforeend', tableHtmlStr);

        tbSearchResult = document.getElementById("tbSearchResult");

        if(results.length > 0) {
            results.forEach(result => {
                let trHtml = `
                    <tr>
                        <td>`+ result.lev1 +`</td>
                        <td>`+ result.lev2 +`</td>
                        <form method='post' action='adminwarehousemanagegetlocationsearch'></form>
                        <td>
                            <form method='post' action='adminwarehousemanagegetlocationsearch'>
                                {{ csrf_field() }}
                                <input type='hidden' name='warehouseid' value='{{ $warehouse->id }}'/>
                                <input type='hidden' name='locationid' value='`+ result.lev2ID +`'/>
                                <button id="btn-submit-`+ result.lev2ID +`" type="submit" class="btn btn-info" data-warehouseid="{{ $warehouse->id }}">Add</button>
                            </form>
                        </td>
                    </tr>
                `;

                tbSearchResult.insertAdjacentHTML('beforeend', trHtml);

                // const btnAdd = $('#btn-submit-'+ result.lev2ID),
                //     warehouseID = btnAdd.attr("data-warehouseid");
                // btnAdd.unbind();
                // btnAdd.on('click', () => {
                //     addLocation(result.lev2ID, warehouseID);
                // });
            });
        } else {
            let trHtml = `
                <tr>
                    <td colspan='3'><p class='text-center'><em>Nothing found</em></p></td>
                </tr>
            `;

            tbSearchResult.insertAdjacentHTML('beforeend', trHtml);
        }
    }

    function addLocation(locationID, warehouseID){
        $.ajax({
            type: 'POST',
            url: '/adminwarehousemanagegetlocationsearch',
            dataType:'json',
            data: {locationID: locationID, warehouseID: warehouseID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result, status, xhr) {
                console.log(result);

                processSearchResults(result);
            },
            error: function(xhr,status,error) {
                alert(error);
            }
        });
    }
    </script>
@endsection