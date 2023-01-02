<?php
//Christine Johanson chjo2104  Miun Webbutveckling III - Projektuppgift 2022

//inkludera classer automatiskt
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php';
});

//om man utvecklar eller laddar upp på server
$devmode = false;

if ($devmode) {
    error_reporting(-1);
    ini_set("display_errors", 1);

    //DB-settings mot localhost
    define("DBHOST", "localhost");
    //dbuser
    define("DBUSER", "kvarteret");
    //password
    define("DBPASS", "password");
    //dbname
    define("DBDATABASE", "kvarteret");

} else {
        //mot server
        //aktiverar felrapportering. 
        error_reporting(-1);
        ini_set("display_errors", 1);
        //databas-inställningar - publicerat på miunserver
        define("DBHOST", "studentmysql.miun.se");
        define("DBUSER", "chjo2104");
        define("DBPASS", "6b3rZ5VK9!");
        define("DBDATABASE", "chjo2104");

}