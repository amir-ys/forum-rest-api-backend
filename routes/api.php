<?php

use Illuminate\Support\Facades\Route;

route::prefix('v1')->group(function () {

    //Authentication
    include __DIR__ . '/v1/auth_routes.php';

    //Channels
    include __DIR__ . '/v1/channels_routes.php';

    //Threads
    include __DIR__ . '/v1/threads_routes.php';

});
