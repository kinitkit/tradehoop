<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

class Supplier extends Controller
{
    public function supplier($search = "")
    {
        $suppliers = "";
        if ($search == "") {
            $suppliers = DB::table('supplier')->orderBy('name', 'asc')->paginate(20);
        } else {
            $suppliers = DB::table('supplier')->where('name', 'LIKE', '%' . $search . '%')->orWhere('id', 'LIKE', $search)->orderBy('name', 'asc')->paginate(20);
        }
        return view('admin.supplier')->with(['suppliers' => $suppliers]);
    }



    public function supplierProceed(Request $request)
    {
        if ($request->input('create') != "") {
            $name = $request->input('name');
            $address = $request->input('address');
            $description = $request->input('description');

            $supplierExist = DB::table('supplier')->Where('name', $name)->first();

            if ($supplierExist) {
                return redirect('/adminsupplier')->with(['message' => 'Supplier is already existing, you might want to search and see it.']);
            } else {
                $data = array('name' => $name, 'address' => $address, 'description' => $description);
                DB::table('supplier')->insert($data);
                return redirect('/adminsupplier')->with(['message' => 'Supplier is added successfully']);
            }
        }

        if ($request->input('search') != "") {
            $search = $request->input('search');
            return $this->supplier($search);
        }
    }

    public function supplierManage(Request $request)
    {
        if (isset($request->supplierid)) {
            $id = $request->supplierid;

            $supplier = DB::table('supplier')->Where('id', $id)->first();

            if ($supplier) {
                return view('admin.supplierManage')->with(['supplier' => $supplier]);
            } else {
                return redirect('/adminsupplier');
            }
        } else {
            return redirect('/adminsupplier');
        }
    }

    public function supplierManageProceed(Request $request)
    {
        $name = $request->input('name');
        $address = $request->input('address');
        $description = $request->input('description');

        DB::table('supplier')
            ->where(['id' => $request->supplierid])
            ->update(['name' => $name, 'address' => $address, 'description' => $description]);

        return redirect('/adminsuppliermanage?supplierid=' . $request->supplierid)->with(['message' => 'Successfully updated']);
    }


    public function supplierOrderManage(Request $request)
    {
        if (isset($request->supplierid)) {
            $supplier = DB::table('supplier')->where('id', $request->supplierid)->first();
            $warehouse = DB::table('warehouse')->where('status', '1')->orderBy('name', 'asc')->get();
            $supplierorder = DB::table('supplierorder')->orderBy('datecreated', 'desc')->paginate(20);

            if ($supplier) {
                return view('admin.supplierOrderManage')->with(['supplier' => $supplier, 'warehouse' => $warehouse, 'supplierorder' => $supplierorder]);
            } else {
                return redirect('/adminsupplier');
            }
        } else {
            return redirect('/adminsupplier');
        }
    }

    public function supplierOrderManageProceed(Request $request)
    {
        $supplierid = $request->input('supplierid');
        $warehouseid = $request->input('warehouseid');
        $description = $request->input('description');

        $data = array('supplierid' => $supplierid, 'warehouseid' => $warehouseid, 'description' => $description, 'status' => '0');
        DB::table('supplierorder')->insert($data);

        return redirect('/adminsupplierordermanage?supplierid=' . $supplierid)->with(['message' => 'Order to supplier has been placed. Select now the order below and manage items on it.']);
    }


    public function supplierOrderDetailsManage(Request $request)
    {
        if (isset($request->supplierorderid)) {
            $supplierorderid = $request->supplierorderid;

            $supplierorder = DB::table('supplierorder')->where('supplierorderid', $supplierorderid)->first();

            $supplierorderdetailsitemview = DB::table('supplierorderdetails')
                ->leftJoin('item', 'supplierorderdetails.code', '=', 'item.code')
                ->where('supplierorderid', $supplierorderid)->get();

            if ($supplierorder) {
                return view('admin.supplierOrderManageDetails')->with(['supplierorder' => $supplierorder, 'supplierorderdetailsitemview' => $supplierorderdetailsitemview]);

            } else {
                return redirect('/adminsupplier');
            }
        } else {
            return redirect('/adminsupplier');
        }
    }

    public function supplierOrderDetailsManageSearch(Request $request)
    {
        if (isset($request->search) && $request->search != "") {
            $item = DB::table('item')->orWhere('code', $request->search)->orWhere('name', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'asc')->paginate(20);

            return view('admin.supplierOrderManageDetailsSearch')->with(['item' => $item, 'supplierorderid' => $request->input('supplierorderid')]);
        } else {
            return redirect('/adminsupplierordermanagedetails?supplierorderid=' . $request->input('supplierorderid'))->with(['message' => 'Do not harm our website']);
        }
    }

