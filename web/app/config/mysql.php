<?php

return [
	"host"     	=> "influxdb001.mysql.aliyun.com",
	"port"     	=> "3306",
	"username" 	=> "saturn001",
	"password" 	=> "newlife123",
	"dbname"   	=> "puzzle001",
	"adapter"   => "mysqli",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]
];

