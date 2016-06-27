<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Echo3 CMS - HELP</title>
<link rel="stylesheet" href="slider/css/coda-slider.css" type="text/css" media="screen" title="no title" charset="utf-8">

<script src="/dreamcms/app/webroot/js/jquery.1.6.2.min.js" type="text/javascript"></script>
<script src="slider/js/jquery.scrollTo-1.3.3.js" type="text/javascript"></script>
<script src="slider/js/jquery.localscroll-1.2.5.js" type="text/javascript" charset="utf-8"></script>
<script src="slider/js/jquery.serialScroll-1.2.1.js" type="text/javascript" charset="utf-8"></script>
<script src="slider/js/coda-slider.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
    <div id="wrapper">    
        <div id="slider">    
            <ul class="navigation">
            <?php 
				/******************************* Refernce ************************************************
				FAQ = 1,Gallery = 2,Links = 3,News = 4,Projects = 5,Pages = 6,Teams = 7,Testimonials = 8			
				*****************************************************************************************/
				$dispAll = false;
				$err = false;
				if(!isset($_GET["modules"])){
					$dispAll = true;
			?>
                    <li><a href="#help">Help</a></li>
                    <li><a href="#faqs"><img src="/dreamcms/app/webroot/img/nav/faqs.gif" border="0" alt="FAQs" title="FAQs" /></a></li>
                    <li><a href="#gallery"><img src="/dreamcms/app/webroot/img/nav/gallery.gif" border="0" alt="Gallery" title="Gallery" /></a></li>
                    <li><a href="#links"><img src="/dreamcms/app/webroot/img/nav/web.gif" border="0" alt="Links" title="Links" /></a></li>
                    <li><a href="#news"><img src="/dreamcms/app/webroot/img/nav/news.gif" border="0" alt="News" title="News" /></a></li>
                    <li><a href="#projects"><img src="/dreamcms/app/webroot/img/nav/projects.gif" border="0" alt="Projects" title="Projects" /></a></li>
                    <li><a href="#pages"><img src="/dreamcms/app/webroot/img/nav/pages.gif" border="0" alt="Pages" title="Pages" /></a></li>
                    <li><a href="#teams"><img src="/dreamcms/app/webroot/img/nav/teams.gif" border="0" alt="Teams" title="Teams" /></a></li>
                    <li><a href="#testimonials"><img src="/dreamcms/app/webroot/img/nav/testimonials.gif" border="0" alt="Testimonials" title="Testimonials" /></a></li>
            <?php
				} else {
					$dispFaq = false; $dispGallery = false; $dispLinks = false; $dispNews = false; $dispProjects = false; $dispPages = false; $dispTeams = false; $dispTestimonials = false;
					$moduleLists = explode(",",trim($_GET["modules"]));
					echo '<li><a href="#help">Help</a></li>';
					for($i=0;$i<count($moduleLists);$i++){
						switch((int)$moduleLists[$i]){
							case 1:
								echo '<li><a href="#faqs"><img src="/dreamcms/app/webroot/img/nav/faqs.gif" border="0" alt="FAQs" title="FAQs" /></a></li>';
								$dispFaq = true;
								break;
							case 2:
								echo '<li><a href="#gallery"><img src="/dreamcms/app/webroot/img/nav/gallery.gif" border="0" alt="Gallery" title="Gallery" /></a></li>';
								$dispGallery = true;
								break;	
							case 3:
								echo '<li><a href="#links"><img src="/dreamcms/app/webroot/img/nav/web.gif" border="0" alt="Links" title="Links" /></a></li>';
								$dispLinks = true;
								break;	
							case 4:
								echo '<li><a href="#news"><img src="/dreamcms/app/webroot/img/nav/news.gif" border="0" alt="News" title="News" /></a></li>';
								$dispNews = true;
								break;
							case 5:
								echo '<li><a href="#projects"><img src="/dreamcms/app/webroot/img/nav/projects.gif" border="0" alt="Projects" title="Projects" /></a></li>';
								$dispProjects = true;
								break;		
							case 6:
								echo '<li><a href="#pages"><img src="/dreamcms/app/webroot/img/nav/pages.gif" border="0" alt="Pages" title="Pages" /></a></li>';
								$dispPages = true;
								break;	
							case 7:
								echo '<li><a href="#teams"><img src="/dreamcms/app/webroot/img/nav/teams.gif" border="0" alt="Teams" title="Teams" /></a></li>';
								$dispTeams = true;
								break;	
							case 8:
								echo '<li><a href="#testimonials"><img src="/dreamcms/app/webroot/img/nav/testimonials.gif" border="0" alt="Testimonials" title="Testimonials" /></a></li>';
								$dispTestimonials = true;
								break;	
							default:
								echo 'Invalid parameter';
								$err = true;
						}
					}						
				}
			?>    
            </ul>
			<?php
				if($err){
					$referrerURL = $_SERVER['HTTP_REFERER'];
					header("Location: $referrerURL/404.htm");	
				}
			?>
            <div class="scroll">
                <div class="scrollContainer">
                    <div class="panel" id="help">
                        <h2>Help</h2>
                        <p>Welcome to the Help section of our Content Management System.</p>
                        <p>Click through the tabs (image icons) to find more information on how each module works. You can also find specific module information about how to efficiently write content for your website using the new WYSIWYG editor.</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    
                    <?php if($dispAll || $dispFaq){ ?>
                    <div class="panel" id="faqs">
                    	<h2>FAQs</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php 
					}
					if($dispAll || $dispGallery){ ?>
                    <div class="panel" id="gallery">
                    	<h2>Gallery</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php 
					}
					if($dispAll || $dispLinks){ ?>
                    <div class="panel" id="links">
                    	<h2>Links</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php 
					}
					if($dispAll || $dispNews){ ?>
                    <div class="panel" id="news">
                    	<h2>News</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php 
					}
					if($dispAll || $dispProjects){ ?>
                    <div class="panel" id="projects">
                    	<h2>Projects</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <a href="#sites">And some sites</a></p>
                    </div>
                    <?php 
					}
					if($dispAll || $dispPages){ ?>
                    <div class="panel" id="pages">
                    	<h2>Pages</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php 
					}
					if($dispAll || $dispTeams){ ?>
                    <div class="panel" id="teams">
                    	<h2>Teams</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php 
					}
					if($dispAll || $dispTestimonials){ ?>
                    <div class="panel" id="testimonials">
                    	<h2>Testimonials</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div id="shade"></div>
        </div>        
    </div>
</body>
</html>