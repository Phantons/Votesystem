<?php
/*--------------------------------*\
| RaxeZDev Vote System - by DataBase/Jesper | 
| Website: www.RaxeZDev.info/www.hammer-wow.com       |
| Copyright 2010                   |
\*--------------------------------*/
if(!isset($rdvs_x)) { die(); }

function error($type, $error_msg) {
	
switch($type) {
		case "logon": $error_title = "Logon MySQL"; break;
		case "rdvs":  $error_title = "RDVS MySQL"; break;
		case "realm": $error_title = "Realm MySQL"; break;
		default: $error_title = "Unknown / misc"; break;
	}
	
	$template = '<div style="font-family:verdana;font-size:14px;color:#1e1e1e;background-color:#eee;position:relative;margin-left:auto;margin-right:auto;width:300px;padding:20px;border:1px solid #ccc;">
	<h3 style="margin:0px;padding:0px;color:red;text-align:center;">RDVS Error</h3>Type: '.$error_title.' <br />Error: '.$error_msg.'</div>';
	
	die($template); 
}

?>