# Laravel Advert
Simple package that helps add advert to Laravel 5 websites. What is more it allows to see every advert clicks and views count for some statistics.

Forked from [OP: Adumskis](https://github.com/adumskis/laravel-advert)

### AdvertCategory model
Simple Eloquent model with variables:
  - type - (string) used for getting advert in specific category
  - width - (int) size in pixel to resize advert
  - height - (int) same as width

If width or height is set to 0 then advert image will be resized with [aspectRatio][1] method.

### Advert model
Eloquent model, variables:
  - alt - (string) <img /> alt parameter tag
  - url - (string) url address where advert should redirect on click
  - image_url - (string) url addres of advert image
  - image_path - (string) path to image (from base path)
  - views - (int) count of views
  - clicks - (int) count of clicks
  - active - (bool) advert state
  - advert_category_id - (int) advert category model id
  - viewed_at - (timestamp) datetime of last advert view

Advert model has make method that helps to create new record in database also handles image resize and storing stuff. Method requires array with advert variables values and UploadedFile object. Simple example:
```php
Advert::make(
    $request->only(['alt', 'url', 'active']), 
    $request->file('image')
);
```

It will return Advert object

### Usage in view
```php
    {{ AdvMng::getHTML('type') }}
```
It will take the that with lowest viewed_at parameter. getHTML method allow add second (bool) parameter and if it's true then it will not check if advert was already taken.
```php
    {{ AdvMng::getHTML('type', true) }}
```

### Advert image storage
```php
    'default_file_system' => 'public',
```
To use the inbuilt ability of laravels multiple filesystems change this to another public facing service provider such as s3.


### ToDo/Ideas
  - Add limit to advert views/clicks
  - Advert Campaigns
  - Advert Cost per click and cost per view?
  - Video Adverts.
  - Time of day adverts
  - Multiple adverts per campaign
  - Multiple images / videos per advert.
  - Follow Ad galley guide and create different size ads for different regions of the page.

[aspertRatio]:http://image.intervention.io/api/resize
