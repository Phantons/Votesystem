<?php 
/*--------------------------------*\
| RaxeZDev Vote System - by DataBaseJesper | 
| Website: www.RaxeZDev.info/www.hammer-wow.com      |
| Copyright 2010                   |
\*--------------------------------*/
if(!isset($rdvs_x)) { die(); }

class mysql {
	
	function connect($type) {
		
		switch($type) {
		
		// logon
		case "logon":
			global $rdvs_mysql_logon_host, $rdvs_mysql_logon_user, $rdvs_mysql_logon_pass;
			@$rdvs_logon_con = mysql_pconnect($rdvs_mysql_logon_host, $rdvs_mysql_logon_user, $rdvs_mysql_logon_pass) or error("logon", mysql_error());
                         mysql_set_charset('utf8',$rdvs_logon_con);
		break;
		
		// rdvs
		case "rdvs":
			global $rdvs_mysql_host, $rdvs_mysql_user, $rdvs_mysql_pass;
			@$rdvs_con = mysql_pconnect($rdvs_mysql_host, $rdvs_mysql_user, $rdvs_mysql_pass) or error("rdvs", mysql_error());
                         mysql_set_charset('utf8',$rdvs_con);
		break;
		}
		
		
	}
	
	
	
	
}

?>