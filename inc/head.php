<?php header('Content-type: text/html;charset=utf-8');
	if($page!="pages")
	include("connection.php");
	else
		$page = $validPageCat;
		
	if(!isset($keywords)){
		$keywords = "College Capital";
	}
	if(!isset($description)){
		$description = "College Capital";
	}
	if(!isset($title)){
		$title = "College Capital ";
	}
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="keywords" content="<?php echo $keywords;?>">
<meta name="description" content="<?php echo $description;?>">
<meta name="author" content="www.echo3.com.au">
<meta name="robots" content="all" >

<link rel="shortcut icon" href="/favicon.ico?" >
<link rel="apple-touch-icon" href="/apple-icon.png" >
<meta name = "viewport" content = "user-scalable=0, initial-scale=1.0, maximum-scale=1.0, width=device-width" >
<meta name="apple-mobile-web-app-capable" content="yes">

<META HTTP-EQUIV='CACHE-CONTROL' CONTENT='MAX-AGE=864000, must-revalidate' >
<link href="<?php echo $site_path;?>css/cc.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo $site_path;?>css/font-awesome.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo $site_path;?>css/print.css" rel="stylesheet" type="text/css" media="print">
<link href="<?php echo $site_path;?>css/horizontalmenu.css" rel="stylesheet" type="text/css" media="all">

<link rel="stylesheet" href="<?php echo $site_path;?>css/contact-form.css" type="text/css" media="all">
<?php if($page=="network"){ ?>
<link rel="stylesheet" href="<?php echo $site_path;?>css/paginateStyles.css" type="text/css" media="all" />
<?php } ?>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/side-contact-form.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.html5form-1.5-min.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/bootstrap-collapse.js"></script>
<script type="text/javascript" src="<?php echo $site_path;?>js/csshorizontalmenu.js">
/* CSS Horizontal List Menu- by JavaScript Kit (www.javascriptkit.com)
Menu interface credits: http://www.dynamicdrive.com/style/csslibrary/item/glossy-vertical-menu/ 
This notice must stay intact for usage
Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more */
</script>
<?php if($page=="network"){ ?>
<script type="text/javascript" src="<?php echo $ccap_url;?>app/webroot/js/jquery.paginate.min.js"></script>
<?php } ?>
<input type='hidden' id='site_path' value='<?=$site_path;?>'></input>
<!--[if IE 9]>
<style>.horizontalcssmenu ul li ul{padding: 5px 0 0px 10px;}</style>
<![endif]-->

<!--[if IE 8]>
<style>  .horizontalcssmenu ul li ul{padding: 5px 0 0px 10px;}</style>
<![endif]-->

<!--[if IE 7]>
<style> .horizontalcssmenu ul li ul{padding: 5px 0 0px 10px;}</style>
<![endif]-->

<!-- google -->

<!-- end google -->
</head>
<body id="<?php echo $page; ?>" >

<div class="wrapper">
<!-- header section -->
<div id="head">

<div id="logo"><a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/cc-logo.gif" title="College Capital" alt="College Capital" width="363"  ></a></div>
<div id="tag"><a href="<?php echo $ccap_url;?>" target="_blank">LOGIN TO cCAP <i class="icon-circle-arrow-right"></i></a></div>
</div>
<!-- content section -->
<div id="contentWrapper">
<div id="content">
<!-- navigation section --> 
<div id="navWrapper">

 <!-- .btn-nav is used as the toggle for collapsed nav content -->
        
<a class="btn-nav" data-toggle="collapse" data-target=".nav-collapse" title="Menu">
      <span class="iconbar"></span>
      <span class="iconbar"></span>
      <span class="iconbar"></span>
    </a>
     <!-- Everything you want hidden at 700px or less, place within nav-collapse -->
        
     <div class="nav-collapse">
    <?php include("inc/nav.php"); ?>
    </div><!--end nav collapse -->
</div>