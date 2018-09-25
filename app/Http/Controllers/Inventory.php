<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

class Inventory extends Controller
{
    public function warehouse()
    {
        $warehouse = DB::table('warehouse')->orderBy('name', 'asc')->paginate(20);
        return view('admin.warehouse')->with('warehouse', $warehouse);
    }

    public function warehouseCreate()
    {
        return view('admin.warehousecreate');
    }

    public function warehouseCreateProceed(Request $request)
    {
        $name = $request->input('name');
        $location = $request->input('location');

        $warehouseExist = DB::table('warehouse')->Where('name', $name)->first();

        if ($warehouseExist) {
            return redirect('/adminwarehousecreate')->with(['message' => 'warehouse is already existing']);
        } else {
            $data = array('name' => $name, 'location' => $location);
            DB::table('warehouse')->insert($data);
            return redirect('/adminwarehousecreate')->with(['message' => 'warehouse successfully added']);
        }
    }

    public function warehouseManage(Request $request)
    {
        if (isset($request->id)) {
            $warehouse = DB::table('warehouse')
                ->Where('id', $request->id)
                ->first();

            // print_r($warehouse);
            // echo $warehouse->id;
            $warehouselocation = DB::table('warehouselocation')
                ->leftJoin('location as mainLocation', 'mainLocation.locationID', '=', 'warehouselocation.locationID')
                ->leftJoin('location as parentLocation', 'parentLocation.locationID', '=', 'mainLocation.parentLocationID')
                ->select(
                    'mainLocation.locationID as mainLocID',
                    'mainLocation.name as mainName',
                    'parentLocation.locationID as parentLocID',
                    'parentLocation.name as parentName',
                    'warehouselocation.warehouselocationID',
                    'warehouselocation.warehouseID'
                )
                ->where('warehouseID', $request->id)
                ->where('warehouselocation.isDeleted', '=', '0')
                ->orderBy('mainLocation.name')
                ->orderBy('parentLocation.name')
                ->get();

            if (isset($warehouse)) {
                return view('admin.warehousemanage')->with(['warehouse' => $warehouse, 'warehouselocation' => $warehouselocation]);
            } else {
                return redirect('/adminwarehouse');
            }
        } else {
            return redirect('/adminwarehouse');
        }
    }

    public function warehouseManageProceed(Request $request)
    {
        $name = $request->input('name');
        $location = $request->input('location');
        $status = $request->input('status');
        $id = $request->id;

        DB::table('warehouse')
            ->where(['id' => $id])
            ->update(['name' => $name, 'location' => $location, 'status' => $status]);

        return redirect("/adminwarehousemanage?id=" . $id);
    }

    public function warehouseManageGetlocationSearch(Request $request)
    {
        $search = $_GET['searchQuery'];

        $location = DB::table('location as l1')
            ->leftjoin('location as l2', 'l2.parentLocationID', '=', 'l1.locationID')
            ->select(
                'l1.name AS lev1',
                'l1.locationID as lev1ID',
                'l1.locationTypeID as lev1TypeID',
                'l2.name as lev2',
                'l2.locationID as lev2ID',
                'l2.locationTypeID as lev2TypeID'
            )
            ->whereRaw(DB::raw(
                "
                    (
                        `l1`.`name` LIKE '%" . $search . "%' AND l1.locationTypeID = 3 AND l1.locationTypeID IS NOT NULL
                    ) OR (
                        `l2`.`name` LIKE '%" . $search . "%' AND l2.locationTypeID IS NOT NULL
                    )
                "
            ))
            ->orderBy('l1.locationTypeID')
            ->orderBy('l1.name')
            ->orderBy('l2.name')
            ->get();

        return ($location);
    }

    public function warehouseManageGetlocationSearchAddLocation(Request $request)
    {
        // $locationID = $_POST['locationID'];
        // $warehouseID = $_POST['warehouseID'];
        $locationID = $request->input('locationid');
        $warehouseID = $request->input('warehouseid');
        $message = "";

        if (isset($locationID) && isset($warehouseID)) {
            $shouldInsert = DB::table('warehouselocation')
                ->select('warehouselocationID')
                ->where('warehouseID', '=', $warehouseID)
                ->where('locationID', '=', $locationID)
                ->first();

            // print_r($shouldInsert);

            if (!isset($shouldInsert)) {
                $data = array(
                    'warehouseID' => $warehouseID, 'locationID' => $locationID
                );

                $newID = DB::table('warehouselocation')->insertGetId($data);

                if (isset($newID)) {
                    // $message = 1;
                    $message = "Successfully added location to the warehouse";
                } else {
                    $message = "Oops! Something unexpected happened";
                    // $message = 0;
                }
            } else {
                $message = "Location already existed";
                // $message = 0;
            }
            // $message = 0;
            return redirect('/adminwarehousemanage?id=' . $warehouseID)->with(['message' => $message]);
        }

        // return ['response' => $message];
    }

