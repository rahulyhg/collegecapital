<?php
        $page = "network";
	$keywords = "broker network, finance professionals, financial services, College Capital";
	$description = "Broker Network College Capital";
	$title = "Broker Network | College Capital";
	include("inc/head.php");
        include 'utility.php';
	$user = array();
        // used in javascript for marking all locations
        $entityLocations = array();
        // used for zoom level in map
        $maxDistance = 0.0;
	$err = false;
        $displayUserDetails = false;
        $companiesSearch = false; // check if company details found
        // postal code and suburb
        $postcodeSuburb = '';
	$errMessage = "<p>Sorry, the broker details you are trying to access is invalid. Please <a href='/networksearch' title='Broker Network'>click here</a> to see the complete broker list.</p>";
         
        // single broker page
	if( !empty($_GET['id']) ){		
		$userID = trim($_GET['id']);
		if($userID > 0){
			$userDetails = getDetailsFromUserID($userID); //all brokers. Refer `groups` table for more details
			while($rowUsers = mysql_fetch_array($userDetails, MYSQL_ASSOC)){
                                $displayUserDetails = true;
				$user['name'] = @$rowUsers['name'];
				$user['surname'] = @$rowUsers['surname'];
				$user['position'] = $rowUsers['position'];
				$user['companyName'] = $rowUsers['companyName'];
				$user['email'] = $rowUsers['email'];
				$user['phone'] = $rowUsers['phone'];
				$user['mobile'] = $rowUsers['mobile'];
				$user['logo'] = $rowUsers['logo'];
				$user['fax'] = $rowUsers['fax'];
				$user['streetAddress'] = $rowUsers['streetAddress'];
				$user['streetSuburb'] = $rowUsers['streetSuburb'];
				$user['streetPostcode'] = $rowUsers['streetPostcode'];
                                // longtiude and latitude
                                $user['longitude'] = $rowUsers['longitude'];
                                $user['latitude'] = $rowUsers['latitude'];                                
				$user['street_state'] = @$rowUsers['street_state'];
				$user['postalAddress'] = @$rowUsers['postalAddress'];
				$user['postalSuburb'] = @$rowUsers['postalSuburb'];
				$user['postalPostcode'] = @$rowUsers['postalPostcode'];
				$user['postal_state'] = @$rowUsers['postal_state'];
				$user['website'] = @$rowUsers['website'];
				$user['websiteLogin'] = @$rowUsers['websiteLogin'];
				$user['linkedIn'] = @$rowUsers['linkedIn'];
				$user['googleMap'] = @$rowUsers['googleMap'];   
                                
                                // check if latitude and longtitude exist
                                if( empty($user['longitude']) ){
                                    $fullAddress = formatAddress($user['streetAddress'], $user['streetSuburb']);
                                    if( !empty($fullAddress) ){
                                        getLongituteAndLatitute($fullAddress);
                                        $user['longitude'] = $longitude;
                                        $user['latitude'] = $latitude;
                                        // update new values in database also
                                        updateUserLatAndLng($userID, $latitude, $longitude);
                                    }
                                }
                                else{
                                    $latitude = $user['latitude'];
                                    $longitude = $user['longitude'];
                                }
				
                                $entityLocations[] = array('lat' => $latitude, 'lng' => $longitude, 'compname' => $user['companyName'], 'suburb' => $user['streetSuburb']);
			}
		} else {
			$err = true;	
		}
	} 
        // postal code AND suburb
        else if( !empty($_GET['pcsu']) ){
            $postcodeSuburb = trim($_GET['pcsu']);
            //$allUsers; 
            if( strlen($postcodeSuburb) > 0){
            // get all brokers in 5km radius
            $xml = getLatLongFromPostcodeOrSuburb($postcodeSuburb, "AU", 'AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8');
            $latitude = (double)@$xml->result->geometry->location->lat;
            $longitude = (double)@$xml->result->geometry->location->lng;
            // Check Latitude and Longitude exist in australia
            $locationExist = LatAndLngExistInAustralia($latitude, $longitude);
            if($locationExist == true){
            $allCompanies = getComapniesDetailsByLatAndLng(3, $latitude, $longitude);
            // query database
            //$allUsers = getAllUsersByLatAndLng(3, $latitude, $longitude); 
	    while($company = mysql_fetch_array($allCompanies, MYSQL_ASSOC)){
                        // get maximum distance for MAP zoom level
                        if($maxDistance < $company['distance']){
                            $maxDistance = $company['distance'];
                        }                       
                    $entityLocations[] = array('lat' => $company['latitude'], 'lng' => $company['longitude'], 'compname' => $company['companyName'], 'suburb' => $company['streetSuburb']);
                    $companiesSearch = true;
		}		
		$err = false;
            }
            else{
               $err = true;      
            }
	}
        else{
            $err = true;            
        }
    }
    else{
        $err = true;
    }
        
?>
<?php if($err == false){ ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<?php } ?>

