<?php
//********************************* Utility Functions
function getLatLongFromPostcodeOrSuburb($postcodeOrSuburb, $country, $gmapApiKey)
{
    /* remove spaces from postcode */
    $postcodeOrSuburb = urlencode(trim($postcodeOrSuburb));
 
    /* connect to the google geocode service */    
    $file = "https://maps.google.com/maps/api/geocode/xml?address=$postcodeOrSuburb,+AU&key=AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8";
    //echo $file;
    $xml = simplexml_load_file($file) or die("url not loading");
	
    return ($xml);
}
function LatAndLngExistInAustralia($lat, $lng){
    // got values from AUS post office database
    if($lat > -9 || $lat < -43 || $lng < 96 || $lng > 159){
        return false;
    }
    return true;    
}

function getComapniesDetailsByLatAndLng($groupid, $lat, $lng){
    $distance = 500; // 5km radius
    $earthRadius = '6371.0'; // In km
    $latitudeRad = deg2rad($lat); 
    $longitudeRad = deg2rad($lng);
    
     $sql = "SELECT * FROM (SELECT ROUND($earthRadius * ACOS(SIN($latitudeRad) * SIN( latitude* PI()/180 )
                            + COS($latitudeRad) * COS( latitude*PI()/180 )  *  COS( (longitude* PI()/180) - $longitudeRad)) 
                    , 1)
                    AS distance,                    
                    companyName,                   
                    logo,
                    streetAddress,
                    streetSuburb,
                    streetPostcode,
                    latitude,
                    longitude                 
                FROM
                    `users` WHERE latitude IS NOT NULL AND live = 1 AND group_id = $groupid 
                GROUP BY companyName, streetSuburb ORDER BY
                    distance ASC LIMIT 0, 5) AS Companies  where distance < $distance; 
                ";
      $userModel = ClassRegistry::init('User');
      $companies = $userModel->query($sql);
      return $companies;
}

function getBrokersByCompanyBranch($groupid, $companyName, $stAddress, $suburb){
    $sql = "SELECT * FROM users where companyName ='$companyName' AND live = 1 AND group_id = $groupid AND streetAddress='$stAddress' AND streetSuburb='$suburb' order by name ASC";    
    //echo $sql . '<br>';    
    $userModel = ClassRegistry::init('User');
    $brokers = $userModel->query($sql);
    return $brokers;
}

function getAllGroupOptions(){
    
}

//************************************ End Utility functions
// used in javascript for marking all locations
$entityLocations = array();
// postal code and suburb
$postcodeSuburb = '';
$maxDistance = 0;
$pageLimit = 20;
$groupValue = 3;
$websitePath = Configure::read('Company.corporateUrl');

if( !empty($_GET['pcsu']) ){
    $postcodeSuburb = $_GET['pcsu'];
}
echo $this->Html->css('network.css'); 

?>

