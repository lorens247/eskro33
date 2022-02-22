<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EscrowType;
use Illuminate\Http\Request;

class EscrowTypeController extends Controller
{
    public function index(){
        $pageTitle = 'Escrow Types';
        $types = EscrowType::paginate(getPaginate());
        $emptyMessage = 'No escrow type found';
        return view('admin.escrow.type',compact('pageTitle','types','emptyMessage'));
    }

    public function store(Request $request){
        $this->validation($request);
        $type = new EscrowType();
        $this->toDatabase($request,$type);

        $notify[] = ['success','Type added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request,$id){
        $this->validation($request);
        $type = EscrowType::findOrFail($id);
        $this->toDatabase($request,$type,$request->status);

        $notify[] = ['success','Type updated successfully'];
        return back()->withNotify($notify);
    }

    private function validation($request){
        $request->validate([
            'name'=>'required'
        ]);
    }

    private function toDatabase($request,$type,$status = true){
        $type->name = $request->name;
        $type->status = $status ? 1 : 0;
        $type->save();
    }
}
