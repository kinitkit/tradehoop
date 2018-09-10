@extends('layouts.adminLogged') 
@section('title', 'Address') 
@section('page', 'Address') 
@section('content')
<div class="space50"></div>

<a href="/admin" class="btn btn-warning" style="width:fit-content;">&emsp;Back&emsp;</a>

<br/><br/>

<div class="row" style="margin-bottom:10px;">
    <div class="col-md-12">
        <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <a role="button" href="/settingsAddressNew" class="btn btn-info">Add New Location</a>
        </div>
    </div>
</div>
<div class="row" style="margin-bottom:10px;">
    <div class="col-md-4">
        <table id="tableLocation" class='table-bordered tablePadded' style="width:100%;">
        </table>
    </div>
</div>

<script>
    function onBeforeOnLoad() {
        try {
            let locations = `<?php echo json_encode($locations); ?>`,
                newLocation = [];

            if(locations) {
                locations = JSON.parse(locations);

                locations.forEach(location => {
                    if(location.lev1ID) {
                        let lev1Index = newLocation.findIndex(newLoc => {
                            return newLoc.id == location.lev1ID;
                        });

                        if(lev1Index < 0) {
                            let newLev1Entry = {
                                id: location.lev1ID,
                                name: location.lev1,
                                children: [],
                                locationTypeID: location.lev1TypeID
                            };

                            if(location.lev2ID) {
                                let newLev2Entry = {
                                    id: location.lev2ID,
                                    name: location.lev2,
                                    children: [],
                                    locationTypeID: location.lev2TypeID
                                };

                                if(location.lev3ID) {
                                    let newLev3Entry = {
                                        id: location.lev3ID,
                                        name: location.lev3,
                                        locationTypeID: location.lev3TypeID
                                    };

                                    newLev2Entry.children.push(newLev3Entry);
                                }

                                newLev1Entry.children.push(newLev2Entry);
                            }

                            newLocation.push(newLev1Entry);
                        } else {
                            if(location.lev2ID) {
                                let lev1Children = newLocation[lev1Index],
                                    lev2Index = lev1Children.children.findIndex(newLoc => {
                                        return newLoc.id == location.lev2ID;
                                    });

                                if(lev2Index < 0) {
                                    let newLev2Entry = {
                                        id: location.lev2ID,
                                        name: location.lev2,
                                        children: [],
                                        locationTypeID: location.lev2TypeID
                                    };

                                    if(location.lev3ID) {
                                        let newLev3Entry = {
                                            id: location.lev3ID,
                                            name: location.lev3,
                                            locationTypeID: location.lev3TypeID
                                        };

                                        newLev2Entry.children.push(newLev3Entry);
                                    }

                                    lev1Children.children.push(newLev2Entry);
                                } else {
                                    if(location.lev3ID) {
                                        let lev2Children = newLocation[lev1Index].children,
                                            lev3Index = lev2Children.findIndex(newLoc => {
                                                // console.log("newLoc", newLoc, );
                                                return newLoc.id == location.lev2ID;
                                            });

                                        if(location.lev3ID) {
                                            let newLev3Entry = {
                                                id: location.lev3ID,
                                                name: location.lev3,
                                                locationTypeID: location.lev3TypeID
                                            };

                                            lev2Children[lev3Index].children.push(newLev3Entry);
                                        }
                                    }
                                }
                            }
                        }
                    }
                });

                console.log("newLocation", newLocation);
            }

            let tableLocation = document.getElementById("tableLocation");
            tableLocation.innerHTML = "";

            tableLocation.insertAdjacentHTML('beforeend',`
                <tr>
                    <th>Country</th>
                    <th>City</th>
                    <th>Barangay</th>
                    <th>Actions</th>
                </tr>
            `);

            newLocation.forEach(location => {
                tableLocation.insertAdjacentHTML('beforeend',`
                    <tr>
                        <td>${location.name}</td>
                        <td></td>
                        <td></td>
                        <td><button>Edit</button></td>
                    </tr>
                `);

                if(location.children) {
                    location.children.forEach(locationCity => {
                        tableLocation.insertAdjacentHTML('beforeend',`
                            <tr>
                                <td></td>
                                <td>${locationCity.name}</td>
                                <td></td>
                                <td><button>Edit</button></td>
                            </tr>
                        `);

                        if(locationCity.children) {
                            locationCity.children.forEach(locationBarangay => {
                                tableLocation.insertAdjacentHTML('beforeend',`
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>${locationBarangay.name}</td>
                                        <td><button>Edit</button></td>
                                    </tr>
                                `);
                            })
                        }
                    });
                }
            });
        } catch(Exception) {
            console.log(Exception);
        }
    }

    window.addEventListener('load', function() {
        setTimeout(() => {
            onBeforeOnLoad();
        }, 500);
        
    }, true);

</script>
@endsection