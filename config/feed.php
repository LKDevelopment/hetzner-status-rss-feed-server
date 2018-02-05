<?php

/*-------------------------------------------
Config file for FeedParser

-------------------------------------------
*/

return [

    /*
        Where to store cache. Here we use Laravel and Lumen default
    */
    'cache.location' => storage_path().'/framework/cache',

    /*
        Lifetime of cache
    */
    'cache.life' => env('FEED_CACHE_LIFE', 3600),

    /*
        Wheter cache is enable in your context
    */
    'cache.enabled' => false,

    /*
        Set how many items retrieve when using multi urls
     */
    'item_limit' => env('FEED_ITEM_LIMIT', 10),
];
