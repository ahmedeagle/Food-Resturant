<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use Carbon\Carbon;
use Validator;
 
class RolesController extends Controller {

    public function getIndex() {

         $data['title'] = "جميع الصلاحيات ";
         $data['roles'] = Role::all();
        
        return view('admin_panel.roles.index',$data);
    }


   public function create(){
      
      $data['title'] = "اضافه صلاحيه جديده ";
    return view('admin_panel.roles.create',$data);

   }


    public function save(Request $request){
      
       $messages = [
            'name.required'             => 'لابد من ادحال  اسم الصلاحية ',
            'permissions.required'      => 'لابد من احتيار صلاحيه اولا ',
            'permissions.array'         => 'لابد من احتيار صلاحيه اولا ',
            'permissions.min'           => 'لابد من احتيار صلاحيه اولا ',
        ];
        $rules = [
            'name'                         => 'required|unique:roles,name',
            'permissions'                  => 'required|array|min:1',
        ];

        $validator =  Validator::make($request -> all(), $rules , $messages);
 
        if($validator -> fails()){

                return redirect()->back()->with('errors',$validator -> errors())->withInput();
        }
 
       $role = new Role();
         
        // set the new values for update
        $role->name = $request->name;
        $role->permissions = json_encode($request->permissions);
        $role->save();

 
        return redirect()->route('admin.roles.index')->with("success" , "تمت الاضافة بنجاح");

   }
    

    public function edit($id) {


        $data['title'] = "تعديل صلاحية ";

        $data['role'] = Role::findOrFail($id) ;

       return view('admin_panel.roles.edit',$data);

    }

    
    public function update($id ,Request $request){

         
         $role = Role::findOrFail($id);

         $messages = [
            'name.required'             => 'لابد من ادحال  اسم الصلاحية ',
            'permissions.required'      => 'لابد من احتيار صلاحيه اولا ',
            'permissions.array'         => 'لابد من احتيار صلاحيه اولا ',
            'permissions.min'           => 'لابد من احتيار صلاحيه اولا ',
        ];
        $rules = [
            'name'                         => 'required',
            'permissions'                  => 'required|array|min:1',
        ];

        $validator =  Validator::make($request -> all(), $rules , $messages);
 
        if($validator -> fails()){

                return redirect()->back()->with('errors',$validator -> errors())->withInput();
        }
 

         
        // set the new values for update
        $role->name = $request->name;
        $role->permissions = json_encode($request->permissions);
        $role->save();

 
        return redirect()->route('admin.roles.index')->with("success" , "تم التعديل بنجاح ");

    }

    

    public function postDelete($id) {
        Role::findOrFail($id)->delete();


     return redirect()->route('admin.roles.index')->with("success" , "م الحذف بنجاح ");

    }

  

}
