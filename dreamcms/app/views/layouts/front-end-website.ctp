<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title><?php if(isset($title_for_layout)){ echo $title_for_layout; }else{ echo "Website Administration";}?></title>
	<?php echo $this->Html->css('front-end.css'); ?>
	<link href="<?php echo Configure::read('Company.url');?>css/horizontalmenu.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Configure::read('Company.url');?>css/contact-form.css" rel="stylesheet" type="text/css"/>
	<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet" type="text/css">
    <meta name="author" content="www.echo3.com.au">
	<meta name="copyright" content="Copyright (c) Echo3 Pty Ltd">
	<meta name="robots" content="all">
</head>
<body id="main">
	<div id="top-strip">
        <div id="top-strip-text">
            <?php
                if (strlen($session->read('Auth.User.username'))>0) {
                    echo "Welcome <b>".$session->read('Auth.User.username').", </b>";   
                    echo $html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout'));
                } 
            ?>
                &nbsp; | &nbsp;<a href="mailto:support@echo3.com.au">CONTACT US</a>
        </div>
    </div>
    <div id="wrapper">
    	<!-- header section -->
    	<div id="head-wrapper">
    		<div id="head">
            	<div id="logo"><a href="#"><img src="<?php echo Configure::read('Company.url');?>images/sct-logo.gif" title="Superannuation Complaints Tribunal" alt="Superannuation Complaints Tribunal" width="495" height="84" ></a></div>
    			<div id="widget">  
    				<div id="searchBox">  
                        <form name="search" id="search" method="get" action="#">
                        <input name="zoom_query" type="text"  id="zoom_query" value="Site Search" size="12" onclick="this.select();">
                        <input type="hidden" name="zoom_per_page" value="10">
                        <input type="hidden" name="zoom_and" value="0">
                        <input type="hidden" name="zoom_sort" value="0">
                        <input type="button" name="search" value="SEARCH »" class="button-silver">
                        </form>
                    </div>
    				<div id="print"> <div id="fontsizer"></div><a href="#" alt="Print Page" title="Print Page" ><img src="<?php echo Configure::read('Company.url');?>images/print.gif" alt="print page" ></a> </div>
    			</div>
    		</div>
    		<div id="nav-wrapper"> 
            	<!-- .btn-nav is used as the toggle for collapsed nav content -->
            	<div id="toggle">
            		<a class="btn-nav" data-toggle="collapse" data-target=".nav-collapse" title="Menu" alt="Menu">
            			<span class="sml" style="color: #10253F; text-align:right; padding: 5px 0 0 0; margin: 0;">SCT MENU</span>
            		</a>
                </div>
            	<!-- Everything you want hidden at 700px or less, place within nav-collapse -->
            	<div class="nav-collapse">
            		<div id="nav">
                        <div class="horizontalcssmenu">
                            <ul id="cssmenu1">
                                <li class="index"><a href="#">Home</a></li>
                                <li class="about"><a href="#">About Us</a></li>
                                <li class="making-a-complaint"><a href="#">Making a Complaint</a></li>   
                                <li class="complaint-process"><a href="#">The Process</a></li>
                                <li class="determinations"><a href="#">Determinations</a></li>
                                <li class="faqs"><a href="#">FAQs</a></li>
                                <li class="publications"><a href="#">News &amp; Publications</a></li>
                                <li class="legislation"><a href="#"> Legislation</a> </li>
                                <li class="contact"><a href="#">Contact Us</a></li>
                            </ul>    
                        </div>
					</div>
            	</div>
            </div>            
		</div>
        <!-- content section -->
        <div id="content">
            <div id="col-left">
            	<div id="col-left-menu" class="grey-bg">
               		<h1><?php echo $moduleHeading; ?></h1>
                </div>
            </div>
            <div id="col-right" class="page"> 
                    <?php	echo $content_for_layout; ?>
            </div>
		</div>
        <div style="clear: both;" />
        <!-- footer section -->
        <div id="footer-wrapper" class="grey-bg">       
            <div id="footer">
                <div class="col" style="width: 80px; padding: 20px 0 0 20px;">
                    <img src="<?php echo Configure::read('Company.url');?>images/arrow-icon.gif" width="56" height="47" >
                </div>
            
                <ul class="col">
                    <li><a href="#">Making a complaint</a></li>
                    <li><a href="#">Who can complain? </a></li>
                    <li><a href="#">Complaints covered </a></li>
                    <li><a href="#">Complaints not covered</a></li>
                </ul>
            
                <ul class="col">
                    <li><a href="#">Time limits</a></li>
                    <li><a href="#">Jobs</a></li>
                    <li><a href="#">Sample fund complaint letter</a></li>
                    <li><a href="#">Written complaint form</a></li>
                </ul>
                <ul class="col">
                    <li><a href="#">Case study</a></li>
                    <li><a href="#">Glossary of terms</a></li>
                    <li><a href="#">Useful links</a></li>
                    <li><a href="#">Freedom of Information (FOI)</a></li>
                </ul>
                
                <ul class="col">
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Disclaimer</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Sitemap</a></li>
                </ul>       
            </div>
            <div style="clear: both;" />
            <div id="footer-txt">
                <a href="#">&copy; <?php echo date('Y'); ?> Superannuation Complaints Tribunal</a> | <a href="http://www.echo3.com.au" target="_blank">Web</a> <img src="<?php echo Configure::read('Company.url');?>images/coa.gif" width="66" height="48" alt="Commonwealth of Australia" style="vertical-align:middle;" >
        	</div>
        </div>
	</div>
</body>
</html>