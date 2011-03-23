<?php
/*--------------------------------*\
| RaxeZDev Vote System - by DataBase/Jesper | 
| Website: www.RaxeZDev.info/www.hammer-wow.com     |
| Copyright 2010                   |
\*--------------------------------*/ 

if(!isset($_SESSION)) {
session_start();	
}

# config file
require_once("rdvs_config.php");

if(!isset($rdvs_x)) { die(); }

# error display function
require_once("rdvs/error.php");

# mysql functions
require_once("rdvs/mysql.php");
$mysql = new mysql();

# action functions
require_once("rdvs/actions.php");
$actions = new actions();

# content functions
require_once("rdvs/content.php");
$rdvs = new rdvs();

# form, etc. handler
require_once("rdvs/handler.php");

require("rdvs/template.php");

?>