<?php
/*--------------------------------*\
| RaxeZDev Vote System - by DataBase/Jesper |
| Website: www.RaxeZDev.info/www.hammer-wow.com     |
| Copyright 2010                   |
\*--------------------------------*/
if(!isset($rdvs_x)) { die(); }

class actions extends mysql{

	function login() {
		global $rdvs_mysql_logon_db, $rdvs_page, $rdvs_core;
		$this->connect("logon");
		mysql_select_db($rdvs_mysql_logon_db);
		
		$account = strtoupper(htmlspecialchars($_POST['rdvs_user']));
		$sha_pass_hash = sha1(strtoupper(htmlspecialchars($_POST['rdvs_user'])) . ":" . strtoupper(htmlspecialchars($_POST['rdvs_sha_pass_hash'])));
		// prevent sql injections
                 $rdvs_user = mysql_real_escape_string($account);
		
		// query
                if($rdvs_core == 1){
                    $query = sprintf('SELECT t1.id, t1.username, t1.sha_pass_hash,  t2.gmlevel
                        FROM account t1 LEFT JOIN  account_access t2 ON t2.id= t1.id WHERE username = \'%s\'', $rdvs_user);
                }
		else{
                $query = sprintf('SELECT id, username, sha_pass_hash,  gmlevel FROM account WHERE username = \'%s\'', $rdvs_user);
                }

                $rdvs_query = mysql_query($query) or die(mysql_error());
                $rdvs_user_row = mysql_fetch_assoc($rdvs_query);
		// if password is right
		if(strtoupper($sha_pass_hash) == strtoupper($rdvs_user_row['sha_pass_hash']))
                {
                        $_SESSION['rdvs_accountid'] = $rdvs_user_row['id'];
			$_SESSION['rdvs_user'] = $rdvs_user_row['username'];
			
                        if(count($rdvs_user_row['gmlevel']) == 0)
                        {
                           $_SESSION['rdvs_rank'] = 0 ;
                        }
                         else
                             {
                                 $_SESSION['rdvs_rank'] = $rdvs_user_row['gmlevel'];
                             }
                        
			header("Location: ".$rdvs_page);
                 }
                else
		    {                   
                        if (!empty($rdvs_user_row['username']))
                        {

                            rdvs_error("User doesn't exist");
                        }

                        if (!empty($sha_pass_hash) || strtoupper($sha_pass_hash) !== strtoupper($rdvs_user_row['sha_pass_hash']))
                        {
                            rdvs_error("Wrong password");
                        }  
                    }
	}

	function logout() {
		global $rdvs_page;
		if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank'])) {

		unset($_SESSION['rdvs_user']);
		unset($_SESSION['rdvs_rank']); }

