<?php
	$page = "index";
	$keywords = "page not found";
	$description = "College Capital Page not found";
	$title = "College Capital | Page not found";
	include("inc/head.php");
?>
<div id="page-banner"><h1>Page Not Found</h1></div>
    <div id="col-left">
    </div>
    <div id="col-right">
        <h2><strong>Sorry!</strong> The page you are looking for does not exist.</h2>
        <p> Please try the following to find yourself in the right place:</p>
        <ul>
            <li> <a href="<?php echo $site_path;?>">Go to homepage.</a></li>
            <li>Check the URL and try again.</li>
            <li>The page must be expired or must have been unpublished.</li>
            <li>Follow the links on the menu above.</li>
           
        </ul>
	</div>
</div>
<?php include("inc/foot.php"); ?>