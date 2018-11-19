<?php

return [
	"host"     	=> "192.168.10.10",
	"port"     	=> "3306",
	"username" 	=> "saturn001",
	"password" 	=> "your password",
	"dbname"   	=> "eattogether001",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]
];
