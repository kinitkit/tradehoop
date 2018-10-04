<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

class ItemManagement extends Controller
{

/*|--------------------------------------------------------------------------
| ITEM MANANGEMENT
|--------------------------------------------------------------------------*/

    public function itemManage($message = "", $search = "")
    {
        $item;
        if ($search == "") {
            $item = DB::table('item')->paginate(10);
        } else {
            $item = DB::table('item')->where('code', 'LIKE', $search)->orWhere('name', 'LIKE', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%')->paginate(10);
        }
        return view('admin.itemmanage', ['message' => $message])->with('item', $item);
    }

    public function itemManageProceed(Request $request)
    {
        $search = $request->input('search');
        return $this->itemManage("", $search);
    }

    public function createItem($message = "")
    {
        $unit = DB::table('itemunit')->get();
        return view('admin.itemcreate', ['message' => $message])->with('unit', $unit);
    }


    public function createItemProceed(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalFilename = $file->getClientOriginalName();
            $testFileExistUrl = asset('items') . '/' . $originalFilename;

            $filename = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);

            $headers = get_headers($testFileExistUrl);
            $exist = stripos($headers[0], "200 OK") ? true : false;

            $newFileNameWithExtension = "";
            if ($exist) {
                //echo "item is existing . <br> " . $filename . "<br>" . $extension . "<br>";
                $newFileNameWithExtension = $filename . "copy." . $extension;
                $file->move('items', $newFileNameWithExtension);
            } else {
                $newFileNameWithExtension = $originalFilename;
                $file->move('items', $originalFilename);
            }


            $code = $request->input('code');
            $name = $request->input('name');
            $description = $request->input('description');
            $price = $request->input('price');
            $unit = $request->input('unit');

            $item = DB::table('item')->where('code', $code)->first();

            if (!empty($item->code)) {
                return redirect('/adminitemcreate')->with(['message' => "Please do not add an existing item. Item code duplicates."]);
            } else {
                $data = array('code' => $code, 'name' => $name, 'description' => $description, 'price' => $price, 'unit' => $unit, 'image' => $newFileNameWithExtension);
                DB::table('item')->insert($data);
                return redirect('/adminitemcreate')->with(['message' => "Item has been added successfully."]);
            }
        } else {
            return redirect('/adminitemcreate')->with(['message' => "Please include an image. It is required."]);
        }
    }

    public function adminItemmanageItem(Request $request, $message = "")
    {
        if (isset($request->itemcode)) {
            $item = DB::table('item', ['message' => $message])->where('code', $request->itemcode)->first();
            $unit = DB::table('itemunit')->get();
            if (isset($item)) {
                return view('admin.itemmanageitem')->with(['item' => $item, 'unit' => $unit]);
            } else {
                return redirect("/adminitemmanage");
            }
        } else {
            return redirect("/adminitemmanage");
        }
    }

    public function adminItemManageItemProceed(Request $request)
    {
        if (isset($request->update)) {
            DB::table('item')
                ->where(['code' => $request->code])
                ->update(['name' => $request->name, 'description' => $request->description, 'price' => $request->price]);

            return redirect("/adminitemmanageitem?itemcode=" . $request->code)->with(['message' => 'Item successfully updated']);
        }
    }

