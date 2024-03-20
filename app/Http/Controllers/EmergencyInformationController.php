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
        $request->merge(['user_id'=>auth()->user()->id]);
     

        DB::beginTransaction();
        try {
            
            $user_information = EmergencyContact::firstOrNew(
                ['user_id' =>  $request->user_id],
            );
            $user_information->user_id              = $request->user_id;
            $user_information->name          = $request->name;
            $user_information->relationship = $request->relationship;
            $user_information->phone                  = $request->phone;
            $user_information->save();

            DB::commit();
            Toastr::success('Create Emergency information successfully :)','Success');
            return redirect()->back();
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add personal information fail :)','Error');
            return redirect()->back();
        }
    }
}