<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		/*$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : 10	//set this value accordingly for number of brokers to be displayed on the page
		}); */
        
        // expnad brokers
        $(document).on('click', '.fa-hide-show', function(){
            
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
        $('#btn-search-postal-code').on('click', function(){  
                            RedirectToSelf();             
                });
                
        $('#txtPostcode').on("keypress", function(e) 
                {
                    if (e.keyCode == 13) {
                    RedirectToSelf();
                    }
                }); 
                
        
                
        var entityLocations = <?php echo json_encode($entityLocations); ?>;        
        var distance = parseFloat("<?php echo $maxDistance;?>");
        //alert(entityLocations.length);
        var zoomLevel = GetZoomLevel(distance);
        //alert(distance + ' => ' + zoomLevel);
      var locationImg = $('#site_path').val() + '/images/location-marker.png';     
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
                        //title: title,
                        label: (i + 1).toString(),
                        position: latlng,
                        icon:locationImg,                        
                        draggable: true
                    }); 
                    
             var content = '<div class="alert alert-marker-info" style="height:20px;margin:10px;padding:10px;">' + title + '</div>';    
             var infowindow = new google.maps.InfoWindow({disableAutoPan: true});
               
                google.maps.event.addListener(marker, 'mouseover', function(marker,content,infowindow) {
                return function() {
                infowindow.setContent(content);
                infowindow.open(map,marker);
                };                         
                }(marker,content,infowindow));

                google.maps.event.addListener(marker, 'mouseout', function(marker,content,infowindow) {
                return function() {               
                infowindow.close();
                };                         
                }(marker,content,infowindow));
                
               }
            }          
        
   }); // end ready   

  
   function GetZoomLevel(distance)
   {
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
   
   function RedirectToSelf()
   {
    var postalCodeSuburb = $('#txtPostcode').val().trim();            
    if(postalCodeSuburb.length <= 0 ){
        alert("Enter Postcode or Suburb");
        $('#txtPostcode').focus();
        return;        
    }
    var location = $('#site_path').val() + 'networksearch' + '?pcsu=' + postalCodeSuburb;
    window.location.href = location; 
   }
	
</script>
<div id="page-banner"><h1>Broker Network</h1></div>
<div id="col-wide">

    <?php if($displayUserDetails == false){ ?>
    <div id="searchTxt" >
    <h3>College Capital Brokers have been carefully selected and referenced to ensure they share our vision to uphold the highest level of integrity and knowledge. </h3>
    <p>We are proud to have originated College Capital from a Victorian footprint. Our broker members are predominately Victorian based together with concentrated representation in Southern NSW.</p>
    </div>
    <div id="search">
    <p>Enter Postcode / Suburb&nbsp;
          <input id="txtPostcode" name="txtPostcode" type="text"  value="<?php echo @$postcodeSuburb; ?>" style='width:25%;height:20px;'/>
          <button class='btn btn-info' id="btn-search-postal-code" type="button" value='Search' style='height:34px;'>Search Broker</button>
      </p>
    </div>
    <div style="clear: both; height: 20px;"> </div>
    <?php }?>
    <div id="searchWrapper">
	<?php if($displayUserDetails){
        	if($err){
				echo $errMessage;	
			} else {
				// display user/broker details
				echo "<h2>".$user['name'].(strlen($user['surname'])>0?" ".$user['surname']:"")."</h2>";
                echo (strlen($user['logo'])>0?"<div style='width: 150px; float: right; padding: 0px 10px 0px 0px;'><img src='".$ccap_url."app/webroot/uploads/users/".trim($user['logo'])."' title='".$user['name']."  ".(strlen($user['surname'])>0?$user['surname']:"")."' /></div>":"");
				echo "<p>";                               
				echo (strlen($user['position'])>0?"<br /><strong>Position:</strong> ".$user['position']:"");
				echo (strlen($user['companyName'])>0?"<br /><strong>Company:</strong> ".$user['companyName']:"");
				echo (strlen($user['email'])>0?"<br /><strong>Email:</strong> <a href='mailto:".$user['email']."'>".$user['email']."</a>":"");
				echo (strlen($user['phone'])>0 && (int)$user['phone']>0?"<br /><strong>Phone :</strong> ".$user['phone']:"");
				echo (strlen($user['mobile'])>0 && (int)$user['mobile']>0?"<br /><strong>Mobile:</strong> ".$user['mobile']:"");
				echo (strlen($user['fax'])>0 && (int)$user['fax']>0?"<br /><strong>Fax:</strong> ".$user['fax']:"");
				echo (strlen($user['streetAddress'])>0?"<br /><strong> Address :</strong> ".$user['streetAddress'].(strlen($user['streetSuburb'])>0?", ".$user['streetSuburb']:"").(@$user['street_state_id']!=11?", ".$user['street_state']:"").(strlen($user['streetPostcode'])>0?", ".$user['streetPostcode']:""):"");
				echo (strlen($user['postalAddress'])>0?"<br /><strong>Postal Address :</strong> ".$user['postalAddress'].(strlen($user['postalSuburb'])>0?", ".$user['postalSuburb']:"").(@$user['postal_state_id']!=11?", ".@$user['postal_state']:"").(strlen($user['postalPostcode'])>0?", ".$user['postalPostcode']:""):"");
				echo (strlen($user['googleMap'])>0?"<br /><strong>Map Link:</strong> <a href='".$user['googleMap']."' title='View Map'>View Map</a>":"");
				echo (strlen($user['website'])>0?"<br /><strong>Website:</strong> <a href='".(substr($user['website'],4)=='http'?$user['website']:"//".$user['website'])."' title='Website Link' target='_blank'>".$user['website']."</a>":"");
				echo (strlen($user['websiteLogin'])>0?"<br /><strong>Website Login:</strong> <a href='".$user['websiteLogin']."' title='Website Link'>".$user['websiteLogin']."</a>":"");
				echo (strlen($user['linkedIn'])>0?"<br /><strong>LinkedIn Profile:</strong> <a href='".$user['linkedIn']."' title='LinkedIn Profile Link'>".$user['linkedIn']."</a>":"");
				
				echo "<br clear='all' />";
				echo "<p class='more'><a href='javascript: history.go(-1);' title='Broker Network'><i class='icon-circle-arrow-left'></i> GO BACK TO BROKER NETWORK</a></p>";

				echo "</p>";
                                
                                // show google map                                                          
                                echo "<div style='width:100%;height:300px;' id='mapDiv'></div>";                                   
                             
			}
		  } else { ?>      
	<?php       
		if($companiesSearch == true){ 
                    // show google map                                                          
                   echo "<div style='100%;height:300px;' id='mapDiv'></div><br>"; 
                   // populate data 
                   mysql_data_seek($allCompanies, 0);
                    while($company = mysql_fetch_array($allCompanies, MYSQL_ASSOC)){                       
                        echo "<div class='cc-company'>";                         
                         echo "<table class='alert alert-info' style='width:100%;margin:0px;padding:0px;'><tr><td style='width:30%;'><strong>{$company['companyName']}</strong></td>";
                         echo "<td style='width:40%;'>{$company['streetAddress']}, {$company['streetSuburb']}";
                         if( !empty($company['streetPostcode']) ){
                             echo " - {$company['streetPostcode']}";
                         }
                         echo '</td>';
                         
                         echo "<td style='width:10%;'><strong>{$company['distance']} KM</strong></td>";
                         echo "<td style='width:20%; text-align: right'><i class='icon-plus-sign icon-2x fa-hide-show'></i><span class='brokerHideViewTxt'>View Brokers</span></td>";
                         echo '</tr></table>';
                         
                         // show all brokers
                         echo "<div class='divBrokers' style='display:none;'>";
                         echo "<table class='table table-striped table-bordered table-hover' style='width:100%;'>";
                         echo '<tr><th>Name</th><th>Phone</th><th>Mobile</th><th>Email</th></tr>';
                         // Fetch all brokers for the company branch
                         $brokers = getBrokersByCompanyBranch(3, $company['companyName'], $company['streetAddress'], $company['streetSuburb']);
                          while($broker = mysql_fetch_array($brokers, MYSQL_ASSOC)){
                              // check if broker latitude and longitude is empty
                               if( empty($broker['longitude']) ){
                                    $fullAddress = formatAddress($broker['streetAddress'], $broker['streetSuburb']);
                                    if( !empty($fullAddress) ){
                                        getLongituteAndLatitute($fullAddress);                                      
                                        // update new values in database also
                                        updateUserLatAndLng($broker['id'], $latitude, $longitude);
                                    }
                                }
                            echo "<tr>";
                            echo "<td style='width:25%;'><a href='$site_path/networksearch?id={$broker['id']}'>{$broker['name']} {$broker['surname']}</a></td>";
                            //echo "<td style='width:25%;'>{$broker['companyName']}</td>";
                             echo "<td style='width:20%;'>{$broker['phone']}</td>";
                            echo "<td style='width:20%;'>{$broker['mobile']}</td>";
                            echo "<td style='width:35%;'><a href='mailto:{$broker['email']}'><i class='icon-envelope-alt' style='border:none'></i> {$broker['email']}</a></td>";
                            //echo "<td style='width:15%;'>{$broker['streetPostcode']}</td>";
                            echo "</tr>";
                          }
                          echo '</table>';                      
                         echo '</div>'; // div brokers                         
                         echo '</div>'; // div company
                    }
		}
                else{
                    // first time 
                    if(isset($_GET['pcsu']) ){
                        echo "<div><h2>Sorry No Broker found in requested suburb or postcode.</h2></div>";
                     }
                }
	} ?>
   
</div>
</div>

<?php include("inc/foot.php"); ?>
