<?php

use App\Http\Controllers\UserManagement;


/*|--------------------------------------------------------------------------
| GENERAL AND FRONT-END ROUTES
|--------------------------------------------------------------------------*/

Route::get('/', function () {
    return view('temporary');
});

Route::get('/index', function () {
    return view('temporary');
});

Route::get('/home', ['uses' => 'Customer@home']);

Route::get('/allcategories', function () {
    return view('customer.allcategories');
});

Route::get('/aboutus', function () {
    return view('customer.aboutus');
});

Route::get('/blog', function () {
    return view('customer.blog');
});

Route::get('/customercare', function () {
    return view('customer.customercare');
});

Route::get('/login', function () {
    return view('customer.login');
});

Route::get('/register', function () {
    return view('customer.register');
});

Route::get('/logout', ['uses' => 'LoginLogout@logout']);




/*|--------------------------------------------------------------------------
| ADMINISTRATION ROUTES
|--------------------------------------------------------------------------*/


//CHECKING OF BEING LOGGED IN
Route::get('/admin', ['uses' => 'LoginLogout@checkLogin']);
Route::post('/admin', ['uses' => 'LoginLogout@login']);


//LOGOUT
Route::get('/adminlogout', ['uses' => 'LoginLogout@adminLogout']);


//PERSONAL SETTINGS
//PERSONAL INFO
Route::get('/adminpersonalinfo', function () {
    return view('admin.personalinfo');
});
Route::post('/adminpersonalinfo', ['uses' => 'Administrator@updateInformation']);
//ADDRESS
Route::get('/adminpersonalcontactaddress', ['uses' => 'Administrator@getContactAddressInformation']);
Route::post('/adminpersonalcontactaddress', ['uses' => 'Administrator@updateContactAddressInformation']);
//PASSWORD
Route::get('/adminpersonalchangepassword', function () {
    return view('admin.personalpassword');
});
Route::post('/adminpersonalchangepassword', ['uses' => 'Administrator@changePassword']);


//ITEM MANAGEMENT
Route::get('/adminitemcreate', ['uses' => 'ItemManagement@createItem']);
Route::post('/adminitemcreate', ['uses' => 'ItemManagement@createItemProceed']);

Route::get('/adminitemmanage', ['uses' => 'ItemManagement@itemManage']);
Route::post('/adminitemmanage', ['uses' => 'ItemManagement@itemManageProceed']);

Route::get('/adminitemmanageitem', ['uses' => 'ItemManagement@adminItemmanageItem']);
Route::post('/adminitemmanageitem', ['uses' => 'ItemManagement@adminItemmanageItemProceed']);

//CATEGORY MANAGEMENT
Route::get('/admincategory', ['uses' => 'ItemManagement@category']);
Route::post('/admincategory', ['uses' => 'ItemManagement@categoryProceed']);

Route::post('/admincategoryadd', ['uses' => 'ItemManagement@categoryAdd']);
Route::post('/admincategoryremove', ['uses' => 'ItemManagement@categoryRemove']);
Route::post('/admincategoryupdate', ['uses' => 'ItemManagement@categoryUpdate']);

Route::get('/admincategorymanage', ['uses' => 'ItemManagement@categoryManage']);
Route::post('/admincategorymanage', ['uses' => 'ItemManagement@categoryManageProceed']);


//UNIT MANAGEMENT

Route::get('/adminunit', ['uses' => 'ItemManagement@unit']);
Route::post('/adminunit', ['uses' => 'ItemManagement@unitProceed']);

Route::get('/adminunitmanage', ['uses' => 'ItemManagement@unitManage']);
Route::post('/adminunitmanage', ['uses' => 'ItemManagement@unitManageProceed']);


//WAREHOUSE | INVENTORY

Route::get('/adminwarehouse', ['uses' => 'Inventory@warehouse']);

Route::get('/adminwarehousecreate', ['uses' => 'Inventory@warehouseCreate']);
Route::post('/adminwarehousecreate', ['uses' => 'Inventory@warehouseCreateProceed']);

Route::get('/adminwarehousemanage', ['uses' => 'Inventory@warehouseManage']);
Route::post('/adminwarehousemanage', ['uses' => 'Inventory@warehouseManageProceed']);

Route::get('/adminwarehousemanagegetlocationsearch', ['uses' => 'Inventory@warehouseManageGetlocationSearch']);
Route::post('/adminwarehousemanagegetlocationsearch', ['uses' => 'Inventory@warehouseManageGetlocationSearchAddLocation']);

Route::post('/warehousemanageremovelocation', ['uses' => 'Inventory@warehouseManageRemoveLocation']);

Route::get('/admininventory', ['uses' => 'Inventory@inventory']);
Route::post('/admininventory', ['uses' => 'Inventory@inventoryProceed']);

Route::get('/admininventoryitem', ['uses' => 'Inventory@inventoryItem']);

