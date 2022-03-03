<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use Illuminate\Http\Request;

class AutomaticGatewayController extends Controller
{
    public function index()
    {
        $pageTitle = 'Automated Deposit Methods';
        $emptyMessage = 'No automatic deposit method found';
        $gateways = Gateway::automatic()->with('currencies')->get();
        return view('admin.gateway.automatic', compact('pageTitle', 'emptyMessage', 'gateways'));
    }

    public function configure(Request $request, $id){
        $gateway = Gateway::where('id',$id)->firstOrFail();

        $custom_attributes = [];
        $validation_rule = [];

        $parameters = collect(json_decode($gateway->gateway_parameters));

        foreach ($parameters->where('global', true) as $key => $pram) {
            $validation_rule['global.' . $key] = 'required';
            $custom_attributes['global.' . $key] = keyToTitle($key);
        }
        $request->validate($validation_rule,$custom_attributes);

        foreach ($parameters->where('global', true) as $key => $pram) {
            $parameters[$key]->value = $request->global[$key];
        }

        $currencies = $gateway->currencies;
        foreach ($currencies as $currency) {
            $credentials = json_decode($currency->gateway_parameter,true);
            foreach ($parameters as $key => $param) {
                unset($credentials[$key]);
                $credentials[$key] = $param->value;
            }
            $currency->gateway_parameter = $credentials;
            $currency->save();
        }

        $gateway->gateway_parameters = json_encode($parameters);
        $gateway->status = $request->status ? 1 : 0;
        $gateway->save();

        $notify[] = ['success', 'Gateway updated successfully'];
        return back()->withNotify($notify);
    }

    public function currency($id){
        $gateway = Gateway::where('id',$id)->firstOrFail();
        $currencies = $gateway->currencies()->with('method')->get();
        $supportedCurrencies = collect(json_decode($gateway->supported_currencies))->except($gateway->currencies->pluck('currency'));
        $pageTitle = 'Currencies of '.$gateway->name;
        $parameters = collect(json_decode($gateway->gateway_parameters));
        return view('admin.gateway.currencies', compact('pageTitle', 'gateway','supportedCurrencies','parameters','currencies'));
    }

    public function currencyAdd(Request $request){
        $gateway = Gateway::findOrFail($request->gateway_id);
        $validationRule = $this->gatewayValidation($gateway);
        $request->validate($validationRule);
        $gatewayCurrency = new GatewayCurrency();
        $this->gatewayToDatabase($request,$gatewayCurrency,$gateway);

        $notify[] = ['success','Currency added successfully'];
        return back()->withNotify($notify);
    }

    public function currencyUpdate(Request $request,$id){
        $gatewayCurrency = GatewayCurrency::findOrFail($id);
        $gateway = Gateway::where('code',$gatewayCurrency->method_code)->firstOrFail();
        $validationRule = $this->gatewayValidation($gateway);
        $request->validate($validationRule);
        $this->gatewayToDatabase($request,$gatewayCurrency,$gateway);
        $notify[] = ['success','Currency updated successfully'];
        return back()->withNotify($notify);
    }

    protected function gatewayValidation($gateway){
        $currencies = (array) json_decode($gateway->supported_currencies);
        $currencies = array_keys($currencies);
        $currencies = implode(',',$currencies);
        $validationRule['currency'] = 'required|max:10|string|in:'.$currencies;
        $validationRule['name'] = 'required|max:60';
        $validationRule['minimum'] = 'required|numeric|lte:maximum';
        $validationRule['maximum'] = 'required|numeric|gt:minimum';
        $validationRule['fixed_charge'] = 'required|numeric|gte:0';
        $validationRule['percent_charge'] = 'required|numeric|gte:0|max:100';
        $validationRule['rate'] = 'required|numeric|gte:0';
        $validationRule['symbol'] = 'required';
        $param_list = collect(json_decode($gateway->gateway_parameters));
        foreach ($param_list->where('global', false) as $paramKey => $paramValue) {
            $validationRule['param.' . $paramKey] = 'required';
        }
        return $validationRule;
    }

    protected function gatewayToDatabase($request,$gatewayCurrency,$gateway){
        $parameters = collect(json_decode($gateway->gateway_parameters));
        $param = [];
        foreach ($parameters->where('global', true) as $pkey => $pram) {
            $param[$pkey] = $pram->value;
        }

        foreach ($parameters->where('global', false) as $param_key => $param_value) {
            $param[$param_key] = $request->param[$param_key];
        }
        $gatewayCurrency->name = $request->name;
        $gatewayCurrency->currency = $request->currency;
        $gatewayCurrency->symbol = $request->symbol;
        $gatewayCurrency->method_code = $gateway->code;
        $gatewayCurrency->gateway_alias = $gateway->alias;
        $gatewayCurrency->min_amount = $request->minimum;
        $gatewayCurrency->max_amount = $request->maximum;
        $gatewayCurrency->percent_charge = $request->percent_charge;
        $gatewayCurrency->fixed_charge = $request->fixed_charge;
        $gatewayCurrency->rate = $request->rate;
        $gatewayCurrency->gateway_parameter = json_encode($param);
        $gatewayCurrency->save();
    }

    public function currencyUpdateRemove($id){
        $gatewayCurrency = GatewayCurrency::findOrFail($id);
        $gatewayCurrency->delete();
        $notify[] = ['success', 'Currency deleted successfully'];
        return back()->withNotify($notify);
    }

}
