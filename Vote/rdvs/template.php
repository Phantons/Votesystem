<?php if(!isset($rdvs_x)) { die(); }?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php  echo $rdvs_site_title; ?></title>
<link rel="stylesheet" href="<?php echo $rdvs_stylesheet; ?>" type="text/css"/>
<?php if(isset($rdvs_state) && $rdvs_state==3 && isset($rdvs_tooltip) && $rdvs_tooltip==1) { ?>
<script src="http://static.wowhead.com/widgets/power.js"></script><?php } ?>
</head>

<body>


<div class="rdvs">
  <fieldset>
    <legend><?php echo $rdvs->title(); ?></legend>
    <?php echo $rdvs->content(); ?>
    
  </fieldset>
  <div class="rdvsfooter"><?php echo $rdvs->footer(); ?></div>
</div>


</body>
</html>