<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $title_for_layout?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <?php echo $this->Html->css('dreamcms-general.css'); ?>
    <?php echo $this->Html->css('horizontalmenu.css'); ?>
    <?php echo $this->Html->css('font-awesome.css'); ?>
	<?php echo $this->Html->css('thickbox.css'); ?>
	<?php echo $this->Html->css('datePicker.css'); ?>
	<!-- Include external files and scripts here (See HTML helper for more info.) -->	
	<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
    <?php echo $this->Html->script('ckfinder/ckfinder'); ?> 
    <?php echo $javascript->link(array('jquery.1.6.2.min.js','date.js', 'jquery.datePicker.js', 'jquery.callout.min.js')); ?>    
	<?php echo $this->Html->script('thickbox.js'); ?>
    <?php echo $this->Html->script('animatedCollapsiblePanel.js'); ?>
    <script language="javascript" type="text/javascript">
		$(document).ready(function(){
			$(".slideOutTrigger").click(function(){
				$(".slideOutPanel").toggle("fast");
				$(this).toggleClass("active");
				<?php if(isset($helpURL)){?>
					$('.slideOutPanelFrame').attr('src','http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=4,6,8,9#<?php echo $helpURL;?>');
				<?php } else { ?>
				$(".slideOutPanel").html("<p>Sorry, there is no Help section</p>");
				<?php } ?>
				return false;
			});
		});
	</script>
</head>
<body id='<?php echo $page ?>' >
    <div id="top-strip">
        <div id="top-strip-text">
			<?php
            if (strlen($session->read('Auth.User.name'))>0) {
            	echo "Welcome <b>".$session->read('Auth.User.name').", </b>";   
            	echo $html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout'));
            } 
            ?>
            &nbsp; | &nbsp;<a href="mailto:support@echo3.com.au">CONTACT US</a>
        </div>
    </div>
    <div id="header-wrap"><!-- header -->
    	<?php echo $this->CustomDisplayFunctions->displayHeader(true); ?></div>
    	<div id="panel">
    		<div id="main-menu">
    			<?php echo $this->CustomDisplayFunctions->displayMenuModules(true,$session->read('Auth.User.group_id')); ?></div>
            <div id="page-banner"><div class="heading"><?php if(isset($moduleHeading)){ echo $moduleHeading;}?></div><div class="divider">&nbsp;</div><div class="action"><?php if(isset($moduleAction)){ echo $moduleAction; }?></div>
		</div>	
        <!-- content -->
        <div id="contentLeft">
            <!-- side menu -->
            <div class="menu-module">
            	<ul class="side-menu"> 
                    <?php if(isset($overview) && $overview){?>
                    <li><a href="/<?php echo strtolower($this->params['controller']);?>/view"><i class="icon-circle-arrow-right"></i> Overview</a> </li>
                    <?php }
					if(isset($manage) && $manage){?>
                    <li><a href="/<?php echo strtolower($this->params['controller']);?>/"><i class="icon-pencil"></i> Manage</a> </li>
                    <?php }
                    if(isset($reporting)){ 
                        if($reporting){?>
                            <li><a href="/<?php echo strtolower($this->params['controller']);?>/extractreport?KeepThis=true&height=370&width=500&TB_iframe=true&modal=true" class="thickbox"><i class="icon-file"></i> Reports</a> </li>
                <?php 	} 
                    } ?>
                </ul>   
            </div> 
            <?php echo $this->CustomDisplayFunctions->displayWebsiteModules(true,$session->read('Auth.User.group_id')); ?>
        </div>
        <div id="contentRight">
            <?php 
            if (!isset($content_for_layout)){ 
                echo "<p>Use the menu options above to view and manage the areas of the website you have access privileges. </p>
                <p><strong>Any questions?</strong> <a href='http://www.collegecapital.com.au/contact.php'>Please do not hesitate to contact College Capital</a>.</p>";
            } else { 
                echo $this->CustomDisplayFunctions->displayQuickSearch(false,NULL);?>
                <div id="wrap-tabs">
                <?php echo $this->CustomDisplayFunctions->displaySearchBox(false); ?>
                    <div class="menu-tab">
                        <span class="tab"><?php echo $this->Html->link(__('display all', true), array('action' => 'index')); ?></span>
                    </div>
                </div>	
                <div id="clear"></div>	
            <?php	
                echo $content_for_layout;
            }	?>
        </div>
    </div>
    <div id="footer"><a href="http://www.collegecapital.com.au" target="_blank">&copy; <?php echo date('Y'); ?> College Capital</a> | <a href="http://www.echo3.com.au" target="_blank">web</a></div>
    <?php echo $this->element('sql_dump'); ?>
    <div class="slideOutPanel">
        <iframe src="http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=4,6,8,9#<?php echo $helpURL;?>" class="slideOutPanelFrame"></iframe>
        <div style="clear:both;"></div>
    </div>
    <a class="slideOutTrigger" href="#">help</a>
</body>
</html>