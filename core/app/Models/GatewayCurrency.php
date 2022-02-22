<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayCurrency extends Model
{
    protected $casts = ['status' => 'boolean'];

    // Relation
    public function method()
    {
        return $this->belongsTo(Gateway::class, 'method_code', 'code');
    }

    public function currencyIdentifier()
    {
        return $this->name ?? $this->method->name . ' ' . $this->currency;
    }

    public function scopeBaseCurrency()
    {
        return $this->method->crypto == 1 ? 'USD' : $this->currency;
    }

    public function scopeBaseSymbol()
    {
        return $this->method->crypto == 1 ? '$' : $this->symbol;
    }

    public function scopeMethodImage()
    {
        $image = null;
        if ($this->image) {
            $image = getImage(fileManager()->gateway()->path .'/' . $this->image,'800x800');
        }else{
            if ($this->method->image) {
                $image =  getImage(fileManager()->gateway()->path . '/' . $this->method->image,'800x800');
            }else{
                $image = asset(fileManager()->image()->default);
            }
        }
        return $image;
    }

}
