<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Offer;
use DB;
use Validator;

class Offers extends Controller
{

    function __construct()
    {

    }

    public function index($status)
    {
        $data['title'] = 'العروض';
        if ($status == "active") {
            $con = ["1"];
        } elseif ($status == "notactive") {
            $con = ["0"];
        } else {
            $con = ["1", "0"];
        }
        $data['offers'] = DB::table("offers")
            ->join("images", "images.id", "offers.image_id")
            ->join("providers", "providers.id", "offers.provider_id")
            ->whereIn("offers.approved", $con)
            ->select(
                "offers.id",
                "offers.ar_title",
                "offers.en_title",
                "offers.ar_notes",
                "offers.en_notes",
                "offers.created_at",
                "offers.approved",
                "images.name AS image",
                "offers.lft",
                "providers.ar_name"
            )
            ->orderBy("offers.lft")
            ->get();
        return view("admin_panel.offers.list", $data);
    }

    public function get_add()
    {
        $data['title'] = 'اضافة عرض جديد';
        $data['providers'] = DB::table("providers")->where('accountactivated', "1")->get();
        return view("admin_panel.offers.add", $data);
    }

    public function post_add(Request $request)
    {
        $messages = [
            'en_title.required' => 'برجاء ادخال عنوان العرض بالانجليزية',
            'ar_title.required' => 'برجاء ادخال عنوان بالعربية',
            'en_notes.required' => 'برجاء ادخال ملاحظات  العرض بالانجليزية',
            'ar_notes.required' => 'برجاء  ادخال ملاحظات العرض بالعربية',
            'provider_id.required' => 'برجاء اختيار المطعم',
            'image.required' => 'الصورة مطلوبة.',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'approved.required' => 'برجاء اختيار حالة العرض',
            'branches.required' => 'لابد من اختيار فرع علي الاقل ',
            'branches.array' => 'لابد ان يكون الافرع علي شكل مصفوفه ',
            'branches.min' => 'لابد من اختيار فرع علي الاقل ',
            'branches.*.exists' => 'هذا الفرع غير موجود لدينا ',
            'branches.*.required' => 'لابد من اختيار فرع علي الاقل '
        ];
        $rules = [
            'en_title' => 'required',
            'ar_title' => 'required',
            'ar_notes' => 'required',
            'en_notes' => 'required',
            'provider_id' => 'required',
            'approved' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
            'branches' => 'required|array|min:1',
            'branches.*' => 'required|exists:branches,id'
        ];
        $this->validate($request, $rules, $messages);

        $image = DB::table("images")->insertGetId([
            'name' => $request->image->hashName()
        ]);

        $request->image->store('offers', 'public');


        try {
            DB::beginTransaction();
            $offerId = DB::table("offers")
                ->insertGetId([
                    "ar_title" => $request->input("ar_title"),
                    "en_title" => $request->input("en_title"),
                    "ar_notes" => $request->input("ar_notes"),
                    "en_notes" => $request->input("en_notes"),
                    "image_id" => $image,
                    "provider_id" => $request->input("provider_id"),
                    "approved" => $request->input("approved"),
                ]);

            foreach ($request->branches as $branchId) {
                DB::table('offers_branches')->insert([
                    'offer_id' => $offerId,
                    'branch_id' => $branchId
                ]);
            }
            DB::commit();
            return redirect("/admin/offers/list/all")->with("success", "تمت الاضافة بنجاح");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect("/admin/offers/list/all")->with("error", $e->getMessage());
        }
    }

    public function get_edit($id)
    {
        $data['title'] = 'تعديل العرض';
        $data['offers'] = DB::table("offers")
            ->join("images", "images.id", "offers.image_id")
            ->join("providers", "providers.id", "offers.provider_id")
            ->where("offers.id", $id)
            ->select(
                "offers.id",
                "offers.ar_title",
                "offers.en_title",
                "offers.ar_notes",
                "offers.en_notes",
                "offers.provider_id",
                "providers.ar_name",
                "offers.approved",
                "images.name AS filename"
            )
            ->first();
        $data['providers'] = DB::table("providers")
            ->where("accountactivated", "1")
            ->get();

        if (!$data['offers']) {
            return redirect("/admin/offers")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }


        $data['branches'] = DB::table('branches')
            ->where('published', 1)
            ->where('provider_id', $data['offers']->provider_id)
            ->select('id',
                'ar_name as name',
                DB::raw('IF ((SELECT count(id) FROM offers_branches WHERE offers_branches.offer_id = ' . $id . ' AND offers_branches.branch_id = branches.id) > 0, 1, 0) as selected')
            )->get();

        return view("admin_panel.offers.edit", $data);
    }