    public function supplierOrderDetailsManageSearchProceed(Request $request)
    {
        $supplierorderid = $request->input('supplierorderid');
        $qty = $request->input('qty');
        $code = $request->input('code');

        $data = array('supplierorderid' => $supplierorderid, 'qty' => $qty, 'code' => $code);
        DB::table('supplierorderdetails')->insert($data);

        return redirect('adminsupplierordermanagedetails?supplierorderid=' . $supplierorderid)->with(['message' => 'Item successfully added in order']);
    }

    public function supplierOrderManageDetailsDelete(Request $request)
    {
        $orderdetailsid = $request->input('orderdetailsid');
        $supplierorderid = $request->input('supplierorderid');

        DB::table('supplierorderdetails')->where(['orderdetailsid' => $orderdetailsid])->delete();
        return redirect('adminsupplierordermanagedetails?supplierorderid=' . $supplierorderid)->with(['message' => 'Item removed successfully.']);
    }

    public function supplierOrderManageDetailsUpdate(Request $request)
    {
        $orderdetailsid = $request->input('orderdetailsid');
        $supplierorderid = $request->input('supplierorderid');
        $qty = $request->input('qty');

        DB::table('supplierorderdetails')
            ->where(['orderdetailsid' => $orderdetailsid])
            ->update(['qty' => $qty]);

        return redirect('adminsupplierordermanagedetails?supplierorderid=' . $supplierorderid)->with(['message' => 'Successfully updated.']);
    }

    public function supplierOrderManageDetailsUpdateStatus(Request $request)
    {
        $supplierorderid = $request->supplierorderid;
        $statustype = $request->input('inpstatustype');
        $currenturl = $request->input('inpCurrentUrl');
        $datedelivery = $request->input('datedelivery');
        $message = "";
        $shouldUpdate = true;

        if (isset($supplierorderid) && isset($statustype)) {
            if ($statustype == 2 && !isset($datedelivery)) {
                $shouldUpdate = false;
            }

            if ($shouldUpdate) {
                $updateCount = DB::table('supplierorder')
                    ->where(['supplierorderid' => $supplierorderid])
                    ->update([
                        'status' => $statustype
                    ]);
            }

            switch ($statustype) {
                case 0:
                    break;
                case 1:
                    $message = $shouldUpdate ? "Order successfully Finalized" : "An error has occured. Please try again";
                    return redirect('adminsupplierordermanagedetails?supplierorderid=' . $supplierorderid)->with(['message' => $message]);
                    break;
                case 2:
                    $message = "An error has occured. Please try again";
                    if ($shouldUpdate) {
                        DB::table('supplierorder')
                            ->where(['supplierorderid' => $supplierorderid])
                            ->update([
                                'datedelivery' => $datedelivery
                            ]);
                        $message = "Order is marked as On Delivery";
                    }
                    return redirect('adminsupplierordermanageorder?supplierorderid=' . $supplierorderid)->with(['message' => $message]);
                    break;
                case 3:
                    $supplierorderdetails = DB::table('supplierorderdetails')
                        ->leftjoin('supplierorder', 'supplierorderdetails.supplierorderid', '=', 'supplierorder.supplierorderid')
                        ->leftjoin('item', 'supplierorderdetails.code', '=', 'item.code')
                        ->select('supplierorderdetails.*', 'supplierorder.warehouseid', 'item.price')
                        ->where('supplierorderdetails.supplierorderid', '=', $supplierorderid)
                        ->where('supplierorderdetails.qtyactual', '>', '0')
                        ->get();

                    // print_r($supplierorderdetails);
                    $newIdCounter = 0;
                    foreach ($supplierorderdetails as $supplierorderdetail) {
                        $data = array(
                            'warehouseid' => $supplierorderdetail->warehouseid,
                            'code' => $supplierorderdetail->code,
                            'qty' => $supplierorderdetail->qtyactual,
                            'price' => $supplierorderdetail->price,
                            'type' => '0',
                            'status' => '1',
                            'remarks' => 'Received from supplierorder id ' . $supplierorderdetail->supplierorderid
                        );
                        $newID = DB::table('inventory')->insertGetId($data);

                        if (isset($newID)) {
                            ++$newIdCounter;
                        }
                    }
                    $message = "Order is marked as Delivered";
                    return redirect('admininventorymanageorderdetails?supplierorderid=' . $supplierorderid)->with(['message' => $message]);
                    break;
                case 4:
                    $message = "Order successfully cancelled";
                    echo $currenturl;
                    return redirect($currenturl)->with(['message' => $message]);
                    break;
            }
        }
    }

