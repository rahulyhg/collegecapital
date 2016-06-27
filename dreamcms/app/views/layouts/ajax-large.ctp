<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <?php echo $this->Html->css('ajax.css'); ?>
	<?php echo $this->Html->css('datePicker.css'); ?>
	<!-- Include external files and scripts here (See HTML helper for more info.) -->	
	<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
    <?php echo $this->Html->script('ckfinder/ckfinder'); ?> 
    <?php echo $javascript->link(array('jquery.1.6.2.min.js','date.js', 'jquery.datePicker.js', 'jquery.callout.min.js')); ?>
</head>
<body>
<div id="panel-large">
	<!-- header -->
	<div id="content">
		<div id="clear"></div>	
		<?php	echo $content_for_layout;?>
	</div>
</div>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>