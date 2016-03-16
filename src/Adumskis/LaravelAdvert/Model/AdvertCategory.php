<?php

namespace Adumskis\LaravelAdvert\Model;

use Illuminate\Database\Eloquent\Model;

class AdvertCategory extends Model
{
    protected $fillable = ['type', 'width', 'height'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adverts(){
        return $this->hasMany(Advert::class);
    }

    /**
     *
     */
    public function delete(){
        foreach($this->adverts as $advert){
            $advert->delete();
        }
    }
}
