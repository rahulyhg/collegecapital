<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php if(isset($title_for_layout)){ echo $title_for_layout; }else{ echo "College Capital Extranet";}?></title>
	<?php echo $this->Html->charset(); ?>
	<link rel="shortcut icon" href="http://www.collegecapital.com.au/favicon.ico" type="image/x-icon">
	<?php echo $this->Html->css('dreamcms-general.css'); ?>
    <?php echo $this->Html->css('horizontalmenu.css'); ?>
	<?php echo $this->Html->css('font-awesome.css');  ?>
	<?php echo $this->Html->css('thickbox.css'); ?>
    <?php echo $this->Html->script('jquery.1.6.2.min.js'); ?>    
	<?php echo $this->Html->script('thickbox.js'); ?>
    <?php echo $this->Html->script('animatedCollapsiblePanel.js'); ?>
    <script language="javascript" type="text/javascript">
		$(document).ready(function(){
			$(".slideOutTrigger").click(function(){
				$(".slideOutPanel").toggle("fast");
				$(this).toggleClass("active");
				<?php if(isset($helpURL)){?>
					$('.slideOutPanelFrame').attr('src','http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=1,4,6,7,8,9,10,11,12#<?php echo $helpURL;?>');
				<?php } else { ?>
				$(".slideOutPanel").html("<p>Sorry, there is no Help section</p>");
				<?php } ?>
				return false;
			});
		});
	</script>
</head>
<body id='<?php echo $page;?>' >
<div id="top-strip">
	<div id="top-strip-text">
		<?php
		 $dreamcms = '/dreamcms/';	
                //$dreamcms = Configure::read('Company.menuUrl')
                if ( strlen($session->read('Auth.User.username'))>0 ) {
                            //echo $html->link('MY ACCOUNT | ', array('controller' => 'users', 'action' => 'edit'));    
                            echo "<a href='$dreamcms/users/myprofile'>MY ACCOUNT | </a>";
                            echo "Welcome <b> {$session->read('Auth.User.name')}, </b>";   
			    echo $html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout'));
			    echo "&nbsp; | &nbsp;";
			} 
		?>
			<a href="/contacts">CONTACT US</a>
	</div>
</div>

	<!-- header -->
	<div id="header-wrap">
		<!-- <div id="header-client-name"><?php echo Configure::read('Company.name');?> Administration Portal</div>-->
		<div id="header-client-logo"></div>
	</div>
    <div id="panel" <?php if($_SESSION['Auth']['User']['group_id']==4) { echo "style='min-height: 0px;'"; }?>>
