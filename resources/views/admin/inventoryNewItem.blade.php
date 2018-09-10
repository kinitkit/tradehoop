@extends('layouts.adminLogged') 
@section('title', 'Create Adjustment') 
@section('page', 'Create Adjustment') 
@section('content')
<div class="space50"></div>

<a href="/admininventoryitem?id={{$warehouse->id}}" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>

<br/><br/>

<div class="col-md-6">
    <form class="form-horizontal" method="POST" action="admininventorynewitemprocess">
        {!! csrf_field() !!}
        <div class="form-group">
            <div class="col-md-9">
                <input type="hidden" value="{{$warehouse->id}}" name="warehouseid" class="form-control" readonly/>
            </div>
        </div>
        <div id="divSearchContainer" class="form-group">
            <label class="control-label col-md-3" for="search">Search:</label>
            <div class="col-md-7">
                <input type="text" name="search" id="search" class="form-control" maxlength="20" placeholder='search item | "*" to view all'
                />
            </div>
            <div class="col-md-2">
                <div class="text-right">
                    <button type="button" name="search" value="search" class="btn btn-info" onclick="onClickSubmitSearch();">Search</button>
                </div>
            </div>
        </div>
        <div id="divSearchResultContainer" class="form-group">
        </div>
        <div class="form-group">
            <label class="control-label col-md-3" for="itemcode">Item Code:</label>
            <div class="col-md-9">
                <input id="itemcode" type="text" name="itemcode" class="form-control readonly" required />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3" for="itemname">Item Name:</label>
            <div class="col-md-9">
                <input id="itemname" type="text" name="itemname" class="form-control readonly" required/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3" for="itemquantity">Quantity:</label>
            <div class="col-md-9">
                <input type="number" name="itemquantity" class="form-control" min="1" required />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3" for="itemprice">Price:</label>
            <div class="col-md-9">
                <input type="number" name="itemprice" class="form-control" min="1" required />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3" for="itemtype">Type:</label>
            <div class="col-md-9">
                <select name="itemtype" class="form-control">
                    <option value="0">In</option>
                    <option value="1">Out</option>
                    <option value="2">Lost</option>
                    <option value="3">Damaged</option>
                    <option value="4">Returned</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3" for="itemremarks">Remarks:</label>
            <div class="col-md-9">
                <textarea name="itemremarks" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
                <div class="checkbox">
                    <label><input type="checkbox" name="itemsubmitanother" <?php echo isset($submitanother) ? " checked" : ""; ?>>Submit another</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
                <button class="btn btn-success" type="submit" value="Save">Save</button>
            </div>
        </div>
    </form>
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
                url: '/admininventorysearchnewinventoryitem',
                data: {searchQuery: inpSearchVal},
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
            divSearchResultContainer.innerHTML = "";
        }
    }

    function processSearchResults(results){
        let divSearchResultContainer = document.getElementById("divSearchResultContainer"),
            tableHtmlStr = `
                <div class='col-sm-offset-3 col-sm-9'>
                    <table id='tbSearchResult' class='table-bordered tablePadded' style='width:100%'>
                        <tr>
                            <th>Selection</th>
                            <th>Code</th>
                            <th>Name</th>
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
                        <td><input id='item-`+ result.code +`' type='checkbox' name='cb-item' value='`+ result.code +`' data-text='`+ result.name +`' onclick='onClickCheckBoxItem(event);' /></td>
                        <td>`+ result.code +`</td>
                        <td>`+ result.name +`</td>
                    </tr>
                `;

                tbSearchResult.insertAdjacentHTML('beforeend', trHtml);
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

    function onClickCheckBoxItem(event){
        let targetElement = event.target,
            targetElementID = targetElement.id,
            targetElementValue = targetElement.value,
            targetElementText = targetElement.getAttribute('data-text'),
            isChecked = targetElement.checked,
            inpItemcode = document.getElementById("itemcode"),
            inpItemname = document.getElementById("itemname");

        if(isChecked) {
            let suppliersCB = document.getElementsByName("cb-item");
            inpItemcode.value = targetElementValue;
            inpItemname.value = targetElementText;
            suppliersCB.forEach(supplierCB => {
                if(supplierCB.id != targetElementID) {
                    supplierCB.checked = false;
                }
            })
        } else {
            inpItemcode.value = "";
            inpItemname.value = "";
        }
    }

    $(".readonly").on('focus', function(e){
        $(this).blur();
    });

    $(".readonly").on('keydown paste', function(e){
        e.preventDefault();
    });
</script>
@endsection