<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<?php echo $this->Html->css('dreamcms.css'); ?>

	<!-- Include external files and scripts here (See HTML helper for more info.) -->	
	<?php echo $this->Html->script('DD_roundies_0.0.2a-min'); ?> 
	<script language="javascript" type="text/javascript">
			DD_roundies.addRule('#login',  '20px', true);
	</script>	
</head>
<body>
	<!-- If you'd like some sort of menu to show up on all of your views, include it here -->
	<div id="header">    
		<div id="menu"></div>
		<?php
			if (strlen($session->read('Auth.User.username'))>0) {
		?>
			<div id="mast">    
				<?php echo "Welcome <b>".$session->read('Auth.User.username')."</b>"; ?>    
				<?php echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
			</div>
		<?php } ?>
	</div>
	
	<!-- Here's where I want my views to be displayed -->
	<?php echo $content_for_layout ?> 
</div>
</body>
</html>