<?php 
    require_once("/var/www/html/app_maqueta/modelo/meekrodb.2.3.class.php");
    DB::$user = 'bay';
    DB::$password = 'bayental2019';
    DB::$dbName = 'crm_maqueta';
    DB::$host = 'mysql'; //defaults to localhost if omitted
    DB::$port = '3306'; // defaults to 3306 if omitted
    DB::$encoding = 'utf8'; // defaults to latin1 if omitted
?>