<?php
//echo session('tradehoopusertype');

$item = "";
$inventory = "";
$supplier = "";
$ordermanagement = "";
$salesmanagement = "";
$cms = "";
$administration = "";
$settings = "";

//ITEM MANAGEMENT
if(session('tradehoopusertype') >= 0 && session('tradehoopusertype') <= 2){
    $item = '
        <a href="#itemManagement" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-unchecked"></span> Item Management</a>
        <div id="itemManagement" class="collapse">
            <a href="/adminitemcreate" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Create Item</a>
            <a href="/adminitemmanage" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Manage Item</a>
            <a href="/admincategory" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Category Management</a>
            <a href="/adminunit" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Unit Management</a>
        </div>
    ';
}

//INVENTORY
if(session('tradehoopusertype') >= 0 && session('tradehoopusertype') <= 2 || session('tradehoopusertype') == 7){
    $createwarehouse = "";
    if(session('tradehoopusertype') >= 0 && session('tradehoopusertype') <= 2){
        $createwarehouse = '<a href="/adminwarehousecreate" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Create Warehouse</a>';
    }
    $inventory = '
        <a href="#inventory" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-unchecked"></span> Inventory</a>
        <div id="inventory" class="collapse">
            <a href="/adminwarehouse" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Select Warehouse</a>
            '.$createwarehouse.'
        </div>
    ';
}

//SUPPLIER
if(session('tradehoopusertype') >= 0 && session('tradehoopusertype') <= 2){
    $supplier ='
        <a href="#supplier" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-unchecked"></span> Supplier Management</a>
        <div id="supplier" class="collapse">
            <a href="/adminsupplier" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Manage Supplier</a>
        </div>
    ';
}

//ORDER MANAGEMENT
$manageorders = ""; $receiving = ""; $packaging = ""; $delivering = "";
if(session('tradehoopusertype') == 0 || session('tradehoopusertype') == 1 || session('tradehoopusertype') == 3 || session('tradehoopusertype') == 8 || session('tradehoopusertype') == 9 || session('tradehoopusertype') == 10){
    if(session('tradehoopusertype') == 0 || session('tradehoopusertype') == 1 || session('tradehoopusertype') == 3 || session('tradehoopusertype') == 8){
        $manageorders = '<a href="/adminordermanagement" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Manage Orders</a>';
        $receiving = '<a href="/adminorderreceiving" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Receiving</a>';
    }
    if(session('tradehoopusertype') == 0 || session('tradehoopusertype') == 1 || session('tradehoopusertype') == 3 || session('tradehoopusertype') == 8 || session('tradehoopusertype') == 9)
        $packaging = '<a href="/adminorderpackaging" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Packaging</a>';
    if(session('tradehoopusertype') == 10)
        $delivering = '<a href="/adminorderdelivering" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Delivering</a>';
        $ordermanagement = '
            <a href="#order" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-unchecked"></span> Order Management</a>
            <div id="order" class="collapse">
                '.$manageorders.'   
                '.$receiving.'
                '.$packaging.'
                '.$delivering.'
            </div>
        ';
}

//SALES MANAGEMENT
if(session('tradehoopusertype') == 0 || session('tradehoopusertype') == 1 || session('tradehoopusertype') == 3){
    $salesmanagement = '
        <a href="#sales" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-unchecked"></span> Sales Management</a>
        <div id="sales" class="collapse">
            <a href="/adminsalesmanagement" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Sales Query</a>
            <a href="/adminsalesday" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Sales Today</a>
            <a href="/adminsalesmonth" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Sales This Month</a>
            <a href="/adminsalesyear" class="btn innerButton"><span class="glyphicon glyphicon-unchecked"></span> Sales This Year</a>
        </div>
    ';
}