    public function supplierOrder()
    {
        $username = session('tradehoopusername');

        $supplier = DB::table('supplier')
            ->where(['username' => $username])
            ->first();

        if (count($supplier) > 0) {

            $supplierOrders = DB::table('supplier')
                ->leftjoin('supplierorder', 'supplier.id', '=', 'supplierorder.supplierid')
                ->leftjoin('warehouse', 'supplierorder.warehouseid', '=', 'warehouse.id')
                ->select('supplier.username', 'supplierorder.*', 'warehouse.*')
                // ->where('supplier.username', '=', 'marco')
                ->where('supplier.username', '=', $username)
                ->where('supplierorder.status', '=', '1')
                ->where('warehouse.status', '=', '1')
                ->whereNotNull('supplierorder.supplierorderid')
                ->orderBy('supplierorder.datecreated', 'desc')
                ->get();

            // echo count($supplierDetails);
            // print_r($supplier);
            // print_r($supplierorders);
            return view('admin.supplierOrder')->with(['supplier' => $supplier, 'supplierorders' => $supplierOrders]);
        } else {
            return redirect('/admin');
        }
    }

    public function supplierOrderProceed(Request $request)
    {

    }

    public function supplierOrderManageOrder(Request $request)
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
                ->where('supplierorderid', $supplierorderid)->get();

            // print_r($supplierorder);
            if ($supplierorder) {
                return view('admin.supplierOrderManageOrder')->with(['supplierorder' => $supplierorder, 'supplierorderdetailsitemview' => $supplierorderdetailsitemview]);

            } else {
                return redirect('/adminsupplier');
            }
        } else {
            return redirect('/adminsupplierorder');
        }
    }

    public function supplierOrderManageOrderUpdateQtyProvided(Request $request)
    {
        $orderdetailsid = $request->input('orderdetailsid');
        $supplierorderid = $request->input('supplierorderid');
        $qtyprovided = $request->input('qtyprovided');

        if (strlen($qtyprovided) == 0) {
            $qtyprovided = 0;
        }

        if (is_numeric($qtyprovided)) {
            if ($qtyprovided < 0) {
                $qtyprovided = 0;
            }
        } else {
            $qtyprovided = 0;
        }

        DB::table('supplierorderdetails')
            ->where(['orderdetailsid' => $orderdetailsid])
            ->update(['qtyprovided' => $qtyprovided]);

        return redirect('adminsupplierordermanageorder?supplierorderid=' . $supplierorderid)->with(['message' => 'Successfully updated.']);
    }

    public function supplierOrderHistory(Request $request)
    {
        $username = session('tradehoopusername');
        $status = $request->status;

        if (isset($status)) {
            $status = $status > 5 ? 'none' : $status;
            $status = $status == 0 ? null : $status;
        }

        $supplier = DB::table('supplier')
            ->where(['username' => $username])
            ->first();

        if (count($supplier) > 0) {

            $supplierOrders = DB::table('supplier')
                ->leftjoin('supplierorder', 'supplier.id', '=', 'supplierorder.supplierid')
                ->leftjoin('warehouse', 'supplierorder.warehouseid', '=', 'warehouse.id')
                ->select('supplier.username', 'supplierorder.*', 'supplierorder.status AS supplierorderstatus', 'warehouse.*')
                // ->where('supplier.username', '=', 'marco')
                ->where('supplier.username', '=', $username)
                ->where('supplierorder.status', isset($status) ? '=' : '>', isset($status) ? $status : '0')
                ->where('warehouse.status', '=', '1')
                ->whereNotNull('supplierorder.supplierorderid')
                ->orderBy('supplierorder.datecreated', 'desc')
                ->get();

            // echo count($supplierDetails);
            // print_r($supplier);
            // print_r($supplierOrders);
            return view('admin.supplierOrderHistory')->with(['supplier' => $supplier, 'supplierorders' => $supplierOrders]);
        } else {
            return redirect('/admin');
        }
    }

    public function supplierOrderHistoryProceed(Request $request)
    {
        if (isset($request->supplierorderid)) {
            $supplierorderid = $request->supplierorderid;

            $supplierorder = DB::table('supplierorder')->where('supplierorderid', $supplierorderid)->first();

            $supplierorderdetailsitemview = DB::table('supplierorderdetails')
                ->leftJoin('item', 'supplierorderdetails.code', '=', 'item.code')
                ->where('supplierorderid', $supplierorderid)->get();

            if ($supplierorder) {
                return view('admin.supplierOrderHistoryViewOrder')->with(['supplierorder' => $supplierorder, 'supplierorderdetailsitemview' => $supplierorderdetailsitemview]);
            } else {
                return redirect('/adminsupplierorderhistory');
            }
        } else {
            return redirect('/adminsupplierorderhistory');
        }
    }

}