/*---------------------------------------------------------------------------
| CATEGORY
|--------------------------------------------------------------------------*/

    public function category()
    {
        $category = DB::table('itemcategory')->where('isDeleted', '=', '0')->orderBy('parentCategoryID', 'asc')->orderBy('category', 'asc')->orderBy('id', 'asc')->get();
        $recursivedCategory = [];

        foreach ($category as $value) {
            if ($value->parentCategoryID == "0") {
                $newCat = (object)['id' => $value->id, 'name' => $value->category, 'children' => []];
                array_push($recursivedCategory, $newCat);
            } else {
                $recursivedCategory = $this->recursiveFn($value, $recursivedCategory);
            }
        }

        return view('admin.category')->with(['category' => $recursivedCategory]);
    }

    public function recursiveFn($item, $arr)
    {
        for ($x = 0; $x < count($arr); ++$x) {
            $tempRecursivedCat = $arr[$x];

            if ($tempRecursivedCat->id == $item->parentCategoryID) {
                $newCat = (object)['id' => $item->id, 'name' => $item->category, 'children' => []];
                array_push($tempRecursivedCat->children, $newCat);
            } else if (count($tempRecursivedCat->children) > 0) {
                $tempRecursivedCat->children = $this->recursiveFn($item, $tempRecursivedCat->children);
            }

            $arr[$x] = $tempRecursivedCat;
        }

        return $arr;
    }

    public function categoryAdd(Request $request)
    {
        $category = $request->input('category');
        $parentID = $request->input('parentid');
        
        if (isset($category) && isset($parentID)) {
            $data = array('category' => $category, 'parentCategoryID' => $parentID);
            DB::table('itemcategory')->insert($data);
            return redirect("/admincategory")->with(['message' => "Category added successfully."]);
        } else {
            return redirect("/admincategory")->with(['message' => "An information is missing."]);
        }
    }

    public function categoryUpdate(Request $request)
    {
        $categoryID = $request->input('categoryid');
        $category = $request->input('category');

        if (isset($categoryID) && isset($category)) {
            DB::table('itemcategory')->where('id', $categoryID)->update(['category' => $category]);

            return redirect("/admincategory")->with(['message' => "Category updated successfully"]);
        } else {
            return redirect("/admincategory")->with(['message' => "An information is missing."]);
        }
    }

    public function categoryRemove(Request $request)
    {
        $categoryID = $request->input('categoryid');

        if (isset($categoryID)) {
            $categories = DB::table('itemcategory')->where('parentCategoryID', '=', $categoryID)->where('isDeleted', '=', '0')->get();
            $categoriesinclusion = DB::table('itemcategoryinclusion')->where('categoryid', '=', $categoryID)->get();
            $canBeRemoved = false;

            if ((count($categories) == 0 && count($categoriesinclusion) == 0) || (!isset($categories) && !isset($categoriesinclusion))) {
                $canBeRemoved = true;
            }

            if ($canBeRemoved) {
                DB::table('itemcategory')->where('id', '=', $categoryID)->delete();

                return redirect("/admincategory")->with(['message' => "Category removed successfully."]);
            } else {
                return redirect("/admincategory")->with(['message' => "Category has still active descendants or is being used."]);
            }
        } else {
            return redirect("/admincategory")->with(['message' => "An information is missing."]);
        }
    }

    public function categoryProceed(Request $request)
    {
        $category = $request->input('category');
        $data = array('category' => $category);

        $categoryExist = DB::table('itemcategory')->where('category', $category)->first();
        if (!empty($categoryExist)) {
            return redirect("/admincategory")->with(['message' => "Do not enter an existing category."]);
        } else {
            DB::table('itemcategory')->insert($data);
            return redirect("/admincategory")->with(['message' => "Added successfully."]);
        }
    }

    public function categoryManage(Request $request)
    {
        if (isset($request->id)) {
            $category = DB::table('itemcategory')->where('id', $request->id)->first();
            return view('admin.categorymanage')->with('category', $category);
        } else {
            return redirect("/admincategory");
        }
    }

    public function categoryManageProceed(Request $request)
    {
        if (isset($request->update)) {
            DB::table('itemcategory')
                ->where(['id' => $request->id])
                ->update(['category' => $request->category]);

            return redirect("/admincategorymanage?id=" . $request->id)->with(['message' => "Updated Successfully."]);
        }
    }


/*---------------------------------------------------------------------------
| UNIT
|--------------------------------------------------------------------------*/

    public function unit()
    {
        $unit = DB::table('itemunit')->orderBy('name', 'asc')->paginate(20);
        return view('admin.unit')->with('unit', $unit);
    }

    public function unitProceed(Request $request)
    {
        $unit = $request->input('unit');
        $data = array('name' => $unit);

        $unitExist = DB::table('itemunit')->where('name', $unit)->first();
        if (!empty($unitExist)) {
            return redirect("/adminunit")->with(['message' => "Do not enter an existing unit."]);
        } else {
            DB::table('itemunit')->insert($data);
            return redirect("/adminunit")->with(['message' => "Added successfully."]);
        }
    }

    public function unitManage(Request $request)
    {
        if (isset($request->id)) {
            $unit = DB::table('itemunit')->where('id', $request->id)->first();
            return view('admin.unitManage')->with('unit', $unit);
        } else {
            return redirect("/adminunit");
        }
    }

    public function unitManageProceed(Request $request)
    {
        if (isset($request->update)) {
            DB::table('itemunit')
                ->where(['id' => $request->id])
                ->update(['name' => $request->name]);

            return redirect("/adminunitmanage?id=" . $request->id)->with(['message' => "Updated Successfully."]);
        }
    }

}


