@extends('layouts.adminLogged') 
@section('title', 'Category Management') 
@section('page', 'Category Management') 
@section('content')
<div class="space50"></div>

<div class="col-sm-8">
    <div class="mb-10">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-category-addparent">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Category
        </button>
    </div>
    <div id="category-tree">
    </div>
    <div class="dropdown">
        <ul id="tree-menu" class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="#menu-category-add"><i class="glyphicon glyphicon-plus"></i> Add Category</a></li>
            <li><a href="#menu-category-update"><i class="glyphicon glyphicon-pencil"></i> Update Category</a></li>
            <li class="divider"></li>
            <li><a href="#menu-category-remove"><i class="glyphicon glyphicon-remove"></i> Remove Category</a></li>
        </ul>
    </div>
</div>

<div class="modal fade" id="modal-category-addparent" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Category</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="admincategoryadd" id="form-category-addparent" data-toggle="validator" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="form-category-addparent-category" name="category" placeholder="Category" data-error="This field is required."
                            required/>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group hidden">
                        <label for="category">Ancestor</label>
                        <select class="form-control read-only" id="form-category-addparent-ancestor" name="parentid" onmousedown="(function(e){ e.preventDefault(); })(event, this)"
                            placeholder="Discipline" value="0" readonly required>
                            <option value="0"></option>
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

<div class="modal fade" id="modal-category-add" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Child Category</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="admincategoryadd" id="form-category-add" data-toggle="validator" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="form-category-add-category" name="category" placeholder="Category" data-error="This field is required."
                            required/>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="category">Ancestor</label>
                        <select class="form-control read-only" id="form-category-add-ancestor" name="parentid" onmousedown="(function(e){ e.preventDefault(); })(event, this)"
                            placeholder="Discipline" readonly required></select>
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

<div class="modal fade" id="modal-category-update" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Category</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="admincategoryupdate" id="form-category-update" data-toggle="validator" role="form">
                    {!! csrf_field() !!}
                    <input type="hidden" class="form-control" id="form-category-update-categoryid" name="categoryid" required/>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" id="form-category-update-category" name="category" placeholder="Category" data-error="This field is required."
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

<div class="modal fade" id="modal-category-remove" tabindex="-1" role="dialog" aria-labelledby="...">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Remove Category</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="admincategoryremove" id="form-category-remove" role="form">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="form-category-remove-categoryid" name="categoryid" required/>
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
        let $tree = $('#category-tree'),
            categories = `<?php echo json_encode($category); ?>`,
            menuAPI = $tree.jqTreeContextMenu($('#tree-menu'), {
                "menu-category-add": function (node) {
                    let $elInpCategory = $('#form-category-add-category'),
                        $elSelectAncestor = $('#form-category-add-ancestor'),
                        hierarchyName = getHierarchy_name({ node: node, childName: undefined });

                    $elSelectAncestor.empty();
                    $elSelectAncestor.append(`<option id="${node.id}" value="${node.id}">${hierarchyName}</option>`);

                    
                    $('#modal-category-add').modal('show');

                    setTimeout(function() { $elInpCategory.focus() }, 500);
                },
                "menu-category-update": function (node) {
                    let $elInpCategory = $('#form-category-update-category'),
                        $elInpCategoryID = $('#form-category-update-categoryid');

                    $elInpCategoryID.val(node.id);
                    $elInpCategory.val(node.name);
                    
                    $('#modal-category-update').modal('show');

                    setTimeout(function() { $elInpCategory.focus() }, 500);
                },
                "menu-category-remove": function (node) {
                    let $elInpCategoryID = $('#form-category-remove-categoryid'),
                        $elFormCategoryRemove = $('#form-category-remove');

                    $elInpCategoryID.val(node.id);
                    $elFormCategoryRemove.submit();
                }
            });

        if(categories) {
            categories = JSON.parse(categories);

            $tree.tree({
                autoOpen: true,
                data: categories,
                useContextMenu: true,
            });

            $tree.bind('tree.contextmenu',
                function (event) {
                    let node = event.node,
                        disabledMenuItems = [];
                }
            );
        }

        $('#form-category-add').validator().on('submit', function (e) {
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