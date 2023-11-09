<?php

return [

    'mail' => [

        'subject' => '🔥 Attaque possible sur :domain',
        'message' => 'Une possible attaque :middleware sur :domain a été détectée à partir de l\'adresse :ip. L\'URL suivante a été affectée : url',

    ],

    'slack' => [

        'message' => 'Une possible attaque sur :domain a été détectée.',

    ],

];
