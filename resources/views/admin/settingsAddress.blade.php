@extends('layouts.adminLogged') 
@section('title', 'Address') 
@section('page', 'Address') 
@section('content')
<div class="space50"></div>

<div class="col-sm-8">
    <div class="mb-10">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-location-addparent">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Location
        </button>
    </div>
    <div id="location-tree">
    </div>
    <div class="dropdown">
        <ul id="tree-menu" class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="#menu-location-add"><i class="glyphicon glyphicon-plus"></i> Add Location</a></li>
            <li><a href="#menu-location-update"><i class="glyphicon glyphicon-pencil"></i> Update Location</a></li>
            <li class="divider"></li>
            <li><a href="#menu-location-remove"><i class="glyphicon glyphicon-remove"></i> Remove Location</a></li>
        </ul>
    </div>
</div>

<div class="modal fade" id="modal-location-addparent" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Location</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="adminlocationadd" id="form-location-addparent" data-toggle="validator" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="form-location-addparent-location" name="name" placeholder="Name" data-error="This field is required."
                            required/>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group hidden">
                        <label for="parentid">Ancestor</label>
                        <select class="form-control read-only" id="form-location-addparent-ancestor" name="parentid" onmousedown="(function(e){ e.preventDefault(); })(event, this)"
                            placeholder="Ancestor" value="1" readonly required>
                            <option value="1"></option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group hidden">
                        <label for="form-location-addparent-locationtype">Location Type</label>
                        <select class="form-control read-only" id="form-location-addparent-locationtype" name="locationtypeid" onmousedown="(function(e){ e.preventDefault(); })(event, this)"
                            placeholder="Location Type" value="2" readonly required>
                            <option value="2">Country</option>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-location-add" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Descendant Location</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="adminlocationadd" id="form-location-add" data-toggle="validator" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="form-location-add-location">Location</label>
                        <input type="text" class="form-control" id="form-location-add-location" name="name" placeholder="Location" data-error="This field is required."
                            required/>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="form-location-add-ancestor">Ancestor</label>
                        <select class="form-control read-only" id="form-location-add-ancestor" name="parentid" onmousedown="(function(e){ e.preventDefault(); })(event, this)"
                            placeholder="Ancestor" readonly required></select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="form-location-add-locationtype">Location Type</label>
                        <select class="form-control read-only" id="form-location-add-locationtype" name="locationtypeid" onmousedown="(function(e){ e.preventDefault(); })(event, this)"
                            placeholder="Location Type" readonly required>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-location-update" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Location</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="adminlocationupdate" id="form-location-update" data-toggle="validator" role="form">
                    {!! csrf_field() !!}
                    <input type="hidden" class="form-control" id="form-location-update-locationid" name="locationid" required/>
                    <div class="form-group">
                        <label for="form-location-update-location">Name</label>
                        <input type="text" class="form-control" id="form-location-update-location" name="name" placeholder="Location" data-error="This field is required."
                            required/>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-location-remove" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Remove Location</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="adminlocationremove" id="form-location-remove" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="form-location-remove-locationid" name="locationid" required/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('scripts-content')
<script src="{{ asset('vendor/jqtree/tree.jquery.js') }}"></script>
<script src="{{ asset('vendor/jqtree/jqTreeContextMenu.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-validator/dist/validator.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('vendor/jqtree/jqtree.style.css') }}">

<script>
    $(function () {
        let $tree = $('#location-tree'),
            locations = `<?php echo json_encode($locations); ?>`,
            locationTypes = `<?php echo json_encode($locationTypes); ?>`,
            menuAPI = null;

        if(locations && locationTypes) {
            locations = JSON.parse(locations);
            locationTypes = JSON.parse(locationTypes);

            $tree.tree({
                autoOpen: true,
                data: locations,
                useContextMenu: true,
            });

            menuAPI = $tree.jqTreeContextMenu($('#tree-menu'), {
                "menu-location-add": function (node) {
                    let $elInpLocation = $('#form-location-add-location'),
                        $elSelectAncestor = $('#form-location-add-ancestor'),
                        $elSelectLocationType = $('#form-location-add-locationtype'),
                        hierarchyName = getHierarchy_name({ node: node, childName: undefined }),
                        locationType = null;

                    $elSelectAncestor.empty();
                    $elSelectAncestor.append(`<option id="${node.id}" value="${node.id}">${hierarchyName}</option>`);

                    locationType = locationTypes.find(_locationType => {
                        return _locationType.parentLocationTypeID == node.locationTypeID;
                    });

                    if(locationType) {
                        $elSelectLocationType.empty();
                        $elSelectLocationType.append(`<option id="${locationType.id}" value="${locationType.id}">${locationType.name}</option>`);
                    }
                    
                    $('#modal-location-add').modal('show');

                    setTimeout(function() { $elInpLocation.focus() }, 500);
                },
                "menu-location-update": function (node) {
                    let $elInpLocation = $('#form-location-update-location'),
                        $elInpLocationID = $('#form-location-update-locationid');

                    $elInpLocationID.val(node.id);
                    $elInpLocation.val(node.name);
                    
                    $('#modal-location-update').modal('show');

                    setTimeout(function() { $elInpLocation.focus() }, 500);
                },
                "menu-location-remove": function (node) {
                    let $elInpLocationID = $('#form-location-remove-locationid'),
                        $elFormLocationRemove = $('#form-location-remove');

                    $elInpLocationID.val(node.id);
                    $elFormLocationRemove.submit();
                }
            });

            $tree.bind('tree.contextmenu',
                function (event) {
                    let node = event.node,
                        disabledMenuItems = [];

                    menuAPI.enable();
                    if(node.locationTypeID == 4) {
                        disabledMenuItems.push('menu-location-add');
                    }

                    menuAPI.disable(disabledMenuItems);
                }
            );
        }

        $('#form-location-add').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented())
                return true;
        });
    });

    function getHierarchy_name(params) {
        let node = params.node,
            nodeName = node.name,
            childName = params.childName;
            
        if(node.ID_mapping == undefined) {
            if(childName) {
                childName = `${nodeName} > ${childName}`;
            } else {
                childName = `${nodeName}`;
            }

            childName = getHierarchy_name({
                node: node.parent,
                childName: childName
            });
        }

        return childName;
    }

</script>



@endpush