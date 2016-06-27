<!-- Slideshow Cycle http://jquery.malsup.com/cycle/-->
<!-- include jQuery library -->
<!-- include Cycle plugin -->
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.cycle.min.js"></script>

<script type="text/javascript">


$(function() {
        $('#bigPhoto').cycle({ 
		random: 1,
       delay: 200,
	   speed: 5000,
       	   fx: 'fade',
	   pager:  '#ss-nav',
	   
		slideExpr: 'img',
	   after:     function() {
            $('#caption').html(this.alt);
	   }

    
    });
}); 
</script>




<style type="text/css">

#bigPhoto {
			position: relative;
			width: 660px;
			height: 173px;
			overflow: hidden; }
	
			
#bigPhoto img {
				display: block;
				width: 660px;
				height: 173px; }
				
.slideshow a { display: block; width: 720; height: 230; top: 0; left: 0 }
	
	

</style>


		
<div id="bigPhoto" class="slideshow">

<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/header1.jpg" width="660"  border="0" alt="" ></a>			
<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/header2.jpg" width="660" border="0" alt="" ></a>	
<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/header3.jpg" width="660"  border="0" alt="" ></a>	
	
		</div>


