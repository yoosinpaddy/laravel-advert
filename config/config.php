<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default file system to be used for uploading the inages
    | of the adverts
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default_fileSystem' => 'local',





    // Path should not contain adv/advert/ad or anything similar to word 'advert'
    // because of ad-block
    'upload_path' => 'uploads/a'
];