Route::get('/admininventoryitemprice', ['uses' => 'Inventory@inventoryItemPrice']);

Route::get('/admininventoryitempricemanage', ['uses' => 'Inventory@inventoryItemPriceManage']);
Route::post('/admininventoryitempricemanage', ['uses' => 'Inventory@inventoryItemPriceManagePost']);

Route::get('/admininventorynewitem', ['uses' => 'Inventory@inventoryNewItem']);
Route::post('/admininventorynewitemprocess', ['uses' => 'Inventory@inventoryNewItemProcess']);
Route::get('/admininventorysearchnewinventoryitem', ['uses' => 'Inventory@inventorySearchItem']);

Route::get('/admininventorymanageorder', ['uses' => 'Inventory@inventoryOrder']);
Route::get('/admininventorymanageorderdetails', ['uses' => 'Inventory@inventoryOrderDetails']);

Route::post('/admininventorymanageorderdetailsupdateqtyprovided', ['uses' => 'Inventory@inventoryOrderManageOrderUpdateQtyActual']);

//SUPPLIER
Route::get('/adminsupplier', ['uses' => 'Supplier@supplier']);
Route::post('/adminsupplier', ['uses' => 'Supplier@supplierProceed']);

Route::get('/adminsuppliermanage', ['uses' => 'Supplier@supplierManage']);
Route::post('/adminsuppliermanage', ['uses' => 'Supplier@supplierManageProceed']);

Route::get('/adminsupplierordermanage', ['uses' => 'Supplier@supplierOrderManage']);
Route::post('/adminsupplierordermanage', ['uses' => 'Supplier@supplierOrderManageProceed']);

Route::get('/adminsupplierordermanagedetails', ['uses' => 'Supplier@supplierOrderDetailsManage']);
Route::post('/adminsupplierordermanagedetails', ['uses' => 'Supplier@supplierOrderDetailsManageProceed']);

Route::get('/adminsupplierordermanagedetailssearch', ['uses' => 'Supplier@supplierOrderDetailsManageSearch']);
Route::post('/adminsupplierordermanagedetailssearch', ['uses' => 'Supplier@supplierOrderDetailsManageSearchProceed']);

Route::post('/adminsupplierordermanagedetailsdelete', ['uses' => 'Supplier@supplierOrderManageDetailsDelete']);

Route::post('/adminsupplierordermanagedetailsupdate', ['uses' => 'Supplier@supplierOrderManageDetailsUpdate']);

Route::post('/adminsupplierordermanagedetailsupdatestatus', ['uses' => 'Supplier@supplierOrderManageDetailsUpdateStatus']);

//SUPPLIER ORDER

Route::get('/adminsupplierorder', ['uses' => 'Supplier@supplierOrder']);
Route::post('/adminsupplierorder', ['uses' => 'Supplier@supplierOrderProceed']);

Route::get('/adminsupplierordermanageorder', ['uses' => 'Supplier@supplierOrderManageOrder']);
Route::post('/adminsupplierordermanageorderupdateqtyprovided', ['uses' => 'Supplier@supplierOrderManageOrderUpdateQtyProvided']);

Route::get('/adminsupplierorderhistory', ['uses' => 'Supplier@supplierOrderHistory']);
Route::post('/adminsupplierorderhistory', ['uses' => 'Supplier@supplierOrderHistoryProceed']);

Route::get('/adminsupplierorderhistoryvieworder', ['uses' => 'Supplier@supplierOrderHistoryProceed']);


// USER MANAGEMENT

Route::get('/adminusermanagement', ['uses' => 'UserManagement@userManagement']);
Route::post('/adminusermanagement', ['uses' => 'UserManagement@userManagementProceed']);

Route::get('/adminusermanagementmanageuser', ['uses' => 'UserManagement@userManagementManageUser']);
Route::post('/adminusermanagementmanageuser', ['uses' => 'UserManagement@userManagementManageUserProceed']);

Route::get('/adminuseradd', ['uses' => 'UserManagement@userAdd']);
Route::post('/adminuseradd', ['uses' => 'UserManagement@userAddProceed']);

Route::get('/searchsupplierforuser', ['uses' => 'UserManagement@searchSupplierForUser']);

Route::post('/adminusermanagementmanageuserUpdate', ['uses' => 'UserManagement@userManagementManageUserUpdate']);


// MESSAGING

Route::get('/adminmessageinbox', ['uses' => 'Messaging@messaging']);

Route::get('/adminmessagecreatenew', ['uses' => 'Messaging@messagingNew']);


// SETTINGS

Route::get('/settingsAddress', ['uses' =>'Settings@settingsAddress']);

Route::get('/settingsAddressNew', ['uses' =>'Settings@settingsAddressNew']);
Route::post('/settingsAddressNew', ['uses' =>'Settings@settingsAddressNewProceed']);

Route::get('/settingsAddressGetParentLocation', ['uses' =>'Settings@settingsAddressGetParentLocation']);