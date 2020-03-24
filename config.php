<?php

return [
    'database' => [
        'dsn' => 'mysql:host=localhost;dbname=storybook',
        'username' => 'root',
        'password' => '',
        'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    ]
];

?>