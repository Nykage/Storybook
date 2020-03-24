<?php
require_once './database/Connection.php';

$config = require '../config.php'; //_DIR_
//riippuu sijainnista, tässä kolmen kansion päässä

$db = Connection::make($config['database']);
?>