<!--  top main menu -->	
		<div id="main-menu">
        <div class="horizontalcssmenu">
        <ul id="cssmenu1">
				<li class="home"><a href="<?php echo Configure::read('Company.menuUrl');?>" title="home">Home</a></li>
                <li class="about"><a href='<?php echo Configure::read('Company.menuUrl');?>webpages/view/1' title='about'>About</a></li>
                
			    <?php echo ($_SESSION['Auth']['User']['group_id']<4?"
				<li class='claims'><a href='".Configure::read('Company.menuUrl')."claims/' title='transactions'>Transactions</a></li>
				<li class='links'><a href='".Configure::read('Company.menuUrl')."links/view' title='links'>Links</a></li>
				<li class='contacts'><a href='".Configure::read('Company.menuUrl')."clients/view' title='contacts'>Contacts</a></li>":"");?>
                <li class='network'><a href='<?php echo Configure::read('Company.menuUrl');?>users/view/' title='network'>Network</a></li>
                <?php echo ($_SESSION['Auth']['User']['group_id']<4?"
				<li class='news'><a href='".Configure::read('Company.menuUrl')."news/view/' title='news'>News</a></li>
				<li class='documents'><a href='".Configure::read('Company.menuUrl')."documents/view/' title='documents'>Documents</a></li>":"");?>
                <li class="rates"><a href='<?php echo Configure::read('Company.menuUrl');?>rates/view/' title='rates'>Rates</a></li>
                <?php
				if($_SESSION['Auth']['User']['group_id']==1){?>
                <li class="pages"><a href='<?php echo Configure::read('Company.menuUrl');?>webpages/' title='pages'>Pages</a></li>
                <?php } ?>
                <?php echo ($_SESSION['Auth']['User']['group_id']==1?"
				<li class='vbis'><a href='".Configure::read('Company.menuUrl')."vbis/' title='VBI'>VBI</a></li>":"");?>
		</ul>
</div></div> <!--  end top main menu -->

<?php if(isset($removeBanner) && !$removeBanner){ ?>
<div id="page-banner"><div class="heading"><?php if(isset($moduleHeading)){ echo $moduleHeading;}?></div><div class="divider">&nbsp;</div><div class="action"><?php if(isset($moduleAction)){ echo $moduleAction; }?></div></div>	
<!-- page banner needs to display module heading > module action-->	
<?php } ?>
<!-- content -->
<?php if(isset($removeSideMenu) && !$removeSideMenu){ 
    //$dreamcms = 'dreamcms/';
    ?>
	<div id="contentLeft">
   
<!-- side menu -->
        <div class="menu-module">
            <ul class="side-menu"> 
			<?php
				//for sub-pages
				if(isset($pageList) && $pageList){
					$parentPages = $this->requestAction('/webpages/getParentPages/1');//page category, hard coded for only one category for now
					if(isset($parentPages)){
						foreach($parentPages as $parentPage):
							echo "<li><a href='".Configure::read('Company.menuUrl')."webpages/view/".(int)$parentPage['Webpage']['id']."'><i class='icon-circle-arrow-right'></i> ".$parentPage['Webpage']['title']."</a>";
							$subPages = $this->requestAction('/webpages/getChildPages/'.$parentPage['Webpage']['id']);
							if(isset($subPages)){
								echo "<ul>";
								foreach($subPages as $subPage):
									echo "<li style='border: none;
padding: 10px 0px 0px 40px; width: auto;'><a href='".Configure::read('Company.menuUrl')."webpages/view/".(int)$subPage['Webpage']['id']."'>".$subPage['Webpage']['title']."</a></li>";
								endforeach;
								echo "</ul>";
							}
							echo "</li>";
						endforeach;	
					}
				} else {
					if(isset($overview) && $overview){
						echo "<li><a href='/".strtolower($this->params['controller'])."/view'><i class='icon-circle-arrow-right'></i> Overview</a></li> ";
					}
				}
				if(isset($manage) && $manage){?>
                <li><a href="<?php echo Configure::read('Company.menuUrl') . strtolower($this->params['controller']);?>/"><i class="icon-pencil"></i> Manage</a> </li>
                <?php }
				if(isset($manageVBIStructure) && $manageVBIStructure){?>
                <li><a href="<?php echo Configure::read('Company.menuUrl') . "claims_lenders";?>/"><i class="icon-pencil"></i> Manage VBI Rules</a> </li>
                <li><a href="<?php echo Configure::read('Company.menuUrl') . "vbis";?>/"><i class="icon-pencil"></i> Manage Structure</a> </li>
                <?php }
				if(isset($manageVBISplit) && $manageVBISplit){?>
                <li><a href="<?php echo Configure::read('Company.menuUrl') . "vbis_splits";?>/"><i class="icon-pencil"></i> Manage Split</a> </li>
                <?php }
				if(isset($manageVBISetting) && $manageVBISetting){?>
                <li><a href="<?php echo Configure::read('Company.menuUrl') . "vbis_settings";?>/"><i class="icon-pencil"></i> Manage VBI Settings</a> </li>
                <?php }
				if(isset($profile) && $profile){?>
                <li><a href="<?php echo $dreamcms . strtolower($this->params['controller']);?>/myprofile"><i class="icon-circle-arrow-right"></i> My Profile</a> </li>
                <li><a href="<?php echo  $dreamcms . strtolower($this->params['controller']);?>/changedetails"><i class="icon-pencil"></i> Change Details</a> </li>
                <?php }
				if(isset($reportingVBIStructure)){ 
                    if($reportingVBIStructure){?>
                        <li><a href="<?php echo Configure::read('Company.menuUrl') . "vbis";?>/extractreport?KeepThis=true&height=370&width=500&TB_iframe=true&modal=true" class="thickbox"><i class="icon-file"></i> Reports Structure</a> </li>
            <?php 	} 
			     } 
				 if(isset($reportingVBISplit)){ 
                    if($reportingVBISplit){?>
                         <li><a href="<?php echo Configure::read('Company.menuUrl') . "vbis_splits/extractreport";?>/"><i class="icon-file"></i> Reports Split</a> </li>                     
            <?php 	} 
			     } 
				 if(isset($reportingVBIBreakUp)){ 
                    if($reportingVBISplit){?>
                        <li><a href="<?php echo Configure::read('Company.menuUrl') . "vbis_splits";?>/extractreportBreakup?KeepThis=true&height=370&width=500&TB_iframe=true&modal=true" class="thickbox"><i class="icon-file"></i> Reports Break Up</a> </li>
            <?php 	} 
			     } 
				 if(isset($reportingVBIGraph)){ 
                    if($reportingVBIGraph){?>
                        <li><a href="<?php echo Configure::read('Company.menuUrl') . "vbis_splits";?>/extractreportVbigraph?KeepThis=true&height=370&width=590&TB_iframe=true&modal=true" class="thickbox"><i class="icon-file"></i> Reports Graphically</a> </li>
            <?php 	} 
				 }
				 if(isset($reportingTransaction)){ 
                  ?>
                        <li><a href="<?php echo Configure::read('Company.menuUrl') . strtolower($this->params['controller']);?>/extractreport?KeepThis=true&height=480&width=500&TB_iframe=true&modal=true" class="thickbox"><i class="icon-file"></i> Report - Transactions</a> </li>
                        <?php if (($_SESSION['Auth']['User']['group_id'] == 1) || ($_SESSION['Auth']['User']['group_id'] == 2) || ($_SESSION['Auth']['User']['group_id'] == 3))  { ?>
                        <li><a href="<?php echo Configure::read('Company.menuUrl') . strtolower($this->params['controller']);?>/extractreportExpiring?KeepThis=true&height=480&width=500&TB_iframe=true&modal=true" class="thickbox"><i class="icon-file"></i> Report - Expiring</a> </li>
                        <?php } ?>
            <?php 	 
				 }
				if(isset($reporting)){ 
                    if($reporting){?>
                        <li><a href="<?php echo Configure::read('Company.menuUrl') . strtolower($this->params['controller']);?>/extractreport?KeepThis=true&height=480&width=500&TB_iframe=true&modal=true" class="thickbox"><i class="icon-file"></i> Reports</a> </li>
            <?php 	} 
                } ?>
            </ul>    
        </div> 
    
<!--  admin modules -->
        <?php if ($session->read('Auth.User.group_id')==1) {?>
        <div class="menu-module"><div class="squarebox"><div class="squareboxgradientcaption" style="height:20px; cursor: pointer;" onclick="togglePannelAnimatedStatus(this.nextSibling,50,50)"><div style="float: left;color: #999;font: bold 13px/18px arial,sans-serif;padding-left: 10px;">ADMIN MODULES</div><div style="float: right; vertical-align: middle"><img src="<?php echo Configure::read('Company.menuUrl');?>app/webroot/img/expand.gif" width="13" height="14" border="0" alt="Show/Hide" title="Show/Hide" /></div></div><div class="squareboxcontent" style="display: none;">
                <ul>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.menuUrl');?>claims_goodsdescs/' title='transaction goods descriptions'>Transaction Goods Descriptions</a></li>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.menuUrl');?>claims_industryprofiles/' title='transaction industry profiles'>Transaction Industry Profiles</a></li>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.menuUrl');?>claims_lenders/' title='transaction lenders'>Transaction Lenders</a></li>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.menuUrl');?>claims_producttypes/' title='transaction product types'>Transaction Product Types</a></li>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.menuUrl');?>clients_categories/' title='contacts categories'>Contact Categories</a></li>
                    <li><a class='menu_item' href='<?php echo Configure::read('Company.menuUrl');?>documents_categories/' title='documents categories'>Documents Categories</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.menuUrl');?>links_categories/" title="links categories">Links Categories</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.menuUrl');?>news_categories/" title="news categories">News Categories</a></li>
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.menuUrl');?>pages_categories/" title="pages categories">Pages Categories</a></li>   
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.menuUrl');?>rates_categories/" title="rates categories">Rates Categories</a></li>             
                    <li><a class="menu_item" href="<?php echo Configure::read('Company.menuUrl');?>groups/" title="user groups">User Groups</a></li>
                </ul>
                </div>
            </div>
        </div>
        <?php } ?><!-- end admin modules -->    
	</div><!-- end contentLeft --> 
    <?php } ?>
	<div id="contentRight" <?php if($_SESSION['Auth']['User']['group_id']==4) { echo "style='min-height: 0px;'"; }?>>
		<?php 
			if (!isset($content_for_layout)){ 
				echo "<h2>Welcome to cCap</h2>
				<p>Use the menu options above to view and manage the areas of the website you can access. </p>
				<p><strong>Any questions?</strong> <a href='http://www.collegecapital.com.au/contact.php'>Please do not hesitate to contact College Capital</a>.</p>";
			} else {				
				echo $content_for_layout;
			}
		?>
	</div>
</div>
<div id="footer"><a href="http://www.collegecapital.com.au" target="_blank">&copy; <?php echo date('Y'); ?> College Capital</a> | <a href="http://www.echo3.com.au" target="_blank">web</a> | <a href="mailto: support@echo3.com.au" target="_blank">support</a></div>
<?php echo $this->element('sql_dump'); ?>
<div class="slideOutPanel">
	<iframe src="http://www.echothree.com.au/dreamcms/app/views/pages/help.php?modules=1,4,6,7,8,9,10,11,12#<?php echo $helpURL;?>" class="slideOutPanelFrame"></iframe>
	<div style="clear:both;"></div>
</div>
<a class="slideOutTrigger" href="#">help</a>
</body>
</html>