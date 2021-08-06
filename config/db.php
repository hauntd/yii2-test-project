<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . realpath(__DIR__ . '/../data') . '/sqlite.db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
