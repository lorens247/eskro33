<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{
    use HasFactory;

    public function seller(){
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function disputer(){
        return $this->belongsTo(User::class,'disputer_id');
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    public function getEscrowStatusAttribute(){
        if($this->status == 0){
            $html = '<span class="badge badge--info">'.trans("Not Accepted").'</span>';
        }elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans("Completed").'</span>';
        }elseif($this->status == 2){
            $html = '<span class="badge badge--success">'.trans("Accepted").'</span>';
        }elseif($this->status == 8){
            $html = '<span class="badge badge--danger">'.trans("Disputed").'</span>';
        }else{
            $html = '<span class="badge badge--secondary">'.trans("Cancelled").'</span>';
        }
        return $html;
    }
}
