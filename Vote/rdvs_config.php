<?php
/*--------------------------------*\
| RaxeZDev Vote System - by DataBase/Jesper | 
| Website: www.RaxeZDev.info/www.hammer-wow.com      |
| Copyright 2010                   |
\*--------------------------------*/

// mysql
$rdvs_mysql_logon_host = "127.0.0.1"; // MySQL server containing the logon database
$rdvs_mysql_logon_user = "root"; // MySQL username for logon host
$rdvs_mysql_logon_pass = "root"; // MySQL passowrd for logon host
$rdvs_mysql_logon_db = "realmd"; // MySQL logon database

$rdvs_mysql_host = "127.0.0.1"; // MySQL server containing the RDVS database
$rdvs_mysql_user = "root"; // MySQL username for RDVS host
$rdvs_mysql_pass = "root"; // MySQL passowrd for RDVS host
$rdvs_mysql_db = "db_vote"; // MySQL RDVS database

// styles
$rdvs_stylesheet = "rdvs/style.php"; // Stylesheet file - no need to change as default
$rdvs_bg_image = "../rdvs_img/backgrounds/lichking.jpg"; // Background image (linking from the css folder, example: "../img/backgrounds/bg1.jpg")
$rdvs_bg_repeat = "repeat"; // Background repeat: no-repeat, repeat, repeat-x, repeat-y
$rdvs_bg_color = "#000"; // Background color
$rdvs_text_color = "#B2B2B2"; // Text color
$rdvs_fieldset_border = "1px solid #ccc"; // Fieldset border
$rdvs_link_color = "#B2B2B2"; // Link color
$rdvs_link_decoration = "none"; // Link text-decoration (underline, none etc. )
$rdvs_link_color_hover = "#B2B2B2"; // (on mouse over) Link color
$rdvs_link_decoration_hover = "underline"; // (on mouse over) Link text-decoration (underline, none etc. )

// misc
$rdvs_site_title = "Test"; // Site title
$rdvs_form_action = "index.php"; // Form action, index file - No need to change as default
$rdvs_page = "index.php"; // The file
$rdvs_page_extra = ""; // [Only for intergration] If you use any kind of $_GET script for paging, type the site adress here (Example; ?page=vote etc.)
$rdvs_points = 1; // Point per vote
$rdvs_tooltip = 1; // Wowhead tooltip, only for retail items [1 = yes, 0 = no]
$rdvs_access = 3; // GM stufe um in den adminpereich zu kommen
$rdvs_core = 1; // 0 = Mangos oder 1 = TrinityCore
// reward mail
$rdvs_subject = "Vote reward"; // Reward mail subject
$rdvs_body = "Vielen Dank für die unterstützung"; // Reward mail body

// ignore
$rdvs_x = "x";
?>