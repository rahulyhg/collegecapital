<!-- Slideshow Cycle http://jquery.malsup.com/cycle/-->
<!-- include jQuery library -->
<!-- include Cycle plugin -->
<script type="text/javascript" src="<?php echo $site_path;?>js/jquery.cycle.min.js"></script>

<script type="text/javascript">


$(function() {
        $('#smlPhoto').cycle({ 
		random: 1,
       delay: 200,
	   speed: 4000,
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

#smlPhoto {
			position: relative;
			width: 310px;
			height: 173px;
			overflow: hidden; }
	
			
#smlPhoto img {
				display: block;
				width: 310px;
				height: 173px; }
				
.slideshow a { display: block; width: 720; height: 230; top: 0; left: 0 }
	
	

</style>


		
<div id="smlPhoto" class="slideshow">

<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/home1.jpg" width="315"  border="0" alt="" ></a>			
<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/home2.jpg" width="315" border="0" alt="" ></a>	
<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/home3.jpg" width="315"  border="0" alt="" ></a>	

<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/home4.jpg" width="315"  border="0" alt="" ></a>	

<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/home5.jpg" width="315"  border="0" alt="" ></a>	

<a href="<?php echo $site_path;?>"><img src="<?php echo $site_path;?>images/home6.jpg" width="315"  border="0" alt="" ></a>	
	
		</div>


