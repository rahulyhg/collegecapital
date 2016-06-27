<?php

$entityLocations = array();
// postal code and suburb
$postcodeSuburb = '';
$maxDistance = 0;
$pageLimit = 20;
$websitePath = Configure::read('Company.corporateUrl');
echo $this->Html->css('network.css'); 
?>
<div class="users view " style="line-height: 200%;">   
        <h2><?php echo $user['User']['name']." ".$user['User']['surname']; ?></h2>         
        <div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;">
        	<?php if(strlen($user['User']['logo'])>0) { ?><img src="<?php echo $dreamcms . '/app/webroot/uploads/users/'.$user['User']['logo'];?>" width="150" /> <?php } 
	?>
        </div>    
      
        <?php if(strlen($user['User']['position'])>0){ echo "<strong>Position:</strong> ".$user['User']['position']."<br />";}?>
		<?php if(strlen($user['User']['companyName'])>0){ echo "<strong>Company Name:</strong> ".$user['User']['companyName']."<br />";}?>
        <?php if(strlen($user['User']['email'])>0){?><strong>Email:</strong> <a href="mailto:<?php echo $user['User']['email'];?>"><?php echo $user['User']['email']."<br />"; ?></a><?php } ?>
        <?php if($user['User']['mobile']>0){ echo "<strong>Mobile:</strong> ".$user['User']['mobile']."<br />"; } ?>
        <?php if($user['User']['phone']>0){ echo "<strong>Phone:</strong> ".$user['User']['phone']."<br />"; } ?>
        <?php if($user['User']['fax']>0){ echo "<strong>Fax:</strong> ".$user['User']['fax']."<br />"; } ?>
        <?php
       
        ?>
        <?php 
        if( strlen($user['User']['streetAddress'])> 0 )
            { 
            echo "<strong>Street Address:</strong> ".$user['User']['streetAddress'].(strlen($user['User']['streetSuburb'])>0?", ".$user['User']['streetSuburb']:"").(strlen($streetState['Tblstate']['State'])>0?", ".$streetState['Tblstate']['State']:"").(strlen($user['User']['streetPostcode'])>0?", ".$user['User']['streetPostcode']:"")."<br />";
            }  
            // check lat and lang
            if( !empty($user['User']['latitude']) ){
                $entityLocations[] = array('lat' => $user['User']['latitude'], 'lng' => $user['User']['longitude']);
            }
        ?>
        
        
        <?php if(strlen($user['User']['googleMap'])>0){?><strong>Map:</strong> <a href="<?php echo $user['User']['googleMap'];?>" target="_blank"><?php echo $user['User']['googleMap']."<br />"; ?></a><?php } ?>
        <?php if(strlen($user['User']['website'])>0){?><strong>Website:</strong> <a href="<?php echo (substr($user['User']['website'],4)=='http'?$user['User']['website']:"//".$user['User']['website']);?>" target="_blank"><?php echo $user['User']['website']."<br />"; ?></a><?php } ?>
        <?php if($_SESSION['Auth']['User']['id']==$user['User']['id']){?><p><?php if(strlen($user['User']['websiteLogin'])>0){?><a href="mailto:<?php echo $user['User']['websiteLogin'];?>"><?php echo "<strong>Website Login:</strong> ".$user['User']['websiteLogin']."<br />"; ?></a><?php } ?><?php } ?>
 
        <?php if(strlen($user['User']['linkedIn'])>0){?><a href="<?php echo $user['User']['linkedIn'];?>" target="_blank"><?php echo "<strong>LinkedIn:</strong> ".$user['User']['linkedIn']; ?></a><?php } ?>     
    </div>
  <!------------- show google map Div -->
  <div style='width:100%;height:300px;' id='mapDiv'></div>
  
  <!-- included for google map ------------------------------> 
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>  
<script language="javascript" type="text/javascript">
                $(document).ready(function(){
        var userList = parseInt("<?php echo $userList; ?>");
    // paginate only in multiple pages view
    if(userList == 1)   {
    $('#paging_container').pajinate({
                        num_page_links_to_display : 4,
                        items_per_page : <?php echo $pageLimit;?>	
                    });
                 }
             // expnad brokers    
                $('.fa-hide-show').click(function(){

                    if( $(this).closest('div.cc-company').find('.divBrokers').is(':visible') ){
                    $(this).addClass('icon-plus-sign').removeClass('icon-minus-sign');
                    // change text    
                    $(this).siblings(".brokerHideViewTxt").first().html(' View Brokers');
                }
                else
                {
                    $(this).addClass('icon-minus-sign').removeClass('icon-plus-sign');
                    // change text    
                    $(this).siblings(".brokerHideViewTxt").first().html(' Hide Brokers');
                    }
                    $(this).closest('div.cc-company').find('.divBrokers').slideToggle('fast');
                });         

                // postal code search                
                $('#btn-search-postal-code').click(function(){  
                        RedirectToSelf();             
                });

                $('#txtPostcode').keypress(function(e) 
                {
                if (e.keyCode == 13) {
                RedirectToSelf();
                }
                }); 
                    // Start google map 
                    var entityLocations = <?php echo json_encode($entityLocations); ?>; 
                    var distance = parseFloat("<?php echo $maxDistance;?>");
                    //alert(entityLocations.length);
                    var zoomLevel = GetZoomLevel(distance);
                    var locationImg = "<?php echo $websitePath;?>" + 'dreamcms/app/webroot/img/location-marker.png';                       
                    //alert(locationImg);
                    // any value between 96 and 159 => See top function       
                    if(entityLocations.length >= 1) {
                    var mapOptions = {
                        zoom: zoomLevel,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }                        
                    var latlng = new google.maps.LatLng(entityLocations[0].lat, entityLocations[0].lng);
                    var map;
                    var mapDiv = document.getElementById('mapDiv');
                    // assign html div                
                    var map = new google.maps.Map(mapDiv, mapOptions);
                    map.setCenter(latlng);

                    for(var i = 0; i < entityLocations.length; ++i) {
                    var latlng = new google.maps.LatLng(entityLocations[i].lat, entityLocations[i].lng);     
                    new google.maps.Marker({
                    map: map,
                    position: latlng,
                    icon:locationImg,
                    draggable: true
                    }); 
                    }}
        });
                
  function GetZoomLevel(distance) {
       var zoomLevel = 15;
       if(distance > 0.0 && distance < 2.0){
           zoomLevel = 15;
       }
       else if(distance > 2.0 && distance < 7.0){
            zoomLevel = 12;
       }
       else if(distance > 7.0 && distance < 15.0){
            zoomLevel = 10;
       }
       else if(distance > 15.0 && distance < 40.0){
            zoomLevel = 8;
       }
       else if(distance > 40.0 && distance < 120.0){
            zoomLevel = 7;
       }
       else if(distance > 120.0){
            zoomLevel = 5;
       }
       
       return zoomLevel;
   }
   
   function RedirectToSelf(){
    var postalCodeSuburb = $('#txtPostcode').val().trim();            
    if(postalCodeSuburb.length <= 0 ){
        alert("Enter Postcode or Suburb");
        $('#txtPostcode').focus();
        return;        
    }
    var location = "<?php echo $this->here;?>" + '?pcsu=' + postalCodeSuburb;
    window.location.href = location; 
   }
 </script>