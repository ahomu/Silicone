<?php

$config = array(
    'debug'  => true,
    'urlgen' => true,
    'file'   => true,

    'phptal' => array(
        'phptal.class_path' => DIR_VENDOR.'pornel/PHPTAL',
    ),

    'cache'  => false && array(
        'cache_dir' => DIR_ROOT.'cache/',
    ),

    'session'=> false && array(
        'session.default_locale'    => 'ja',
        'session.storage.save_path' => DIR_ROOT.'session/',
    ),

    'db'     => array(
        'db.config' => array(
            'engine' => 'mysql',
            'host'   => 'localhost',
            'name'   => 'database',
            'user'   => 'root',
            'passwd' => 'root',
        ),
    ),
);