    public function post_edit($id, Request $request)
    {
        $data = DB::table("offers")
            ->join("images", "images.id", "offers.image_id")
            ->where("offers.id", $id)
            ->select(
                "offers.image_id",
                "images.name AS filename"
            )
            ->first();
        if (!$data) {
            return redirect("/admin/offers/list/all")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
        $messages = [
            'en_title.required' => 'برجاء ادخال عنوان العرض بالانجليزية',
            'ar_title.required' => 'برجاء ادخال عنوان بالعربية',
            'en_notes.required' => 'برجاء ادخال ملاحظات  العرض بالانجليزية',
            'ar_notes.required' => 'برجاء  ادخال ملاحظات العرض بالعربية',
            'provider_id.required' => 'برجاء اختيار المطعم',
            'image.mimes' => 'نوع الصورة غير مدعوم.',
            'approved.required' => 'برجاء اختيار حالة العرض',
            'branches.required' => 'لابد من اختيار فرع علي الاقل ',
            'branches.array' => 'لابد ان يكون الافرع علي شكل مصفوفه ',
            'branches.min' => 'لابد من اختيار فرع علي الاقل ',
            'branches.*.exists' => 'هذا الفرع غير موجود لدينا ',
            'branches.*.required' => 'لابد من اختيار فرع علي الاقل '
        ];
        $rules = [
            'en_title' => 'required',
            'ar_title' => 'required',
            'provider_id' => 'required',
            'approved' => 'required',
            'image' => 'mimes:jpg,jpeg,png',
            'ar_notes' => 'required',
            'en_notes' => 'required',
            'branches' => 'required|array|min:1',
            'branches.*' => 'required|exists:branches,id'
        ];
        $this->validate($request, $rules, $messages);

        try {
            DB::beginTransaction();

            if ($request->hasFile("image")) {
                DB::table("images")
                    ->where("id", $data->image_id)
                    ->update([
                        'name' => $request->image->hashName()
                    ]);
                Storage::delete('public/offers/' . $data->filename);
                $request->image->store('offers', 'public');
            }


            //delete all previous offer branches
            DB::table('offers_branches')->where('offer_id', $id)->delete();

            foreach ($request->branches as $branchId) {
                DB::table('offers_branches')->insert([
                    'offer_id' => $id,
                    'branch_id' => $branchId
                ]);
            }


            DB::table("offers")
                ->where("id", $id)
                ->update([
                    "ar_title" => $request->input("ar_title"),
                    "en_title" => $request->input("en_title"),
                    "ar_notes" => $request->input("ar_notes"),
                    "en_notes" => $request->input("en_notes"),
                    "provider_id" => $request->input("provider_id"),
                    "approved" => $request->input("approved")
                ]);


            DB::commit();
            return redirect("/admin/offers/list/all")->with("success", "تمت الاضافة بنجاح");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect("/admin/offers/list/all")->with("error", $e->getMessage());
        }


        return redirect("/admin/offers/list/all")->with("success", "تمت العملية بنجاح");
    }

    public function delete($id)
    {
        $data = DB::table("offers")
            ->join("images", "images.id", "offers.image_id")
            ->where("offers.id", $id)
            ->select("offers.image_id", "images.name AS filename")
            ->first();
        if ($data) {
            DB::table("images")->where("id", $data->image_id)->delete();
            Storage::delete('public/offers/' . $data->filename);
            DB::table("offers")->where("id", $id)->delete();
            return redirect("/admin/offers")->with("success", "تمت العملية بنجاح");
        } else {
            return redirect("/admin/offers")->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }

    public function reorder()
    {

        $data['title'] = 'إعاده ترتيب العروض ';

        $data['offers'] = DB::table("offers")
            ->orderBy('lft')->get();

        return view("admin_panel.offers.reorder", $data);

    }


    public function saveReorder(Request $request)
    {

        $count = 0;
        $all_entries = $request->input('tree');

        if (count($all_entries)) {
            foreach ($all_entries as $key => $entry) {
                if ($entry['item_id'] != "" && $entry['item_id'] != null) {
                    $item = Offer::find($entry['item_id']);
                    $item->depth = $entry['depth'];
                    $item->lft = $entry['left'];
                    $item->rgt = $entry['right'];
                    $item->save();

                    $count++;
                }
            }
        } else {
            return false;
        }

        return 'success for ' . $count . " items";

    }


}
