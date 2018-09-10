<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;
// use Symfony\Component\HttpFoundation\Request;

class Settings extends Controller
{

    public function settingsAddress(Request $request)
    {
        $locations = DB::table('location as l1')
            ->leftjoin('location as l2', 'l2.parentLocationID', '=', 'l1.locationID')
            ->leftjoin('location as l3', 'l3.parentLocationID', '=', 'l2.locationID')
            ->select('l1.name AS lev1', 'l1.locationID as lev1ID', 'l1.locationTypeID as lev1TypeID',
                'l2.name as lev2', 'l2.locationID as lev2ID', 'l2.locationTypeID as lev2TypeID',
                'l3.name as lev3', 'l3.locationID as lev3ID', 'l3.locationTypeID as lev3TypeID')
            ->where('l1.locationTypeID', '=', '2')
            ->orderBy('l1.name')
            ->orderBy('l2.name')
            ->orderBy('l3.name')
            ->get();

        // print_r($locations);
        return view('admin.settingsAddress')->with(["locations" => $locations]);
    }

    public function settingsAddressNew(Request $request)
    {
        $locationTypes = DB::table('locationType')
            ->select('*')
            ->where('isDeleted', '=', '0')
            ->where('locationTypeID', '<>', '1')
            ->get();

        // print_r($locationTypes);
        return view('admin.settingsAddressNew')->with(['locationTypes' => $locationTypes]);
    }

    public function settingsAddressNewProceed(Request $request)
    {
        $name = $request->input('name');
        $type = $request->input('type');
        $parentLocation = $request->input('parentLocation');
        $itemsubmitanother = $request->input('itemsubmitanother');

        if (isset($name) && isset($type) && isset($parentLocation)) {
            $data = array(
                'parentLocationID' => $parentLocation, 'locationTypeID' => $type, 'name' => $name
            );
            $newID = DB::table('location')->insertGetId($data);

            if (isset($newID)) {
                if (isset($itemsubmitanother)) {
                    return redirect('/settingsAddressNew/?submitanother=1')->with(['message' => 'Successfully added location']);
                } else {
                    return redirect('/settingsAddress')->with(['message' => 'Successfully added location']);
                }
            } else {
                return view('admin.settingsAddressNew')->with(['locationTypes' => $locationTypes, 'message' => 'An error has occured']);
            }
        } else {
            return view('admin.settingsAddressNew')->with(['locationTypes' => $locationTypes, 'message' => 'An error has occured']);
        }
    }

    public function settingsAddressGetParentLocation(Request $request)
    {
        $locationTypeID = $request->locationTypeID;

        if (isset($locationTypeID)) {
            $locations = DB::table('location')
                ->select('*')
                ->where('isDeleted', '=', '0')
                ->where('locationTypeID', '=', $locationTypeID)
                ->get();

            // print_r($locations);
            return (['locations' => $locations]);
        }
        return ['locations' => null];
    }

}
