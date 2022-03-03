<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawMethodController extends Controller
{
    public function methods()
    {
        $pageTitle = 'Withdrawal Methods';
        $emptyMessage = 'No withdrawal method not found';
        $methods = WithdrawMethod::orderBy('status','desc')->orderBy('id')->get();
        return view('admin.withdraw.index', compact('pageTitle', 'emptyMessage', 'methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max: 60',
            'rate' => 'required|numeric|gt:0',
            'currency' => 'required',
            'min_limit' => 'required|numeric|gt:0',
            'max_limit' => 'required|numeric|gt:min_limit',
            'fixed_charge' => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|between:0,100',
            'instruction' => 'required|max:64000',
            'field_name.*'    => 'sometimes|required'
        ],[
            'field_name.*.required'=>'All user data field name is required'
        ]);

        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {

                $arr = [];
                $arr['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$a]));
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }

        $method = new WithdrawMethod();
        $method->name = $request->name;
        $method->rate = $request->rate;
        $method->min_limit = $request->min_limit;
        $method->max_limit = $request->max_limit;
        $method->fixed_charge = $request->fixed_charge;
        $method->percent_charge = $request->percent_charge;
        $method->currency = $request->currency;
        $method->description = $request->instruction;
        $method->user_data = $input_form;
        $method->save();
        $notify[] = ['success', 'Withdrawal method added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'           => 'required|max: 60',
            'rate'           => 'required|numeric|gt:0',
            'min_limit'      => 'required|numeric|gt:0',
            'max_limit'      => 'required|numeric|gt:min_limit',
            'fixed_charge'   => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|between:0,100',
            'currency'       => 'required',
            'instruction'    => 'required|max:64000',
            'field_name.*'    => 'sometimes|required'
        ],[
            'field_name.*.required'=>'All user data field name is required'
        ]);

        $method = WithdrawMethod::findOrFail($id);


        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = [];
                $arr['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$a]));
                $arr['field_level'] = $request->field_name[$a];
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }

        $method->name           = $request->name;
        $method->rate           = $request->rate;
        $method->min_limit      = $request->min_limit;
        $method->max_limit      = $request->max_limit;
        $method->fixed_charge   = $request->fixed_charge;
        $method->percent_charge = $request->percent_charge;
        $method->description    = $request->instruction;
        $method->user_data      = $input_form;
        $method->currency       = $request->currency;
        $method->save();

        $notify[] = ['success', 'Withdrawal method updated successfully'];
        return back()->withNotify($notify);
    }



    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $method = WithdrawMethod::findOrFail($request->id);
        $method->status = 1;
        $method->save();
        $notify[] = ['success', 'Withdrawal method activated successfully'];
        return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $method = WithdrawMethod::findOrFail($request->id);
        $method->status = 0;
        $method->save();
        $notify[] = ['success', 'Withdrawal method deactivated successfully'];
        return back()->withNotify($notify);
    }

}
