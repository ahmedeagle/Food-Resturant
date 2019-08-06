<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{


    public function  prepareSearch(Request $request){

          (new BaseConroller())->setLang($request);
            $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;

           $providerTypes =  DB::table('categories') 
                              -> select(
                                          'id',
                                          $name.'_name as name'
                                        )
                              -> get();

             $foodTypes = DB::table('mealsubcategories')  
                              -> select(
                                          'id',
                                          $name.'_name as name'
                                        )
                             -> get();

              $foodcategories = DB::table('subcategories')  
                              -> select(
                                          'id',
                                          $name.'_name as name'
                                        )
                             -> get();                

                $features     = DB::table('options') 

                                         -> select(
                                                  'id',
                                                  $name.'_name as name'
                                                )
                                        -> get();


          return response()->json(['status'=>true, 'errNum' => 0, 'msg' => trans('successfully'), 'providerTypes' => $providerTypes, 'foodTypes' => $foodTypes, 'foodcategories' => $foodcategories,'features' => $features]);



    }



    public function filterResturants(Request $request){


            $lang = $request->input('lang');
    if($lang == "ar"){
      $msg = array(
        0 => 'يوجد بيانات',
        1 => 'لا يوجد نتائج لبحثك',
        2 => 'يجب ان تختار التاريخ عند البحث بالوقت',
        3 => 'يجب إرسال تفاصيل موقع المستخدم',
        4 => 'المسافه يجب ان تكون بالأرقام',
        5 => 'الوقت يجب ان يكون فى تنسيق h:i (09:05)',
        6 => 'التاريخ يجب ان يكون فى تنسيق yyyy-mm-dd',
        7 => 'يجب إختيار المدينة المراد البحث بها',
        8 => 'type يجب ان يكون provider او meal'
      );
    }else{
      $msg = array(
        0 => 'Retrieved successfully',
        1 => 'There is no result for your search',
        2 => 'You must determine the date if you search with time',
        3 => 'user longitude and latitude is required',
        4 => 'distance must be in number',
        5 => 'time must be in format H:i ex:- (09:05)',
        6 => 'date must be in format yyyy-mm-dd',
        7 => 'Please select city',
        8 => 'type attribute must be provider or meal'
      );
    }

    $messages = array(
      'required'         => 7,
      'numeric'          => 4,
      'time.date_format' => 5,
      'date.date_format' => 6,
      'required_with'    => 3,
      'in'               => 8
    );


  $rules=[
            "type"           => "required|in:0,1" ,
            "provider_type"  => "sometimes|nullable|exists:categories,id",
            "foodcategories" => "sometimes|nullable|exists:subcategories,id",
            "foodtype"       => "sometimes|nullable|exists:mealcategories,id",
            "features"       =>  "sometimes|nullable|exists:mealcategories,id",

       ];

       if($request -> has('type'))
       {
                    // filter  result by distance  so lat and lun  must required 
            if($request -> type == 0 or  $request -> type == '0')
            {
                 
                 $rules['latitude']  = 'required';
                 $rules['longitude'] = 'required';
            }
       }



       return $rules;

    $validator = Validator::make($request->all(),$rules,$messages);

    if($validator->fails()){
      $error = $validator->errors()->first();
      return response()->json(['status' => false, 'errNum' => $error, 'msg' => $msg[$error]]);
    }



    }

    public function search(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "name"            => "required",
            "latitude"       => "required",
            "longitude"      => "required",

        ];
        $messages   = [
            "required"   => 1
        ];
        $msg        = [
            1  => trans("messages.required"),
            3  => trans("messages.success"),
            4  => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
         //$search =   html_entity_decode($request->input("name"), ENT_COMPAT, 'UTF-8');
         $search =   $request->input("name");
         
         
            
         $providerspag =  DB::table("providers")
                        ->join("images" , "images.id" ,"providers.image_id")
                        ->join('branches','branches.provider_id','=','providers.id')
                        ->where("providers.ar_name" , "LIKE" ,"%" . $search . "%")
                        ->orWhere("providers.en_name" , "LIKE" ,"%" . $search . "%")
                   //     ->where("providers.phoneactivated" , "1")
                        ->where("providers.accountactivated" , "1")
                        ->select(
                            "branches.id AS id",
                            "providers.id AS provider_id",
                             DB::raw("CONCAT(providers .ar_name,'-',branches .ar_name) AS name"),
                             "branches.has_delivery",
                             "branches.has_booking",
                             "branches.longitude",
                             "branches.latitude",
                             "branches." .$name ."_address AS address",
                             "branches.average_price AS mealAveragePrice",
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                        )
                        ->paginate(10);
                        
        (new HomeController())->filter_providers_branches($request,$name,$providerspag);

            // filter based on distance
            $providers = $providerspag->sortBy(function($item){
                return $item->distance;
            })->values();
            
            
               // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($providers);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath(url()->current());

        
        
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "providers" => $paginatedItems]);
    }

    public function get_provider_names(){
        $providers_ar = DB::table("providers")
                            ->join("branches", "branches.provider_id", "providers.id")
                            ->select(
                                "providers.ar_name AS name"
                            )
                            ->groupBy("providers.id")
                            ->get();

        $providers_en = DB::table("providers")
                            ->join("branches", "branches.provider_id", "providers.id")
                            ->select(
                                "providers.en_name AS name"
                            )
                            ->groupBy("providers.id")
                            ->get();

        return response()->json([
                                    'status' => true,
                                    'errNum' => 0,
                                    'msg' => trans("messages.success") ,
                                    'ar_names' => $providers_ar,
                                    'en_names' => $providers_en
                                ]);
    }




        // method to fitlrt  result by distance or rate  in search nd near you screens
    public function searchResultOrderBy(Request $request){
     (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';
        // type 0 -> distance , 1 -> rate
        $rules      = [
            "type"      => "required|in:0,1",
             
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2,
            "in"         => 4
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.subCategory_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.type.in.0.1")
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        $type = $request->input("type");

          if($request -> has('name'))
          {
                


         $pagianted_branches =    DB::table("provider_subcategories")
                                ->join("providers" , "providers.id" , "provider_subcategories.provider_id")
                                 ->where("providers.ar_name" , "LIKE" ,"%" . $request  -> name . "%")
                                 ->orWhere("providers.en_name" , "LIKE" ,"%" .$request  -> name . "%")
                                ->join("images" , "images.id" ,"providers.image_id")
                                // ->where("providers.phoneactivated" , "1")
                                ->where("providers.accountactivated" , "1")
                                 ->join('branches','branches.provider_id','=','providers.id')
                                ->select(
                                        "branches.id AS id",
                                        "providers.id AS provider_id",
                                        "branches.id AS id",
                                        "branches.has_delivery",
                                        "branches.has_booking",
                                        "branches.longitude",
                                        "branches.latitude",
                                        "branches." .$name ."_address AS address",
                                        "branches.average_price AS mealAveragePrice",
                                   /* "providers." . $name . "_name AS name",*/
                                    DB::raw("CONCAT(providers .".$name."_name,'-',branches .".$name."_name) AS name"),
                                    
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                                )
                                ->groupBy("branches.id")
                                ->paginate(10);  

           }else{
          

          $pagianted_branches =    DB::table("provider_subcategories")
                                ->join("providers" , "providers.id" , "provider_subcategories.provider_id")
                                ->join("images" , "images.id" ,"providers.image_id")
                                // ->where("providers.phoneactivated" , "1")
                                ->where("providers.accountactivated" , "1")
                                 ->join('branches','branches.provider_id','=','providers.id')
                                ->select(
                                        "branches.id AS id",
                                        "providers.id AS provider_id",
                                        "branches.id AS id",
                                        "branches.has_delivery",
                                        "branches.has_booking",
                                        "branches.longitude",
                                        "branches.latitude",
                                        "branches." .$name ."_address AS address",
                                        "branches.average_price AS mealAveragePrice",
                                   /* "providers." . $name . "_name AS name",*/
                                    DB::raw("CONCAT(providers .".$name."_name,'-',branches .".$name."_name) AS name"),
                                    
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                                )
                                ->groupBy("branches.id")
                                ->paginate(10);  


  }

         
                                
                                

            //orderby distance 
        (new HomeController())->filter_providers_branches($request,$name,$pagianted_branches ,$type);
 
        if($type == 0){
            // filter based on distance
            $branches = $pagianted_branches->sortBy(function($item){
                return $item->distance;
            })->values();
        }else{
            // filter by rate
            $branches = $pagianted_branches->sortByDesc(function($item){
                return $item->averageRate;
            })->values();
        }

        $branches = new LengthAwarePaginator(
                                $branches,
                                $pagianted_branches->total(),
                                $pagianted_branches->perPage(),
                                $request->input("page"),
                                ["path" => url()->current()]

        );

        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3], "providers" => $branches]);
    

    }
}
