<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    public function escrow()
    {
        return $this->belongsTo(Escrow::class);
    }

    public function scopeMakePaid($filter,$id,$user)
    {
        $milestone = $this->where('payment_status',0)->where('status',0)->whereHas('escrow',function($query){
            $query->where('status','!=',8)->where('status','!=',9);
        })->find($id);

        if ($milestone) {
            $user->balance -= $milestone->amount;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $milestone->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Milestone paid for '.$milestone->escrow->title;
            $transaction->trx = getTrx();
            $transaction->save();

            $milestone->payment_status = 1;
            $milestone->status = 1;
            $milestone->save();

            $escrow = $milestone->escrow;
            $escrow->paid_amount += $milestone->amount;
            $escrow->save();
        }
    }
}
