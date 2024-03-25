<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmergencyInformationController extends Controller
{
    public function saveRecord(Request $request)
    {
        // dd($request->all());
     

        // DB::beginTransaction();
        // try {
            
            $user_information = EmergencyContact::updateOrCreate(
                ['user_id' => $request->user_id], 
                $request->all() 
            );
            
        

          

            DB::commit();
            Toastr::success('Emergency information successfully :)','Success');
            return redirect()->back();
            
        // } catch(\Exception $e) {
        //     DB::rollback();
        //     Toastr::error('Add Emergency information fail :)','Error');
        //     return redirect()->back();
        // }
    }
}
