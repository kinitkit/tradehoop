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
        $locations = DB::table('location')
            ->leftJoin('locationtype', 'locationtype.locationtypeID', '=', 'location.locationtypeID')
            ->select('location.*', 'locationtype.name AS locationTypeName')
            ->where('location.isDeleted', '=', '0')
            ->orderBy('parentLocationID', 'asc')
            ->orderBy('location.name', 'asc')
            ->orderBy('locationID', 'asc')
            ->get();
        $locationTypes = DB::table('locationtype')->where('isDeleted', '=', '0')->get();
        $recursivedLocation = [];
        $dataLocationTypes = [];

        foreach ($locationTypes as $value) {
            $newLocType = (object)[
                'id' => $value->locationTypeID, 'name' => $value->name, 'parentLocationTypeID' => $value->parentLocationTypeID
            ];
            array_push($dataLocationTypes, $newLocType);
        }

        foreach ($locations as $value) {
            if ($value->parentLocationID == "1") {
                $newLoc = (object)[
                    'id' => $value->locationID, 'name' => $value->name, 'locationTypeID' => $value->locationTypeID,
                    'locationTypeName' => $value->locationTypeName, 'children' => []
                ];
                array_push($recursivedLocation, $newLoc);
            } else {
                $recursivedLocation = $this->recursiveFn($value, $recursivedLocation);
            }
        }

        return view('admin.settingsAddress')->with(['locations' => $recursivedLocation, 'locationTypes' => $dataLocationTypes]);
    }

    public function recursiveFn($item, $arr)
    {
        for ($x = 0; $x < count($arr); ++$x) {
            $tempRecursivedCat = $arr[$x];

            if ($tempRecursivedCat->id == $item->parentLocationID) {
                $newLoc = (object)[
                    'id' => $item->locationID, 'name' => $item->name, 'locationTypeID' => $item->locationTypeID,
                    'locationTypeName' => $item->locationTypeName, 'children' => []
                ];
                array_push($tempRecursivedCat->children, $newLoc);
            } else if (count($tempRecursivedCat->children) > 0) {
                $tempRecursivedCat->children = $this->recursiveFn($item, $tempRecursivedCat->children);
            }

            $arr[$x] = $tempRecursivedCat;
        }

        return $arr;
    }

    public function locationAdd(Request $request)
    {
        $name = $request->input('name');
        $parentID = $request->input('parentid');
        $locationTypeID = $request->input('locationtypeid');

        if (isset($name) && isset($parentID) && isset($locationTypeID)) {
            $data = array('name' => $name, 'parentLocationID' => $parentID, 'locationTypeID' => $locationTypeID);
            DB::table('location')->insert($data);
            return redirect("/settingsAddress")->with(['message' => "Location added successfully."]);
        } else {
            return redirect("/settingsAddress")->with(['message' => "An information is missing."]);
        }
    }

    public function locationUpdate(Request $request)
    {
        $locationid = $request->input('locationid');
        $name = $request->input('name');

        if (isset($locationid) && isset($name)) {
            DB::table('location')->where('locationID', $locationid)->update(['name' => $name]);

            return redirect("/settingsAddress")->with(['message' => "Location updated successfully"]);
        } else {
            return redirect("/settingsAddress")->with(['message' => "An information is missing."]);
        }
    }

    public function locationRemove(Request $request)
    {
        $locationID = $request->input('locationid');

        if (isset($locationID)) {
            $locations = DB::table('location')->where('parentLocationID', '=', $locationID)->where('isDeleted', '=', '0')->get();
            $warehouselocation = DB::table('warehouselocation')->where('locationID', '=', $locationID)->where('isDeleted', '=', '0')->get();
            $canBeRemoved = false;

            if ((count($locations) == 0 && count($warehouselocation) == 0) || (!isset($locations) && !isset($warehouselocation))) {
                $canBeRemoved = true;
            }

            if ($canBeRemoved) {
                DB::table('location')->where('locationID', '=', $locationID)->delete();

                return redirect("/settingsAddress")->with(['message' => "Location removed successfully."]);
            } else {
                return redirect("/settingsAddress")->with(['message' => "Location has still active descendants or is being used."]);
            }
        } else {
            return redirect("/settingsAddress")->with(['message' => "An information is missing."]);
        }
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
