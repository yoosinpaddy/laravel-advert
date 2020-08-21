<?php

namespace Adumskis\LaravelAdvert\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Adumskis\LaravelAdvert\Model\AdvertCategory;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Advert extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'alt',
        'url',
        'views',
        'clicks',
        'max_clicks',
        'active',
        'advert_category_id'
    ];

    protected $dates = ['viewed_at'];

    /**
     * @param array $data
     * @param UploadedFile $image
     * @return Advert
     * @throws \Exception
     */
    public static function make(array $data, UploadedFile $image = null){

        $advert = Advert::create($data);

        if($image != null) {
            $advert->addMedia($image)
                ->withManipulations([
                    'default' => ['width' => '90', 'height' => 90]
                ])
                ->toMediaCollection();
        }

        return $advert;
    }
    
    public function getDateStart($format = "Y-m-d")
    {
        $date = date($format, strtotime($this->date_start))."T".date('H:i', strtotime($this->date_start));
        return $date;
    }
    
    public function getDateEnd($format = "Y-m-d")
    {
        $date = date($format, strtotime($this->date_end))."T".date('H:i', strtotime($this->date_end));
        return $date;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function advert_category()
    {
        return $this->belongsTo(AdvertCategory::class);
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function payment()
    {
        return $this->morphTo();
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return bool
     */
    public function activate()
    {
        return $this->update(['active' => true]);
    }

    /**
     * @return bool
     */
    public function deactivate()
    {
        return $this->update(['active' => false]);
    }

    /**
     * @return bool
     */
    public function plusViews()
    {
        return $this->update(['views' => $this->views+1]);
    }

    /**
     * @return bool
     */
    public function plusClicks()
    {
        return $this->update(['clicks' => $this->clicks+1]);
    }

    /**
     * @return bool
     */
    public function resetViews()
    {
        return $this->update(['views' => 0]);
    }

    /**
     * @return bool
     */
    public function resetClicks()
    {
        return $this->update(['clicks' => 0]);
    }

    /**
     * @return bool
     */
    public function updateLastViewed()
    {
        $this->viewed_at = Carbon::now();
        return $this->save();
    }

    /**
     * @throws \Exception
     */
    public function delete()
    {
        $this->clearMediaCollection();
        parent::delete();
    }


    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getURL()
    {
        return url('/advert/redirection/'.$this->id);
    }
}
