<?php 
/*--------------------------------*\
| RaxeZDev Vote System - by DataBase/Jesper | 
| Website: www.RaxeZDev.info/www.hammer-wow.com       |
| Copyright 2010                   |
\*--------------------------------*/

header("Content-type: text/css"); 
require("../rdvs_config.php");
?>
@charset "utf-8";

/* basic layout, body tags etc. */

body {
	background-color:<?php echo $rdvs_bg_color; ?>;
	background-image:url(<?php echo $rdvs_bg_image; ?>);
	background-repeat:<?php echo $rdvs_bg_repeat; ?>;
	background-position:top;
	font-family:verdana;
	font-size:12px;
	color:<?php echo $rdvs_text_color; ?>;
}

a {
	color:<?php echo $rdvs_link_color; ?>;
	text-decoration:<?php echo $rdvs_link_decoration; ?>;
}

a:hover {
	color:<?php echo $rdvs_link_color_hover; ?>;
	text-decoration:<?php echo $rdvs_link_decoration_hover; ?>;
}

.rdvs {
	position:absolute;
	width:400px;
	height:auto;
	text-align:center;
	font-family:verdana;
	font-size:12px;
    z-index:10;
	left: 50%;
    margin-left: -200px;
}

fieldset {
    padding:8px;
    border:<?php echo $rdvs_fieldset_border; ?>;
}

legend {
	color:<?php echo $rdvs_text_color; ?>;
}

.rdvsfooter {
	text-align:center;
    font-size:11px;
    margin-top:10px;
	margin-bottom:10px;
}

.rdvsreward {
    margin-left:auto;
    margin-right:auto;
	width:600px;
    text-align:left;
  	font-weight:bold;
    margin-bottom:20px;
	padding:8px;
}
.rdvsbuy {
	width:20px;
    float:left;
    margin-right:10px;

}
.rdvscost {
	width:50px;
    float:right;
    margin-left:10px;
    font-weight:normal;
}

.rdvsdesc {
	height:auto;
    font-size:10px;
    font-weight:normal;

}

/*
input[type="text"], input[type="password"] {
    form styles here
}
*/