//ORDERS (SUPPLIER)
if(session('tradehoopusertype') == 5){
    $supplier = '
        <a href="#orderssupplier" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-unchecked"></span> Orders (Supply)</a>
        <div id="orderssupplier" class="collapse">
            <a href="/adminsupplierorder" class="btn innerButton"><span class="glyphicon glyphicon-flag"></span> Current Order</a>
            <a href="/adminsupplierorderhistory" class="btn innerButton"><span class="glyphicon glyphicon-align-justify"></span> Transaction History</a>
        </div>
    ';
}

//CMS
if(session('tradehoopusertype') == 0 || session('tradehoopusertype') == 1){
    $cms = '
        <a href="/admincms" class="btn button"><span class="glyphicon glyphicon-globe"></span> Content Management System</a>
    ';
}

if(session('tradehoopusertype') <= 1){
    $administration = '
        <a href="#administration" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-user"></span> Administration</a>
        <div id="administration" class="collapse">
            <a href="/adminlogs" class="btn innerButton"><span class="glyphicon glyphicon-pencil"></span> Logs</a>
            <a href="/adminusermanagement" class="btn innerButton"><span class="glyphicon glyphicon-user"></span> User Management</a>
            <a href="/adminuseradd" class="btn innerButton"><span class="glyphicon glyphicon-plus-sign"></span> Add User</a>
        </div>
    ';
}

//SETTINGS
if(session('tradehoopusertype') >= 0 && session('tradehoopusertype') <= 2){
    $settings = '
        <a href="#settings" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-wrench"></span> Settings</a>
        <div id="settings" class="collapse">
            <a href="/settingsAddress" class="btn innerButton"><span class="glyphicon glyphicon-wrench"></span> Settings</a>
        </div>
    ';
}


?>


<div class="user row">
    <span class="col-md-10">{{session('tradehoopfirstname')}} {{session('tradehooplastname')}} ({{session('tradehoopusername')}})</span>
    <div class="col-md-2" style="border-radius: 50%; background: url('http://placebear.com/150/250') center center no-repeat; background-size: cover; width: 30px; height: 30px;"></div>
</div>
<div>

    <a href="/admin" class="btn button"><span class="glyphicon glyphicon-home"></span> Home</a>

    <a href="#notification" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-flag"></span> Notifications</a>
    <div id="notification" class="collapse">
        <a href="/adminnotificationapproval" class="btn innerButton"><span class="glyphicon glyphicon-flag"></span> Approvals</a>
        <a href="/adminnotificationuserrequest" class="btn innerButton"><span class="glyphicon glyphicon-flag"></span> User Request</a>
        <a href="/adminnotificationgeneral" class="btn innerButton"><span class="glyphicon glyphicon-flag"></span> General Notification</a>
    </div>

    <?php echo $item; ?>
    
    <?php echo $inventory; ?>

    <?php echo $supplier; ?>

    <?php echo $ordermanagement; ?>

    <?php echo $salesmanagement; ?>

    <?php echo $cms; ?>

    <?php echo $administration; ?>

    <?php echo $settings; ?>

    

    <a href="#setting" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-wrench"></span> Personal Settings</a>
    <div id="setting" class="collapse">
        <a href="/adminpersonalinfo" class="btn innerButton"><span class="glyphicon glyphicon-pencil"></span> Personal Information</a>
        <a href="/adminpersonalcontactaddress" class="btn innerButton"><span class="glyphicon glyphicon-pencil"></span> Contact and Address</a>
        <a href="/adminpersonalchangepassword" class="btn innerButton"><span class="glyphicon glyphicon-pencil"></span> Change Password</a>
    </div>

    <a href="#message" class="btn button" data-toggle="collapse"><span class="glyphicon glyphicon-envelope"></span> Messaging</a>
    <div id="message" class="collapse">
        <a href="/adminmessageinbox" class="btn innerButton"><span class="glyphicon glyphicon-envelope"></span> Inbox</a>
        <a href="/adminmessagecreatenew" class="btn innerButton"><span class="glyphicon glyphicon-pencil"></span> Create New</a>
    </div>

    <?php echo $cms; ?>

    <a href="/adminlogout" class="btn button"><span class="glyphicon glyphicon-off"></span> Logout</a>
</div>
