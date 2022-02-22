<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EscrowCharge;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class EscrowChargeController extends Controller
{
    public function index(){
        $pageTitle = 'Escrow Charges';
        $charges = EscrowCharge::get();
        $emptyMessage = 'Charges not found';
        return view('admin.escrow.charges',compact('pageTitle','charges','emptyMessage'));
    }

    public function store(Request $request){
        $this->validation($request);
        $charge = new EscrowCharge();
        $this->toDatabase($request,$charge);
        $notify[] = ['success','Escrow charge added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request,$id){
        $this->validation($request);
        $charge = EscrowCharge::findOrFail($id);
        $this->toDatabase($request,$charge);
        $notify[] = ['success','Escrow charge updated successfully'];
        return back()->withNotify($notify);
    }

    public function remove($id){
        $charge = EscrowCharge::findOrFail($id);
        $charge->delete();
        $notify[] = ['success','Escrow charge deleted successfully'];
        return back()->withNotify($notify);
    }

    public function globalCharge(Request $request){
        $request->validate([
            'charge_cap'=>'required|numeric|gte:0',
            'fixed_charge'=>'required|numeric|gte:0',
            'percent_charge'=>'required|numeric|gte:0',
        ]);
        $general = GeneralSetting::first();
        $general->charge_cap = $request->charge_cap;
        $general->fixed_charge = $request->fixed_charge;
        $general->percent_charge = $request->percent_charge;
        $general->save();

        $notify[] = ['success','Global charge setting updated successful'];
        return back()->withNotify($notify);

    }

    private function validation($request){
        $request->validate([
            'minimum'=>'required|numeric|gt:0',
            'maximum'=>'required|numeric|gt:minimum',
            'fixed_charge'=>'required|numeric|gte:0',
            'percent_charge'=>'required|numeric|gte:0',
        ]);
    }

    private function toDatabase($request,$charge)
    {
        $charge->minimum = $request->minimum;
        $charge->maximum = $request->maximum;
        $charge->fixed_charge = $request->fixed_charge;
        $charge->percent_charge = $request->percent_charge;
        $charge->save();
    }
}
