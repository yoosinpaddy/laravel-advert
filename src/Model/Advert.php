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
        if(!$image){
            throw new \Exception('UploadedFile required');
        }

        $validator = Validator::make(
            $data,
            [
                'url' => 'required',
                'active' => 'boolean',
                'advert_category_id' => 'required|exists:advert_categories,id'
            ]
        );

        if ($validator->fails())
        {
            throw new \Exception($validator->messages()->first());
        }

        $advert = Advert::create($data);
        $advert->addMediaFromRequest('image')->toMediaCollection();

        return $advert;
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
        return url('a/'.$this->id);
    }
}