		header("Location: ".$rdvs_page);

	}

	function vote($siteid) {
		global $rdvs_mysql_db, $rdvs_mysql_logon_db, $rdvs_page, $rdvs_points;

		$this->connect("rdvs");

		$site = mysql_real_escape_string($siteid);
		$myip = $_SERVER['REMOTE_ADDR'];
		$time = time();
		$next = time()+60*60*12;
		$user = mysql_real_escape_string($_SESSION['rdvs_user']);

		$date = date("j-n-Y H:i");
		
		mysql_select_db($rdvs_mysql_db);

		$topsite_q = mysql_query("SELECT * FROM topsites WHERE id='$site'") or die(mysql_error());
		$topsite_row = mysql_fetch_assoc($topsite_q);
                if(isset($topsite_row['id'])) {
		$votelog_q = @mysql_query("SELECT * FROM votelog WHERE site='$site' AND ip='$myip' ORDER by time DESC limit 1");
		$votelog_row = @mysql_fetch_assoc($votelog_q);

		if(isset($votelog_row['id']) && $votelog_row['next'] >= $time) {
			die("You have already voted with in the last 12 hours. <a href=".$rdvs_page.">Go back!</a>"); }

		mysql_query("INSERT INTO votelog(`user`, site, ip, date, time, next) VALUES('$user', '$site', '$myip', '$date', '$time', '$next')");


		$this->connect("logon");

		mysql_select_db($rdvs_mysql_logon_db);

		$user_q = mysql_query("SELECT * FROM account WHERE username='$user'") or die(mysql_error());
		$user_row = mysql_fetch_assoc($user_q);

		$points = $user_row['votes'] + $rdvs_points;

		mysql_query("UPDATE account SET votes='$points' WHERE username='$user'");

		die('<script type="text/javascript">
					function redirect() {
				document.location = "'.$topsite_row['url'].'";
			}
			setTimeout("redirect()",1000);



			document.write("<span style=\'font-family:verdana;font-size:12px;\'>You are being redirected to the topsite...<br />If you don\'t get redirected, please click <a href=\''.$topsite_row['url'].'\'>here</a></span>");</script>'); }
	}

		function buy() {

		global $rdvs_mysql_db, $rdvs_mysql_logon_db, $rdvs_page, $rdvs_subject, $rdvs_body, $rdvs_core;
		$this->connect("logon");
		mysql_select_db($rdvs_mysql_logon_db);

		$id = mysql_real_escape_string($_SESSION['rdvs_accountid']);
                $query = sprintf('SELECT * FROM account WHERE id = \'%s\' ', $id);
		$user_q = mysql_query($query) or die(mysql_error());
		$user_r = mysql_fetch_assoc($user_q);
               
		$this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);
		$realmid = mysql_real_escape_string($_POST['realmid']);
		$itemid = mysql_real_escape_string($_POST['itemid']);
		$rewards_q = mysql_query("SELECT * FROM rewards WHERE itemid='$itemid' AND realm='$realmid'");
		$rewards_r = mysql_fetch_assoc($rewards_q);
		$characters = mysql_real_escape_string($_POST['characters']);
		if(!isset($rewards_r['itemid'])) { die("Invalid item id"); }
		if($rewards_r['cost'] > $user_r['votes']) { die("Not enough vote points"); }
                $description = $rewards_r['description'];
		$newvotes = $user_r['votes'] - $rewards_r['cost'];
                $this->connect("logon");
		mysql_select_db($rdvs_mysql_logon_db);
                $uquery = sprintf('UPDATE account SET votes = \'%s\' WHERE id = \'%s\'',$newvotes, $id);
		mysql_query($uquery)  or error("logon", mysql_error());

                $this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);
		$realm_q = mysql_query("SELECT * FROM realms WHERE id='$realmid'");
		$realm_r = mysql_fetch_assoc($realm_q);

		mysql_select_db($rdvs_mysql_db);
		$myip = $_SERVER['REMOTE_ADDR'];
		$date = date("j-n-Y");
		$time = date("H:i");
                $user = $user_r['username'];
		mysql_query("INSERT INTO shoplog(`user`, `character`, `ip`, `itemid`, `date`, `time`, `realm`) VALUES('$user', '$characters', '$myip', '$itemid', '$date', '$time', '$realmid')") or die(mysql_error());

		if(!isset($realm_r['id'])) { die("Invalid realm id"); }

		$char_con = mysql_connect($realm_r['host'], $realm_r['user'], $realm_r['pass']) or die(mysql_error().'<br /><br />Before asking for support, just read the error. Please.');

		mysql_select_db($realm_r['chardb']);

		$char_q = mysql_query("SELECT account, guid, name FROM characters WHERE account = '$characters'") or die(mysql_error());
		$char_r = mysql_fetch_assoc($char_q);
                
                $instance = mysql_query('SELECT guid FROM item_instance ORDER BY guid DESC') or die(mysql_error());
		$item_instanceid = mysql_fetch_assoc($instance);
                $item_guid = $item_instanceid['guid'] +1;
                
                if($rdvs_core == 1){
             
                $item_instance = sprintf('INSERT INTO item_instance
                (`guid`, `itemEntry`, `owner_guid`, `creatorGuid`, `giftCreatorGuid`,
                `count`, `duration`, `charges`, `flags`, `enchantments`, `randomPropertyId`, `durability`, `playedTime`, `text`)
                VALUES (\'%s\', \'%s\', \'%s\', 0, 0, \'%s\', 0, \'0 0 0 0 0\', 0,
                \'0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0\', 0, 0, 0, NULL)',$item_guid, $itemid, $characters, $description);
                
                }
                else 
                    {

                    $item_instance = sprintf(
                    'INSERT INTO `item_instance` (`guid`, `owner_guid`, `data`, `text`)
                    VALUES (\'%s\', \'%s\', \'%s 1191182336 3 %s 1065353216 0 %s 0 0 0 0 0 0 0 %s 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 20 20 0 0 \', \'\');
                    ',$item_guid, $characters, $item_guid, $itemid, $characters, $description);
                    
                    }
                mysql_query($item_instance);
                $mail_id = mysql_query('SELECT id FROM mail ORDER BY id DESC') or error("logon", mysql_error());
		$mailid = mysql_fetch_assoc($mail_id) ;

                $id_mail = $mailid['id'] + 1;
                $time = time();

                if($rdvs_core == 1)
                {
 
                $mail_items = sprintf('INSERT INTO `mail_items`(`mail_id`, `item_guid`, `receiver`)
                VALUES (\'%s\', \'%s\', \'%s\')', $id_mail, $item_guid, $characters);
                 }
                 else{
                      $mail_items = sprintf('INSERT INTO `mail_items` (`mail_id`, `item_guid`, `item_template`, `receiver`)
                VALUES (\'%s\', \'%s\', \'%s\', \'%s\')', $id_mail, $item_guid, $itemid, $characters);
                 }
                mysql_query($mail_items);

                $mail = sprintf('INSERT INTO mail (`id`, `messageType`, `stationery`, `mailTemplateId`, `sender`, `receiver`, `subject`, `body`, `has_items`, `expire_time`, `deliver_time`, `money`, `cod`, `checked`)
                VALUES (\'%s\', 0, 61, 0, \'%s\', \'%s\', \'%s\', \'%s\', 1, 0, \'%s\', 0, 0, 16)',$id_mail, $characters, $characters, $rdvs_subject, $rdvs_body, $time);
                mysql_query($mail) or error("logon", mysql_error());

                header("Location: ".$rdvs_page);

		}

		function in_link_redirect($action) {
		global $rdvs_page_extra;


			if (strpos($rdvs_page_extra, '?') !== false) {
				header("Location: ".$rdvs_page_extra."&".$action);
			} else {
				header("Location: ?".$action);
			} }

		function delete($x) {
			global $rdvs_mysql_db;
			$this->connect("rdvs");
			mysql_select_db($rdvs_mysql_db);

			switch($x) {

			case "reward":
			$deletereward = mysql_real_escape_string($_POST['deletereward']);
			mysql_query("DELETE FROM rewards WHERE id='$deletereward'") or die(mysql_error());
			break;

			case "topsite":
			$deletetopsite = mysql_real_escape_string($_POST['deletetopsite']);
			mysql_query("DELETE FROM topsites WHERE id='$deletetopsite'") or die(mysql_error());
			break;

			case "realm":
			$deleterealm = mysql_real_escape_string($_POST['deleterealm']);
			mysql_query("DELETE FROM realms WHERE id='$deleterealm'") or die(mysql_error());

			break;

			$this->in_link_redirect("rdvs=acp");

			}

		}

		function insert($x) {
			global $rdvs_mysql_db;
			$this->connect("rdvs");
			mysql_select_db($rdvs_mysql_db);

			switch($x) {

			case "reward":
			if(!empty($_POST['additemid'])) {
			$additemid = mysql_real_escape_string($_POST['additemid']); } else { $additemid = 123; }
			$additemname = mysql_real_escape_string($_POST['additemname']);
			$additemdesc = mysql_real_escape_string($_POST['additemdesc']);
			if(!empty($_POST['additemcost'])) {
			$additemcost = mysql_real_escape_string($_POST['additemcost']); } else { $additemcost = 123; }
			$additemcolor = mysql_real_escape_string($_POST['additemcolor']);
			$additemrealm = mysql_real_escape_string($_POST['additemrealm']);
			if(!empty($_POST['additemheadline'])) {
			$additemheadline = mysql_real_escape_string($_POST['additemheadline']); } else { $additemheadline = 0; }

			mysql_query("INSERT INTO rewards(itemid, name, description, cost, color, realm, headline) VALUES('$additemid', '$additemname', '$additemdesc', '$additemcost', '$additemcolor', '$additemrealm', '$additemheadline')") or die(mysql_error());
			break;

			case "topsite":


			$addtopsitename = mysql_real_escape_string($_POST['addtopsitename']);
			$addtopsiteurl = mysql_real_escape_string($_POST['addtopsiteurl']);

			mysql_query("INSERT INTO topsites(name, url) VALUES('$addtopsitename', '$addtopsiteurl')") or die(mysql_error());
			break;

			case "realm":

			$addrealmname = mysql_real_escape_string($_POST['addrealmname']);
			$addrealmhost = mysql_real_escape_string($_POST['addrealmhost']);
			$addrealmuser = mysql_real_escape_string($_POST['addrealmuser']);
			$addrealmpass = mysql_real_escape_string($_POST['addrealmpass']);
			$addrealmchardb = mysql_real_escape_string($_POST['addrealmchardb']);

			mysql_query("INSERT INTO realms(name, `host`, `user`, pass, chardb) VALUES('$addrealmname', '$addrealmhost', '$addrealmuser', '$addrealmpass', '$addrealmchardb')") or die(mysql_error());

			break;

			$this->in_link_redirect("rdvs=acp");

			}

		}

}
?>