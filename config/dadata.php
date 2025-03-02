<?php

return [
    'token' => env('DADATA_TOKEN', null),

    'secret' => env('DADATA_SECRET', null),

    'timeout' => env('DADATA_TIMEOUT', 10),

    'version' => env('DADATA_VERSION', '4_1'),

    'suggestions_api' => env('DADATA_SUGGESTIONS_API', 'https://suggestions.dadata.ru/suggestions/api')
];