    public function warehouseManageRemoveLocation(Request $request)
    {
        $warehouseID = $request->input('warehouseid');
        $warehouseLocationID = $request->input('warehouselocationid');
        $message = "";

        if (isset($warehouseLocationID)) {
            DB::table('warehouselocation')
                ->where('warehouselocationID', '=', $warehouseLocationID)
                ->delete();

            $message = "Location successfully removed.";
        }

        return redirect('/adminwarehousemanage?id=' . $warehouseID)->with(['message' => $message]);
    }

    public function inventory(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;

            $warehouse = DB::table('warehouse')
                ->where('id', '=', $id)
                ->first();

            // $inventory = DB::table('inventory')
            //     ->leftJoin('item', 'inventory.code', '=', 'item.code')
            //     ->select('inventory.*', 'item.name', 'item.description', 'item.unit', 'item.image')
            //     ->where('warehouseid', '=', $id)
            //     ->orderBy('inventory.id', 'desc')
            //     ->paginate(10);

            $inventory = DB::table('inventory as inv')
                ->leftJoin('item', 'inv.code', '=', 'item.code')
                ->select(
                    'inv.*',
                    'item.name',
                    'item.price',
                    'item.description',
                    'item.unit',
                    'item.image',
                    DB::raw('((SELECT IFNULL(SUM(qty), 0) FROM inventory WHERE warehouseid=' . $id . ' AND type IN(0,4) AND code = inv.code) - (SELECT IFNULL(SUM(qty), 0) FROM inventory WHERE inventory.warehouseid=' . $id . ' AND type IN(1,2,3) AND code = inv.code)) as totalQty')
                )
                ->where('warehouseid', '=', $id)
                ->groupBy('item.price', 'inv.code')
                ->orderBy('item.name', 'asc')
                ->paginate(10);

            return view('admin.inventory')->with(['warehouse' => $warehouse, 'inventory' => $inventory]);
        }
        return view('admin.inventory');
    }

    public function inventoryNewItem(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;

            $warehouse = DB::table('warehouse')
                ->where('id', '=', $id)
                ->first();

            $submitanother = null;
            if (isset($request->submitanother)) {
                $submitanother = 1;
            }

            if (isset($warehouse)) {
                if (isset($submitanother)) {
                    return view('admin.inventoryNewItem')->with(['warehouse' => $warehouse, 'submitanother' => 'checked']);
                } else {
                    return view('admin.inventoryNewItem')->with(['warehouse' => $warehouse]);
                }
            }
            return redirect('/adminwarehouse');
        }
        return redirect('/adminwarehouse');
    }

    public function inventoryNewItemProcess(Request $request)
    {
        $warehouseid = $request->input('warehouseid');

        if (isset($warehouseid)) {
            $itemcode = $request->input('itemcode');
            $itemquantity = $request->input('itemquantity');
            $itemprice = $request->input('itemprice');
            $itemtype = $request->input('itemtype');
            $itemremarks = trim($request->input('itemremarks'));
            $itemsubmitanother = $request->input('itemsubmitanother');

            $data = array(
                'warehouseid' => $warehouseid, 'code' => $itemcode, 'qty' => $itemquantity, 'price' => $itemprice,
                'type' => $itemtype, 'status' => '1', 'remarks' => $itemremarks
            );
            $newID = DB::table('inventory')->insertGetId($data);

            // print_r($itemsubmitanother);
            if (isset($newID)) {
                if (isset($itemsubmitanother)) {
                    return redirect('/admininventorynewitem?id=' . $warehouseid . '&submitanother=1')->with(['message' => 'Successfully added item to the list']);
                } else {
                    return redirect('/admininventoryitem?id=' . $warehouseid)->with(['message' => 'Successfully added item to the list']);
                }
            }
        }
    }

    public function inventorySearchItem(Request $request)
    {
        $search = $_GET['searchQuery'];

        $items = DB::table('item')
            ->where('code', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->where('status', '=', '1')
            ->get();

        return $items;
    }

    public function inventoryOrder(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;

            $warehouse = DB::table('warehouse')
                ->where(['id' => $id])
                ->first();

            if (count($warehouse) > 0) {
                $supplierOrders = DB::table('supplier')
                    ->leftjoin('supplierorder', 'supplier.id', '=', 'supplierorder.supplierid')
                    ->leftjoin('warehouse', 'supplierorder.warehouseid', '=', 'warehouse.id')
                    ->select('supplier.username', 'supplierorder.*', 'warehouse.*')
                    ->where('supplierorder.warehouseid', '=', $id)
                    ->where('supplierorder.status', '=', '2')
                    ->where('warehouse.status', '=', '1')
                    ->orderBy('supplierorder.datecreated', 'desc')
                    ->paginate(10);

                return view('admin.inventoryOrderManage')->with(['warehouse' => $warehouse, 'supplierorders' => $supplierOrders]);
            } else {
                return redirect('/admin');
            }
        }
    }

    public function inventoryOrderDetails(Request $request)
    {
        if (isset($request->supplierorderid)) {
            $supplierorderid = $request->supplierorderid;

            $supplierorder = DB::table('supplierorder')
                ->select(
                    'supplierorder.*',
                    DB::raw('(SELECT CURDATE()) as dateMin, (SELECT CURDATE() + INTERVAL 100 YEAR) as dateMax')
                )
                ->where('supplierorderid', $supplierorderid)->first();

            $supplierorderdetailsitemview = DB::table('supplierorderdetails')
                ->leftJoin('item', 'supplierorderdetails.code', '=', 'item.code')
                ->where('supplierorderid', $supplierorderid)
                ->get();

            if ($supplierorder) {
                return view('admin.inventoryOrderManageDetails')->with(['supplierorder' => $supplierorder, 'supplierorderdetailsitemview' => $supplierorderdetailsitemview]);

            } else {
                return redirect('/adminsupplier');
            }
        } else {
            return redirect('/adminsupplierorder');
        }
    }

    public function inventoryOrderManageOrderUpdateQtyActual(Request $request)
    {
        $orderdetailsid = $request->input('orderdetailsid');
        $supplierorderid = $request->input('supplierorderid');
        $qtyactual = $request->input('qtyactual');

        if (strlen($qtyactual) == 0) {
            $qtyactual = 0;
        }

        if (is_numeric($qtyactual)) {
            if ($qtyactual < 0) {
                $qtyactual = 0;
            }
        } else {
            $qtyactual = 0;
        }

        DB::table('supplierorderdetails')
            ->where(['orderdetailsid' => $orderdetailsid])
            ->update(['qtyactual' => $qtyactual]);

        return redirect('admininventorymanageorderdetails?supplierorderid=' . $supplierorderid)->with(['message' => 'Successfully updated the received quantity.']);
    }

    public function inventoryItem(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;

            $warehouse = DB::table('warehouse')
                ->where('id', '=', $id)
                ->first();

            $inventory = DB::table('inventory')
                ->leftJoin('item', 'inventory.code', '=', 'item.code')
                ->select('inventory.id', 'inventory.warehouseid', 'inventory.code', 'inventory.qty', 'inventory.type', 'inventory.status', 'inventory.remarks', 'item.*')
                ->where('warehouseid', '=', $id)
                ->orderBy('inventory.id', 'desc')
                ->paginate(10);

            return view('admin.inventoryViewItemHistory')->with(['warehouse' => $warehouse, 'inventory' => $inventory]);
        }
        return view('admin.inventory');
    }

    public function inventoryItemPrice(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;

            $warehouse = DB::table('warehouse')
                ->where('id', '=', $id)
                ->first();

            $priceList = DB::table('warehouseitemprice AS WIP')
                ->join(DB::raw(
                    '(SELECT
                        price,
                        MAX(DT_revision) AS DT_revision,
                        warehouseItemPriceID
                    FROM
                        warehouseitemprice
                    WHERE warehouseID = ' . $id . '
                    GROUP BY CODE)
                AS temp_WIP'
                ), function ($join) {
                    $join->on('WIP.DT_revision', '=', 'temp_WIP.DT_revision');
                })
                ->rightJoin('item', 'item.code', '=', 'WIP.code')
                ->select(
                    'WIP.*',
                    'item.code as itemCode',
                    'item.name',
                    'item.description',
                    'item.unit'
                )
                ->where('item.status', '=', '1')
                ->orderBy('item.name', 'ASC')
                ->paginate(10);

            return view('admin.inventoryItemPrice')->with(['warehouse' => $warehouse, 'priceList' => $priceList]);
        }
        return view('admin.inventory');
    }

    public function inventoryItemPriceManage(Request $request)
    {
        if (isset($request->id) && isset($request->code)) {
            $id = $request->id;
            $code = $request->code;

            $warehouse = DB::table('warehouse')
                ->where('id', '=', $id)
                ->first();

            $priceList = DB::table('warehouseitemprice AS WIP')
                ->select('WIP.code', 'WIP.price', 'WIP.DT_revision', 'WIP.username')
                ->where('WIP.code', '=', $code)
                ->where('WIP.warehouseID', '=', $id)
                ->orderBy('WIP.DT_revision', 'DESC')
                ->paginate(10);

            return view('admin.inventoryItemPriceManage')->with(['warehouse' => $warehouse, 'itemcode' => $code, 'priceList' => $priceList]);
        }
        return view('admin.inventory');
    }

    public function inventoryItemPriceManagePost(Request $request)
    {
        $amount = $request->input('amount');
        $warehouseID = $request->input('warehouseid');
        $code = $request->input('itemcode');
        $username = session('tradehoopusername');

        if (isset($warehouseID) && isset($code) && isset($amount)) {
            $amount = str_replace(",", "", $amount);
            $data = array('price' => $amount, 'warehouseID' => $warehouseID, 'code' => $code, 'username' => $username);
            DB::table('warehouseitemprice')->insert($data);

            return redirect('/admininventoryitempricemanage?id=' . $warehouseID . '&code=' . $code)->with(['message' => 'Item\'s price was successfully set']);
        }
        return view('admin.inventory')->with(['message' => 'Invalid Request!']);
    }
}