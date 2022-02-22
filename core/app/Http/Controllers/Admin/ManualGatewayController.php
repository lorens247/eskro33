<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualGatewayController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manual Deposit Methods';
        $gateways = Gateway::manual()->with('currencies')->orderBy('id','desc')->get();
        $emptyMessage = 'No manual deposit method found';
        return view('admin.gateway.manual', compact('pageTitle', 'gateways','emptyMessage'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'name'           => 'required|max:60',
            'rate'           => 'required|numeric|gt:0',
            'currency'       => 'required|max:10',
            'min_limit'      => 'required|numeric|gt:0',
            'max_limit'      => 'required|numeric|gt:'.$request->min_limit,
            'fixed_charge'   => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|between:0,100',
            'instruction'    => 'required|max:64000',
            'field_name.*'   => 'sometimes|required'
        ],[
            'field_name.*.required'=>'All user data field name is required',
        ]);
        $lastMethod = Gateway::manual()->orderBy('id','desc')->first();
        $methodCode = 1000;
        if ($lastMethod) {
            $methodCode = $lastMethod->code + 1;
        }


        $inputForm = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', trim($request->field_name[$a])));
                $arr['field_level'] = trim($request->field_name[$a]);
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $inputForm[$arr['field_name']] = $arr;
            }
        }
        $method = new Gateway();
        $method->code = $methodCode;
        $method->name = $request->name;
        $method->alias = strtolower(trim(str_replace(' ','_',$request->name)));
        $method->status = 1;
        $method->gateway_parameters = json_encode([]);
        $method->input_form = $inputForm;
        $method->supported_currencies = json_encode([]);
        $method->crypto = 0;
        $method->description = $request->instruction;
        $method->save();

        $gatewayCurrency                    = new GatewayCurrency();
        $gatewayCurrency->name              = $request->name;
        $gatewayCurrency->currency          = $request->currency;
        $gatewayCurrency->method_code       = $methodCode;
        $gatewayCurrency->gateway_alias     = strtolower(trim(str_replace(' ','_',$request->name)));
        $gatewayCurrency->min_amount        = $request->min_limit;
        $gatewayCurrency->max_amount        = $request->max_limit;
        $gatewayCurrency->fixed_charge      = $request->fixed_charge;
        $gatewayCurrency->percent_charge    = $request->percent_charge;
        $gatewayCurrency->rate              = $request->rate;
        $gatewayCurrency->gateway_parameter = json_encode($inputForm);
        $gatewayCurrency->save();

        $notify[] = ['success', 'Manual gateway added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $code)
    {
        $request->validate([
            'name'           => 'required|max: 60',
            'rate'           => 'required|numeric|gt:0',
            'currency'       => 'required',
            'min_limit'      => 'required|numeric|gt:0',
            'max_limit'      => 'required|numeric|gt:'.$request->min_limit,
            'fixed_charge'   => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|between:0,100',
            'instruction'    => 'required|max:64000',
            'field_name.*'    => 'sometimes|required'
        ],[
            'field_name.*.required'=>'All user data field name is required',
        ]);
        $method = Gateway::manual()->where('code', $code)->firstOrFail();

        $input_form = [];
        if ($request->has('field_name')) {
            for ($a = 0; $a < count($request->field_name); $a++) {
                $arr = array();
                $arr['field_name'] = strtolower(str_replace(' ', '_', trim($request->field_name[$a])));
                $arr['field_level'] = trim($request->field_name[$a]);
                $arr['type'] = $request->type[$a];
                $arr['validation'] = $request->validation[$a];
                $input_form[$arr['field_name']] = $arr;
            }
        }

        $method->name = $request->name;
        $method->alias = strtolower(trim(str_replace(' ','_',$request->name)));
        $method->gateway_parameters = json_encode([]);
        $method->supported_currencies = json_encode([]);
        $method->crypto = 0;
        $method->description = $request->instruction;
        $method->input_form = $input_form;
        $method->save();


        $single_currency = $method->single_currency;

        $single_currency->name = $request->name;
        $single_currency->gateway_alias = strtolower(trim(str_replace(' ','_',$method->name)));
        $single_currency->currency = $request->currency;
        $single_currency->symbol = '';
        $single_currency->min_amount = $request->min_limit;
        $single_currency->max_amount = $request->max_limit;
        $single_currency->fixed_charge = $request->fixed_charge;
        $single_currency->percent_charge = $request->percent_charge;
        $single_currency->rate = $request->rate;
        $single_currency->gateway_parameter = json_encode($input_form);
        $single_currency->save();

        $notify[] = ['success','Manual gateway updated successfully'];
        return back()->withNotify($notify);
    }

    public function activate(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $method = Gateway::where('code', $request->code)->firstOrFail();
        $method->status = 1;
        $method->save();
        $notify[] = ['success', 'Gateway activated successfully'];
        return back()->withNotify($notify);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['code' => 'required|integer']);
        $method = Gateway::where('code', $request->code)->firstOrFail();
        $method->status = 0;
        $method->save();
        $notify[] = ['success', 'Gateway deactivated successfully'];
        return back()->withNotify($notify);
    }
}
