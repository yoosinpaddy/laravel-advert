<?php

namespace Artme\LaravelAdvert;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artme\LaravelAdvert\Model\Advert;

use App\Http\Requests;

class AdvertManagerController extends Controller
{

    /**
     * Simple controller method to add clicks count
     *
     *
     * @param $advert_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index($advert_id){
        $advert = Advert::findOrFail($advert_id);
        $advert->plusClicks();

        return redirect($advert->url);
    }
}
