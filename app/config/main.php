<?php

return array(
    'dev' => array(
        'db' => array (
            'host'    => 'localhost',
            'name'    => 'passbook',
            'user'    => 'passbook',
            'pass'    => 'passbookksed983fhge89dkoe',
            'charset' => 'utf8'
        ),
        'error' => array(
            'render'     => true,
            'level'      => E_ALL ^ E_NOTICE,
            'log'        => true,
            'throwError' => E_ALL ^ E_NOTICE,
        ),
    ),
    'prod' => array(
        'error' => array(
            'render'     => false,
            'level'      => E_ALL ^ E_NOTICE,
            'log'        => true,
            'throwError' => 0,
        ),
        'db' => array (
            'host'    => 'localhost',
            'name'    => 'XXXXXXXXXXXXXXX',
            'user'    => 'XXXXXXXXXXXXXXX',
            'pass'    => 'XXXXXXXXXXXXXXX',
            'charset' => 'utf8'
        ),
    ),
);