<?php	
if( empty($userList) && empty($postcodeSuburb) ){ //display individual users
?>

<div class="users view " style="line-height: 200%;">   
        <h2><?php echo $user['User']['name']." ".$user['User']['surname']; ?></h2>         
        <div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;">
        	<?php if(strlen($user['User']['logo'])>0) { ?><img src="<?php echo '/app/webroot/uploads/users/'.$user['User']['logo'];?>" width="150" /> <?php } 
	?>
        </div>     
        <?php //var_dump($user); ?>
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
                $entityLocations[] = array('lat' => $user['User']['latitude'], 'lng' => $user['User']['longitude'], 'compname' => $user['User']['companyName'], 'suburb' => $user['User']['streetSuburb']);
                //$entityLocations[] = array('lat' => $user['User']['latitude'], 'lng' => $user['User']['longitude']);
            }
        ?>
        
        
        <?php if(strlen($user['User']['googleMap'])>0){?><strong>Map:</strong> <a href="<?php echo $user['User']['googleMap'];?>" target="_blank"><?php echo $user['User']['googleMap']."<br />"; ?></a><?php } ?>
        <?php if(strlen($user['User']['website'])>0){?><strong>Website:</strong> <a href="<?php echo (substr($user['User']['website'],4)=='http'?$user['User']['website']:"//".$user['User']['website']);?>" target="_blank"><?php echo $user['User']['website']."<br />"; ?></a><?php } ?>
        <?php if($_SESSION['Auth']['User']['id']==$user['User']['id']){?><p><?php if(strlen($user['User']['websiteLogin'])>0){?><a href="mailto:<?php echo $user['User']['websiteLogin'];?>"><?php echo "<strong>Website Login:</strong> ".$user['User']['websiteLogin']."<br />"; ?></a><?php } ?><?php } ?>
 
        <?php if(strlen($user['User']['linkedIn'])>0){?><a href="<?php echo $user['User']['linkedIn'];?>" target="_blank"><?php echo "<strong>LinkedIn:</strong> ".$user['User']['linkedIn']; ?></a><?php } ?>     
        <?php echo "<p class='more'><a href='javascript: history.go(-1);' title='Broker Network'><i class='icon-circle-arrow-left'></i> GO BACK TO NETWORK</a></p>"; ?>
    </div>
  <!------------- show google map Div -->
  <div id='mapDiv'></div>
<?php
} 
 else if( !empty($postcodeSuburb) ){
     if ($options){ 
            echo '<div style="clear: both;">';
                    $jsString = "javascript:location.href='?group='+this.value;";
                    //$categoryOptions[0] = 'Select Network Group';
                    $groupValue = 3;
                    foreach ($options as $option){
                        $categoryOptions[$option['Group']['id']] = $option['Group']['group'];
                    }
                    $options = array();
                    foreach($categoryOptions as $key => $value){                        
                        $options[$key] = $value;
                    }                    
                    $attributes = array('div' => 'input', 'type' => 'radio', 'options' => $options, 'default' => $groupValue, 'onclick' => $jsString, 'style'=>'');
                    echo $this->Form->input('networkgroup', $attributes);
                    //echo $this->Form->input('select_network_group', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
                   
                
            echo '</div><hr>';      
	}
    
    ?>
  <div id="searchWrapper">
   <div id="search">
                    <p>Enter Postcode / Suburb&nbsp;
                    <input id="txtPostcode" name="txtPostcode" type="text"  value="<?php echo @$postcodeSuburb; ?>" style='width:25%;height:20px;'/>
                    <button class='btn btn-info' id="btn-search-postal-code" type="button" value='Search' style='height:34px;'>Search Broker</button>
                    </p>
   </div><br>
    <!------------- show google map Div -->
  <div id='mapDiv'></div>
  <?php
                    // don't paginate              
                $userList = FALSE;
                // get latitude and longitude                    
                $xml = getLatLongFromPostcodeOrSuburb($postcodeSuburb, "AU", 'AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8');
                $latitude = (double)@$xml->result->geometry->location->lat;
                $longitude = (double)@$xml->result->geometry->location->lng;
                // Check Latitude and Longitude exist in australia
                $locationExist = LatAndLngExistInAustralia($latitude, $longitude);
                if($locationExist == true){
                   $companies = getComapniesDetailsByLatAndLng(3, $latitude, $longitude);                  
                   foreach($companies as $company)
                   {
                    if($maxDistance < $company['Companies']['distance']){
                            $maxDistance = $company['Companies']['distance'];
                        }                       
                    // show all companies on map
                    //$entityLocations[] = array('lat' => $company['Companies']['latitude'], 'lng' => $company['Companies']['longitude']);
                    $entityLocations[] = array('lat' => $company['Companies']['latitude'], 'lng' => $company['Companies']['longitude'], 'compname' => $company['Companies']['companyName'], 'suburb' => $company['Companies']['streetSuburb']);
                    
                    echo "<div class='cc-company'>";
                    echo "<table class='alert alert-info'><tr><td style='width:30%;'><strong>{$company['Companies']['companyName']}</strong></td>";
                    echo "<td style='width:35%;'>{$company['Companies']['streetAddress']}, {$company['Companies']['streetSuburb']}</td>";                  

                    echo "<td style='width:10%;'><strong>{$company['Companies']['distance']} KM</strong></td>";
                    echo "<td style='width:20%; text-align: right'><i class='icon-plus-sign icon-2x fa-hide-show'></i><span class='brokerHideViewTxt'>View Brokers</span></td>";
                    echo '</tr></table>';
                    // show all brokers
                     echo "<div class='divBrokers' style='display:none;'>";
                     echo "<table class='table table-striped table-bordered table-hover' style='width:100%;'>";
                     echo '<tr><th>Name</th><th>Phone</th><th>Mobile</th><th>Email</th></tr>';
                     // Fetch all brokers for the company branch
                     $brokers = getBrokersByCompanyBranch(3, $company['Companies']['companyName'], $company['Companies']['streetAddress'], $company['Companies']['streetSuburb']);
                     foreach($brokers as $broker){
                         echo "<tr>";
                        echo "<td style='width:25%;'><a href='/users/view/{$broker['users']['id']}'>{$broker['users']['name']} {$broker['users']['surname']}</a></td>";
                         echo "<td style='width:20%;'>{$broker['users']['phone']}</td>";
                        echo "<td style='width:20%;'>{$broker['users']['mobile']}</td>";
                        echo "<td style='width:35%;'><a href='mailto:{$broker['users']['email']}'><i class='icon-envelope-alt' style='border:none'></i> {$broker['users']['email']}</a></td>";
                        echo "</tr>";
                     }
                     echo '</table>'; 
                     echo '</div>'; // div brokers   

                    echo '</div>';
                         
                   }
                }
                else {
                     echo "<div><h2>Sorry No Broker found in requested suburb or postcode.</h2></div>";
                }
 ?>
  </div> <!-- searchWrapper -->
                  
  <?php
 }
 else if($user) {
     
         echo $this->Html->css('paginateStyles.css');
			if (isset($javascript)) {
				echo $javascript->link('jquery.paginate.min.js');
				$this->set('page','network');
			}
?>
            <?php if ($options){ ?>
            <div style="clear: both;">
				<?php
                    $jsString = "javascript:location.href='?group='+this.value;";
                    //$categoryOptions[0] = 'Select Network Group';
                    foreach ($options as $option){
                        $categoryOptions[$option['Group']['id']] = $option['Group']['group'];
                    }
                    $options = array();
                    foreach($categoryOptions as $key => $value){                        
                        $options[$key] = $value;
                    }                    
                    if( !empty($_GET['group']) ){
                        $groupValue = $_GET['group'];
                    }                    
                    $attributes = array('div' => 'input', 'type' => 'radio', 'options' => $options, 'default' => $groupValue, 'onclick' => $jsString, 'style'=>'');
                    echo $this->Form->input('networkgroup', $attributes);
                    
                    /*if (!isset($_GET['group'])) {
                        echo $this->Form->input('select_network_group', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
                    } else {
                        $groupValue = $_GET['group'];
                        echo $this->Form->input('select_network_group', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
                    }*/
                ?>
            </div>
             <hr>
<?php        
	}
			if(@$groupValue != 3){ // Non Broker case
                        echo "<div id='paging_container'><div  class='content'>";                        
			foreach($user as $user_items):	
			   if ($user_items['User']['live'] == 1)  {
?>
				<div class="users view users-single">
                 <?php if(strlen($user_items['User']['logo'])>0) { 
                            echo "<div style='float: right; width: 70px; height: auto; margin: 10px; padding: 0px;'><img src='/app/webroot/uploads/users/{$user_items['User']['logo']}' width='70' /></div>";
                 }
                       ?>
                    <h4><a href="/users/view/<?php echo $user_items['User']['id'];?>"><?php echo $user_items['User']['name']." ".$user_items['User']['surname']; ?></a></h4>
                    <?php if(strlen($user_items['User']['companyName'])>0){ echo "<strong>Company Name:</strong> ".$user_items['User']['companyName']."<br />";}?>
                    <?php if(strlen($user_items['User']['phone'])>0 && (int)$user_items['User']['phone']>0){ echo "<strong>Phone:</strong> ".$user_items['User']['phone']."<br />";}?>
                    <?php if(strlen($user_items['User']['mobile'])>0 && (int)$user_items['User']['mobile']>0){ echo "<strong>Mobile:</strong> ".$user_items['User']['mobile']."<br />";}?>
        			<?php if(strlen($user_items['User']['email'])>0){?><strong>Email:</strong> <a href="mailto:<?php echo $user_items['User']['email'];?>"><?php echo $user_items['User']['email']; ?></a><?php } ?> <br clear='all' />                   
                </div>
<?php
			   }
			endforeach;
			echo "</div><br clear='all' />
                    <div class='info_text'></div>
                    <div class='page_navigation'></div>
                </div>";
               }
               else{?>
                    <div id="search">
                    <p>Enter Postcode / Suburb&nbsp;
                    <input id="txtPostcode" name="txtPostcode" type="text"  value="<?php echo @$postcodeSuburb; ?>" style='width:25%;height:20px;'/>
                    <button class='btn btn-info' id="btn-search-postal-code" type="button" value='Search' style='height:34px;'>Search Broker</button>
                    </p>
                    </div>
             <!------------- show google map Div -->
            <div style='width:100%;height:300px;' id='mapDiv'></div>
             <?php      
               }
	} 
        
                else {
			echo "<p>There are currently no members in this network. Please check back later.</p>";
		}
	//}
?>

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
                    var title = entityLocations[i].compname + ' , ' + entityLocations[i].suburb; 
                    var marker = new google.maps.Marker({
                    map: map,
                    label: (i + 1).toString(),
                    position: latlng,
                    icon:locationImg,
                    draggable: true
                    }); 
               var content = '<div class="alert alert-marker-info scrollFix" style="width:300px;">' + title + '</div>';    
               var infowindow = new google.maps.InfoWindow({disableAutoPan: true});
               
                google.maps.event.addListener(marker, 'mouseover', function(marker, content, infowindow) {
                return function() {
                infowindow.setContent(content);
                infowindow.open(map,marker);
                };                         
                }(marker,content,infowindow));

                google.maps.event.addListener(marker, 'mouseout', function(marker, content, infowindow) {
                return function() {               
                infowindow.close();
                };                         
                }(marker,content,infowindow));
                    
        } // end for
          } // end if length
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