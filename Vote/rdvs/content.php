<?php
/*--------------------------------*\
| RaxeZDev Vote System - by DataBase/Jesper | 
| Website: www.RaxeZDev.info/www.hammer-wow.com       |
| Copyright 2010                   |
\*--------------------------------*/
if(!isset($rdvs_x)) { die(); }

class rdvs extends mysql {
	
	function title() {
		// title handler
		global $rdvs_state;
		
		switch($rdvs_state) {
			default:
				$title = "Please username!";
			break;
		case 1:
		$title = "Welcome, ".$_SESSION['rdvs_user']."!";
		break;
		
		case 2:
		$title = "Realm selection";
		break;
		
		case 3:

		global $rdvs_mysql_db;
		$this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);
		
		$realmid = mysql_real_escape_string($_POST['realm']);
		
		$q = @mysql_query("SELECT name, id FROM realms WHERE id='$realmid'");
		$r = @mysql_fetch_assoc($q);
		if(!isset($r['id'])) { die("Invalid realm id"); }
		
		$realm = $r['name'];
		
		$title = "Reward shop - ".$realm;
		break;
		
		case 4:
			
			$title = "Buy item";
		break;
		
		case 5:
			$title = "Admin panel";
		break;
		
		}
		
                return " ".$title;
		
		
	}
	
	function content() {
		// content handler
		global $rdvs_state;
		
		switch($rdvs_state) {
			
			default:
				return $this->login();
			break;
			
			case 1:
				return $this->ucp();
			break;
			
			case 2:
				return $this->realms();
			break;
			
			case 3:
				return $this->shop();
			break;
			
			case 4:
				return $this->selectchar();
			break;
			
			case 5:
				return $this->acp();
			break;

		}
		
		
		
		
	}
	
	function acp() {
	global $rdvs_mysql_db;
	$this->connect("rdvs");
	mysql_select_db($rdvs_mysql_db);
	
	$rewards_q = mysql_query("SELECT * FROM rewards ORDER by realm ASC");
	$rewards = mysql_fetch_assoc($rewards_q);
	
	$rewards_q2 = mysql_query("SELECT * FROM realms ORDER by id ASC");
	$rewards_r = mysql_fetch_assoc($rewards_q2);
	$string ='';
	$string .= '<form action="';
	$string .= $this->form_action("rdvs=acp");
	$string .= '" method="post">
	Delete reward:
	<select name="deletereward">';
	if(isset($rewards['id'])) {
	do {
		if($rewards['headline']=='1') { $string .=  '<option value="'.$rewards['id'].'">Headline: '.$rewards['name'].' @ Realm: '.$rewards['realm'].'</option>'; } else {
		$string .= '<option value="'.$rewards['id'].'">'.$rewards['name'].' @ Realm: '.$rewards['realm'].'</option>'; }
	} while ($rewards = mysql_fetch_assoc($rewards_q)); } else { $string .=  "<option>No rewards in database</option>"; }
	
	$string .= '</select> <input type="submit" value="Delete!"/></form>';
	
	$string .= '<br /><form action="';
	$string .= $this->form_action("rdvs=acp");
	$string .= '" method="post">
    Add reward:<br /><br />
	* = required for headline<br /><br />
	<input type="text" name="additemid" value="Item id"/><br /><br />
	* <input type="text" name="additemname" value="Item/headline name"/><br /><br />
	<input type="text" name="additemdesc" value="Description"/><br /><br />
	<input type="text" name="additemcost" value="Item cost"/><br /><br />
	<select name="additemcolor">
	<option value="0">-- Item color --</option>
	<option value="0">Poor (gray)</option>
	<option value="1">Common (white)</option>
	<option value="2">Uncommon (green)</option>
	<option value="3">Rare (blue)</option>
	<option value="4">Epic (purple)</option>
	<option value="5">Legendary (orange)</option>
	<option value="6">Artifact (beige)</option>
	<option value="7">Heirloom (beige)</option>
	</select><br /><br />
	* <select name="additemrealm">
	<option>-- Realm --</option>';
	
	if(isset($rewards_r['id'])) {
	do {
		
		$string .= '<option value="'.$rewards_r['id'].'">'.$rewards_r['name'].'</option>';
	} while ($rewards_r = mysql_fetch_assoc($rewards_q2)); } else { $string .=  "<option>No realms in database</option>"; }
	
	$string .= '</select><br /><br />
	Headline <input type="checkbox" name="additemheadline" value="1"/><br /><br />
	<input type="submit" value="Add item!"/>
	
	</form><br /><hr /><br /><br />';
	
	$realms_q = mysql_query("SELECT * FROM realms ORDER by id ASC");
	$realms = mysql_fetch_assoc($realms_q);
		
	$string .= '<form action="';
	$string .= $this->form_action("rdvs=acp");
	$string .= '" method="post">
	Delete realm:
	<select name="deleterealm">';
	if(isset($realms['id'])) {
	do {
		
		$string .=  '<option value="'.$realms['id'].'">'.$realms['name'].'</option>';
	} while ($realms = mysql_fetch_assoc($realms_q)); } else { $string .= "<option>No realms in database</option>"; }
	
	$string .= '</select> <input type="submit" value="Delete!"/></form>';
	
	
	$string .= '<br /><form action="';
	$string .= $this->form_action("rdvs=acp");
	$string .= '" method="post">
    Add realm:<br /><br />
	
	<input type="text" name="addrealmname" value="Name"/><br /><br />
	<input type="text" name="addrealmhost" value="MySQL host"/><br /><br />(If you\'re using another port than 3306, please write host:port, example: 127.0.0.1:3307)<br /><br />
	<input type="text" name="addrealmuser" value="MySQL username"/><br /><br />
	<input type="text" name="addrealmpass" value="MySQL password"/><br /><br />
	<input type="text" name="addrealmchardb" value="Characters database"/><br /><br />
	<input type="submit" value="Add realm!"/>
	
	</form><br /><hr /><br /><br />';
	
	
	
	$topsites_q = mysql_query("SELECT * FROM topsites ORDER by id ASC");
	$topsites = mysql_fetch_assoc($topsites_q);
		
	$string .= '<form action="';
	$string .= $this->form_action("rdvs=acp");
	$string .= '" method="post">
	Delete topsite:
	<select name="deletetopsite">';
	if(isset($topsites['id'])) {
	do {
		
		$string .= '<option value="'.$topsites['id'].'">'.$topsites['name'].'</option>';
	} while ($topsites = mysql_fetch_assoc($topsites_q)); } else { $string .=  "<option>No topsites in database</option>"; }
	
	$string .= '</select> <input type="submit" value="Delete!"/></form>';
	
	
	$string .= '<br /><form action="';
	$this->form_action("rdvs=acp");
	$string .= '" method="post">
    Add topsite:<br /><br />
	
	<input type="text" name="addtopsitename" value="Topsite name"/><br /><br />
	<input type="text" name="addtopsiteurl" value="http://Topsite URL"/><br /><br />
	<input type="submit" value="Add topsite!"/>
	
	</form>';
	
        return $string;
	}
	
	function selectchar() {
		global $rdvs_mysql_db, $rdvs_mysql_logon_db;
		$this->connect("logon");
		mysql_select_db($rdvs_mysql_logon_db);

                $id = mysql_real_escape_string($_SESSION['rdvs_accountid']);
                $query = sprintf('SELECT * FROM account WHERE id = \'%s\' ', $id);
		$user_q = mysql_query($query);
                $user_r = mysql_fetch_assoc($user_q);

		$this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);

		$realmid = mysql_real_escape_string($_GET['realm']);
		$itemid = mysql_real_escape_string($_GET['item']);
		$rewards_q = mysql_query("SELECT * FROM rewards WHERE itemid='$itemid' AND realm='$realmid'");
		$rewards_r = mysql_fetch_assoc($rewards_q);
		
		if(!isset($rewards_r['itemid'])) { die("Invalid item id"); }
		if($rewards_r['cost'] > $user_r['votes']) { die("Not enough vote points"); }
		
		
		$realm_q = mysql_query("SELECT * FROM realms WHERE id='$realmid'");
		$realm_r = mysql_fetch_assoc($realm_q);
		
		if(!isset($realm_r['id'])) { die("Invalid realm id"); }
		
		$char_con = mysql_connect($realm_r['host'], $realm_r['user'], $realm_r['pass']) or die(mysql_error().'<br /><br />Before asking for support, just read the error. Please.');
		
		mysql_select_db($realm_r['chardb']);
		$accountid_r = mysql_real_escape_string($_SESSION['rdvs_accountid']);
		$char_query =sprintf('SELECT SQL_CALC_FOUND_ROWS guid, name FROM characters WHERE account = \'%s\'', $accountid_r);
                $char_q = mysql_query($char_query) or error("realm", mysql_error());
		$count =  mysql_query("SELECT FOUND_ROWS()") or error("realm", mysql_error());
                $zeilen = mysql_fetch_row($count);
            
		if($zeilen[0] > 0){

                $string ='';
                $string .= '
		<form action="'.''.
		$this->form_action("rdvs=buyitem");
		$string .='" method="post">';
		
		$string .= 'Select characters:
		<select name="characters">';

                while($array = mysql_fetch_assoc($char_q))
	        {
                    
		   $string .= sprintf("<option value=\"%s\">%s</option>", $array['guid'], $array['name']);
                  
		
		}
		
		$string .= '
		<input type="hidden" name="itemid" value="'.$itemid.'"/>
		<input type="hidden" name="realmid" value="'.$realmid.'"/>
		<input type="submit" value="Go!"/></select></form>';

                }
                else
                    {
                    return "You have no characters";
                }


         return $string;
	}
	
	function alreadyvoted($siteid) {
		
		global $rdvs_mysql_db;
		$this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);
		
		$myip = $_SERVER['REMOTE_ADDR'];
		
		$rdvs_q = mysql_query("SELECT * FROM votelog WHERE site='$siteid' AND ip='$myip' ORDER by time DESC limit 1");
		$rdvs_votelog = mysql_fetch_assoc($rdvs_q);
		$time = time();
		
	
	if(isset($rdvs_votelog['id']) && $rdvs_votelog['next'] >= $time) { return '<img src="rdvs_img/voted.png" align="absmiddle"/> <span style="color:green">Voted!</span>'; } else {
	$string = '<img src="rdvs_img/votenow.png" align="absmiddle" /> '.''
        .$this->in_link_vote("rdvs=vote&id=".$siteid, 'Vote now!'); }
			
        return $string;
		
	}
	
	function shop() {
		global $rdvs_mysql_db, $rdvs_mysql_logon_db;
 
		$string ='';
		$string .= '['.$this->in_link("rdvs=shop", "Realm selection").' ]<br /><br />';

		$this->connect("logon");
		
		mysql_select_db($rdvs_mysql_logon_db);
		
		$_SESSION['rdvs_user'] = mysql_real_escape_string($_SESSION['rdvs_user']);
		
		$rdvs_q = mysql_query("SELECT username, votes FROM account WHERE username = '$_SESSION[rdvs_user]'") or error("logon", mysql_error());
		$rdvs_user = mysql_fetch_assoc($rdvs_q);
		
		$string .= 'Vote points: '.$rdvs_user['votes'].' <img src="rdvs_img/coins.png" /><br /><br />';
		
		$this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);
		$realmid = mysql_real_escape_string($_POST['realm']);
		
		$rewards_q = mysql_query("SELECT * FROM rewards WHERE realm='$realmid' ORDER by id ASC");
		$rewards_r = mysql_fetch_assoc($rewards_q);
		
	
		if(isset($rewards_r['id'])) {
 
    
 do {
	 if($rewards_r['headline']=='1') { $string .= '<div style="padding:5px;font-weight:bold;">'.$rewards_r['name'].'</div>'; } else {
	$string .= '<div class="rdvsreward"><div class="rdvsbuy">';
  if($rdvs_user['votes']>=$rewards_r['cost']) { $string .= $this->canbuy($rewards_r['itemid'], $rewards_r['realm']); } else { $string .= '<img src="rdvs_img/error.png" alt="You need more vote points" align="absbottom" />'; }
   $string .= '</div><a class="q'.$rewards_r['color'].'" href="http://www.wowhead.com/?item='.$rewards_r['itemid'].'" target="_blank">'.$rewards_r['name'].'</a>'; $string .=  '<div class="rdvscost">'.$rewards_r['cost'].' <img src="rdvs_img/coins.png" /></div><div class="rdvsdesc">'.$rewards_r['description'].'</div></div>'; }
   } while($rewards_r = mysql_fetch_assoc($rewards_q));

	

    } else { $string .=  '<span style="color:red">No rewards in database</span>'; }
		
	
        return $string;
        }
	
	
	
	function realms() {
				global $rdvs_form_action, $rdvs_page_extra, $rdvs_mysql_db;
		
		$this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);
		
		$rdvs_q = mysql_query("SELECT * FROM realms ORDER BY id ASC") or error("rdvs", mysql_error());
		$rdvs_row = mysql_fetch_assoc($rdvs_q);
		
		
		
		$string =  '
		<form action="';
		$this->form_action("rdvs=shop");
		$string .=  '" method="post">
		
		Select realm: 
		<select name="realm">';
		if(isset($rdvs_row['id'])) {
		do {
		$string .=  '<option value="'.$rdvs_row['id'].'">'.$rdvs_row['name'].'</option>';
		
		} while($rdvs_row = mysql_fetch_assoc($rdvs_q)); } 
		else { $string .=  "<option>No realms in database</option>"; }
		

		$string .=  '<input type="submit" value="Go!"/></select>
		</form>';
        return $string;
	}
	
	function login() {
	    // The login form
		global $rdvs_form_action;

		$string = sprintf('
		<form action="%s" method="post">
	
		<table align="center" cellpadding="2">
		<tr>
		<td><label for="rdvs_user">Username:</label></td>
		<td><input type="text" name="rdvs_user" style="width:130px;"/></td>
		</tr>
		<tr>
		<td><label for="rdvs_pass">Password:</label></td>
		<td><input type="password" name="rdvs_sha_pass_hash" style="width:130px;" /></td>
		</tr>
		</table>
		<input type="submit" value="Einloggen"/>
		
		</form>
		', $rdvs_form_action);

          return $string;
	}
	
	function ucp() {
		global $rdvs_mysql_logon_db, $rdvs_page, $rdvs_core;
		$this->connect("logon");
		mysql_select_db($rdvs_mysql_logon_db);
		$_SESSION['rdvs_user'] = mysql_real_escape_string($_SESSION['rdvs_user']);

                if($rdvs_core == 1){
                    $query = sprintf('SELECT t1.id, t1.username, t1.sha_pass_hash, t1.votes, t2.gmlevel
                        FROM account t1 LEFT JOIN  account_access t2 ON t2.id= t1.id WHERE username = \'%s\'', $_SESSION['rdvs_user']);
                }
		else{
                $query = sprintf('SELECT id, username, sha_pass_hash,  gmlevel, votes FROM account WHERE username = \'%s\'', $_SESSION['rdvs_user']);
                }
                $rdvs_q = mysql_query($query) or error("logon", mysql_error());
		$rdvs_user = mysql_fetch_assoc($rdvs_q);
		$string = '';
                $string .= sprintf("Vote points: %s <img src=\"rdvs_img/coins.png\" /><br /><br />", $rdvs_user['votes']);
		$string .= $this->vote();
		$string .= sprintf('<br />[ <a href="%s">Refresh</a> ]', $rdvs_page);
                

        return $string;
	}
	
	function vote() {
		global $rdvs_mysql_db;
		$this->connect("rdvs");
		mysql_select_db($rdvs_mysql_db);
		
		$rdvs_q = mysql_query("SELECT * FROM topsites ORDER BY id ASC") or error("Other", mysql_error());
		$rdvs_topsite_row = mysql_fetch_assoc($rdvs_q);
             $string ='';
             $condent ='';
              if(isset($rdvs_topsite_row['id'])) {

             
             do
              {
                $condent .= sprintf('<tr><td align="right">%s</td>
                <td align="left">&nbsp; %s</td>
              </tr>', $rdvs_topsite_row['name'], $this->alreadyvoted($rdvs_topsite_row['id']));
             } while($rdvs_topsite_row = mysql_fetch_assoc($rdvs_q));
              
              $string .= '<table border="0" align="center" cellpadding="0" cellspacing="3">';
              $string .= $condent;
              $string .= '</table>';
            } else { return '<span style="color:red">No topsites in database</span>'; }

       
        return $string;
	}
	
	function in_link($action, $text) {
		global $rdvs_page_extra;
		
		
			if (strpos($rdvs_page_extra, '?') !== false) {
				
				return sprintf("<a href=\"%s&%s\">%s</a>",$rdvs_page_extra, $action, $text);
			} else {
				return sprintf("<a href=\"?%s\">%s</a>",$action, $text);
			}

        }
			
	function in_link_vote($action, $text) {
		global $rdvs_page_extra;
		
		
			if (strpos($rdvs_page_extra, '?') !== false) {
				
				return sprintf("<a href=\"%s&%s\" target=\"_NEW\" >%s</a>",$rdvs_page_extra, $action, $text);
			} else {
				return sprintf("<a href=\"?%s\" target=\"_NEW\" >%s</a>",$action, $text);
			}

         }
			
        function form_action($action) {
		global $rdvs_page_extra;
		
		
			if (strpos($rdvs_page_extra, '?') !== false) {
				return $rdvs_page_extra.'&'.$action;
			} else {
				return '?'.$action;
			}
         }
			
	function in_link_redirect($action) {
		global $rdvs_page_extra;
		
		
            if (strpos($rdvs_page_extra, '?') !== false) {
		header("Location: ".$rdvs_page_extra."&".$action);
            } else {
                    header("Location: ?".$action);
		   }

         }
		
		
	function canbuy($action, $realm) {
		global $rdvs_page_extra;
		
	
		
	if (strpos($rdvs_page_extra, '?') !== false) {
		return '<a href="'.$rdvs_page_extra.'&rdvs=buy&item='.$action.'&realm='.$realm.'" ><img src="rdvs_img/cart.png" alt="Buy item" style="border:none;"/></a>';
	} else {
		return '<a href="?rdvs=buy&item='.$action.'&realm='.$realm.'" ><img src="rdvs_img/cart.png" alt="Buy item" align="absbottom" style="border:none;"/></a>';
               }

         }
		

	
	function credits() {
		global $rdvs_text_color;
		return '<br /><br /><a href="" target="_blank" style="color:'.$rdvs_text_color.'"></a>';
		
	}
	
	



	function footer() {
		global $rdvs_state, $rdvs_access ;
		
		switch($rdvs_state) {
		
		
		
		case 1:
		       $string ='';
                       $string .= 'Vote now'.''
                                .'| '.''
		       .$this->in_link("rdvs=shop", "Reward shop").''
                        .'| '.''
                       .$this->in_link("rdvs=logout", "Logout!");
                       $stringdo ='';
			if($_SESSION['rdvs_rank']== $rdvs_access ) {
			$stringdo .= ' | '

			.$this->in_link("rdvs=acp", "Admin panel");
			}
			
		break;
		
		case 2:
                        $string ='';
                        $string .=
			$this->in_link("rdvs=vote", "Vote now");
			$string .=' | ';
			$string .= 'Reward shop';
			$string .= '| ';
                        $string .=
			$this->in_link("rdvs=logout", "Logout!");
			
			if($_SESSION['rdvs_rank']==$rdvs_access ) {
			$string .=' | ';
                        $string .=
			$this->in_link("rdvs=acp", "Admin panel");	
			}
                        
			
		break;
		
		case 3:
                        $string ='';
                        $string .=
			$this->in_link("rdvs=vote", "Vote now");
			$string .='| ';
			$string .='Reward shop';
			$string .=' | ';
                        $string .=
			$this->in_link("rdvs=logout", "Logout!");
			
			if($_SESSION['rdvs_rank']==$rdvs_access ) {
			$string .=' | ';
                        $string .=
			$this->in_link("rdvs=acp", "Admin panel");	
			}
                       
			
		break;
		
		case 4:
                        $string ='';
                        $string .=
			$this->in_link("rdvs=vote", "Vote now");
			$string .='| ';
                        $string .=
			$this->in_link("rdvs=shop", "Reward shop");
			$string .=' | ';
                        $string .=
			$this->in_link("rdvs=logout", "Logout!");
			
			if($_SESSION['rdvs_rank']==$rdvs_access ) {
			$string .=' | ';
                        $string .=
			$this->in_link("rdvs=acp", "Admin panel");	
			}
			
		break;
		
		case 5:
                        $string ='';
                        $string .=
			$this->in_link("rdvs=vote", "Vote now");
			$string .=' | ';
                        $string .=
			$this->in_link("rdvs=shop", "Reward shop");
			$string .= '| ';
                        $string .=
			$this->in_link("rdvs=logout", "Logout!");
			
			if($_SESSION['rdvs_rank']==$rdvs_access ) {
			$string .=' | ';
			$string .= 'Admin panel';
			}
			$string .='';
		break;
                default:
			$string = "Login";
		break;
		
		}
		
		$string .= $this->credits();
         
       return $string;
	}
}


function rdvs_error($rdvs_error) {
	
	if(isset($rdvs_error)) {
						 
	return '<script type="text/javascript">alert("Error: '.$rdvs_error.'");</script>';
						 
	}  
				 
	

				 
}


?>