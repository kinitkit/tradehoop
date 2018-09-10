@extends('layouts.adminLogged') 
@section('title', 'New Address') 
@section('page', 'New Address') 
@section('content')
<div class="space50"></div>

<a href="/settingsAddress" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>

<br/><br/>

<div class="row">
    <div class="col-md-6">
        <form id="form-admin-details" class="form-horizontal" method="post" action="settingsAddressNew">
            {!! csrf_field() !!}
            <div class="form-group">
                <label class="control-label col-sm-3" for="name">Name:</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" maxlength="100" required />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3" for="type">Location Type:</label>
                <div class="col-md-9">
                    <select id="type" name="type" class="form-control" onchange="onChangeLocationType(event);" required>
                        <?php
                            if(isset($locationTypes)) {
                                foreach($locationTypes as $locationType) {
                                    echo "<option value={$locationType->locationTypeID}>{$locationType->name}</option>";
                                };
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div id="divParentLocation" class="form-group" style="display:none;">
                <label class="control-label col-md-3" for="parentLocation">Parent Location:</label>
                <div class="col-md-9">
                    <select id="parentLocation" name="parentLocation" class="form-control" required>
                        <option value="1">World</option>
                    </select>
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
                    <button id="btnSave" class="btn btn-success" type="submit" value="Save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function onChangeLocationType(event) {
        let selectLocationType = event.target,
            locationTypeID = selectLocationType.value,
            params = {
                selectLocationType: selectLocationType,
                locationTypeID: locationTypeID
            };

        processOnChangeLocationType(params);
    }

    function processOnChangeLocationType(params) {
        const selectParentLocation = document.getElementById("parentLocation"),
            divParentLocation = document.getElementById("divParentLocation"),
            btnSave = document.getElementById("btnSave"),
            insertDefaultParentLocationParams = {
                selectParentLocation: selectParentLocation,
                divParentLocation: divParentLocation
            };
        let locationTypeID = params.locationTypeID;

        if(locationTypeID) {
            --locationTypeID;
            btnSave.disabled = true;
            
            $.ajax({
                type: 'GET',
                url: '/settingsAddressGetParentLocation',
                data: {locationTypeID: locationTypeID},
                success: function(result, status, xhr) {
                    btnSave.disabled = false;
                    const locations = result.locations;

                    if(locations && selectParentLocation) {
                        divParentLocation.style.display = "block";
                        selectParentLocation.innerHTML = "";

                        locations.forEach(location => {
                            selectParentLocation.insertAdjacentHTML("beforeend", `
                                <option value="${location.locationID}">${location.name}</option>
                            `);
                        });

                        if(locationTypeID < 2) {
                            divParentLocation.style.display = "none";
                        }
                    }
                },
                error: function(xhr,status,error) {
                    alert(error);
                    // btnSave.disabled = false;
                    insertDefaultParentLocation(insertDefaultParentLocationParams);
                }
            });
        } else {
            divParentLocation.style.display = "none";
        }
    }

    function insertDefaultParentLocation(params){
        const selectParentLocation = params.selectParentLocation,
            divParentLocation = params.divParentLocation;

        divParentLocation.style.display = "none";
        selectParentLocation.insertAdjacentHTML("beforeend", `
            <option value="1">World</option>
        `);
    }

</script>
@endsection