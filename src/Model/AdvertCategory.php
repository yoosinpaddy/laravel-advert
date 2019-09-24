<?php

namespace Adumskis\LaravelAdvert\Model;

use Illuminate\Database\Eloquent\Model;

class AdvertCategory extends Model
{
    protected $fillable = ['type','price','currency','height','width','max_clicks'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adverts(){
        return $this->hasMany(Advert::class);
    }
}
