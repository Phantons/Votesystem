<?php
/*--------------------------------*\
| RaxeZDev Vote System - by DataBase/Jesper | 
| Website: www.RaxeZDev.info/www.hammer-wow.com       |
| Copyright 2010                   |
\*--------------------------------*/
if(!isset($rdvs_x)) { die(); }

// if login form submitted
if(isset($_POST['rdvs_user']) && isset($_POST['rdvs_sha_pass_hash'])) { $actions->login(); }

// if ?rdvs=logout
if(isset($_GET['rdvs']) && $_GET['rdvs']=="logout") { $actions->logout(); }

// if logged in and ?rdvs is either not set or =vote
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) && !isset($_GET['rdvs'])) { $rdvs_state = 1;}
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) && isset($_GET['rdvs']) && $_GET['rdvs']=="vote") { $rdvs_state = 1;}

// if ?rdvs=shop
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) && isset($_GET['rdvs']) && $_GET['rdvs']=="shop" && !isset($_GET['realm'])) { $rdvs_state = 2;}

// if ?rdvs=shop&realm=x
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) && isset($_GET['rdvs']) && $_GET['rdvs']=="shop" && isset($_POST['realm'])) { $rdvs_state = 3;}

// if ?rdvs=buy&item=x&realm=x
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) && isset($_GET['rdvs']) && $_GET['rdvs']=="buy" && isset($_GET['item']) && isset($_GET['realm'])) { $rdvs_state = 4;}

// if ?rdvs=buyitem
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) && isset($_GET['rdvs']) && $_GET['rdvs']=="buyitem" && isset($_POST['itemid']) && isset($_POST['realmid']) && isset($_POST['characters'])) {$actions->buy(); }

// if ?rdvs=vote&id=x
if(isset($_GET['rdvs']) && $_GET['rdvs']=="vote" && isset($_GET['id'])) { $actions->vote($_GET['id']); }

// if ?rdvs=acp and rank = az
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) &&  $_SESSION['rdvs_rank']== $rdvs_access && isset($_GET['rdvs']) && $_GET['rdvs']=="acp") { $rdvs_state = 5;}

// if ?rdvs=acp and rank = az and delete- form submitted
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) &&  $_SESSION['rdvs_rank']== $rdvs_access && isset($_GET['rdvs']) && $_GET['rdvs']=="acp" && isset($_POST['deletereward'])) { $actions->delete("reward"); }
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) &&  $_SESSION['rdvs_rank']== $rdvs_access && isset($_GET['rdvs']) && $_GET['rdvs']=="acp" && isset($_POST['deleterealm'])) { $actions->delete("realm"); }
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) &&  $_SESSION['rdvs_rank']== $rdvs_access && isset($_GET['rdvs']) && $_GET['rdvs']=="acp" && isset($_POST['deletetopsite'])) { $actions->delete("topsite"); }

// if ?rdvs=acp and rank = az and add- form submitted
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) &&  $_SESSION['rdvs_rank']== $rdvs_access && isset($_GET['rdvs']) && $_GET['rdvs']=="acp" && isset($_POST['additemname'])) { $actions->insert("reward"); }
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) &&  $_SESSION['rdvs_rank']== $rdvs_access && isset($_GET['rdvs']) && $_GET['rdvs']=="acp" && isset($_POST['addrealmname'])) { $actions->insert("realm"); }
if(isset($_SESSION['rdvs_user']) && isset($_SESSION['rdvs_rank']) &&  $_SESSION['rdvs_rank']== $rdvs_access && isset($_GET['rdvs']) && $_GET['rdvs']=="acp" && isset($_POST['addtopsitename'])) { $actions->insert("topsite"); }
?>