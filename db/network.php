<?php
	$page = "network";
	$keywords = "broker network, finance professionals, financial services, College Capital";
	$description = "Broker Network College Capital";
	$title = "Broker Network | College Capital";
	include("inc/head.php");
	$user = array();
	$err = false;
	$errMessage = "<p>Sorry, the broker details you are trying to access is invalid. Please <a href='/network' title='Broker Network'>click here</a> to see the complete broker list.</p>";
	if(isset($_GET['paramName']) && strlen($_GET['paramName'])){
		//print_r(explode("|",trim($_GET['paramName'])));
		$displayUserDetails = true;
		$userID = getUserIDFromName(trim($_GET['paramName']));
		if($userID > 0){
			$userDetails = getUserDetailsFromID($userID); //all brokers. Refer `groups` table for more details
			while($rowUsers = mysql_fetch_array($userDetails, MYSQL_ASSOC)){
				$user['name'] = $rowUsers['name'];
				$user['surname'] = $rowUsers['surname'];
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
				$user['street_state'] = $rowUsers['street_state'];
				$user['postalAddress'] = $rowUsers['postalAddress'];
				$user['postalSuburb'] = $rowUsers['postalSuburb'];
				$user['postalPostcode'] = $rowUsers['postalPostcode'];
				$user['postal_state'] = $rowUsers['postal_state'];
				$user['website'] = $rowUsers['website'];
				$user['websiteLogin'] = $rowUsers['websiteLogin'];
				$user['linkedIn'] = $rowUsers['linkedIn'];
				$user['googleMap'] = $rowUsers['googleMap'];
				
			}
		} else {
			$err = true;	
		}
	} else {
		$allUsers = getAllUsersPerGroup(3); //all brokers. Refer `groups` table for more details
		while($rowUsers = mysql_fetch_array($allUsers, MYSQL_ASSOC)){
			$user['name'][] = $rowUsers['name'];
			$user['surname'][] = $rowUsers['surname'];
			$user['email'][] = $rowUsers['email'];						
			$user['companyName'][] = $rowUsers['companyName'];
			$user['phone'][] = $rowUsers['phone'];
			$user['mobile'][] = $rowUsers['mobile'];
			$user['logo'][] = $rowUsers['logo'];
		}
		$displayUserDetails = false;
		$err = false;
	}
?>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : 10	//set this value accordingly for number of brokers to be displayed on the page
		});
	});
</script>
<div id="page-banner"><h1>Broker Network</h1></div>
    <div id="col-left">
      <p>Whilst our foundation is important the College Capital vision is to become a truly national business. </p>

</div>
    <div id="col-right">
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
				echo (strlen($user['streetAddress'])>0?"<br /><strong> Address :</strong> ".$user['streetAddress'].(strlen($user['streetSuburb'])>0?", ".$user['streetSuburb']:"").($user['street_state_id']!=11?", ".$user['street_state']:"").(strlen($user['streetPostcode'])>0?", ".$user['streetPostcode']:""):"");
				echo (strlen($user['postalAddress'])>0?"<br /><strong>Postal Address :</strong> ".$user['postalAddress'].(strlen($user['postalSuburb'])>0?", ".$user['postalSuburb']:"").($user['postal_state_id']!=11?", ".$user['postal_state']:"").(strlen($user['postalPostcode'])>0?", ".$user['postalPostcode']:""):"");
				echo (strlen($user['googleMap'])>0?"<br /><strong>Map Link:</strong> <a href='".$user['googleMap']."' title='View Map'>View Map</a>":"");
				echo (strlen($user['website'])>0?"<br /><strong>Website:</strong> <a href='".(substr($user['website'],4)=='http'?$user['website']:"//".$user['website'])."' title='Website Link' target='_blank'>".$user['website']."</a>":"");
				echo (strlen($user['websiteLogin'])>0?"<br /><strong>Website Login:</strong> <a href='".$user['websiteLogin']."' title='Website Link'>".$user['websiteLogin']."</a>":"");
				echo (strlen($user['linkedIn'])>0?"<br /><strong>LinkedIn Profile:</strong> <a href='".$user['linkedIn']."' title='LinkedIn Profile Link'>".$user['linkedIn']."</a>":"");
				
				echo "<br clear='all' />";
				echo "<p class='more'><a href='javascript: history.go(-1);' title='Broker Network'><i class='icon-circle-arrow-left'></i> GO BACK TO BROKER NETWORK</a></p>";

				echo "</p>";
			}
		  } else { ?>
        <h3>College Capital Brokers have been carefully selected and referenced to ensure they share our vision to uphold the highest level of integrity and knowledge. </h3>
        <p>We are proud to have originated College Capital from a Victorian footprint. Our broker members are predominately Victorian based together with concentrated representation in Southern NSW.      </p><br />
 
	<?php 
		if(count($user['name'])>0){
			echo "<div id='paging_container' class='container'><div id='users' class='content'>";
			for($i=0;$i<count($user['name']);$i++){
				echo "<div class='users'>
						".(strlen($user['logo'][$i])>0?"<div style='width: 70px; float: right; padding: 0px 10px 0px 0px;'><img src='".$ccap_url."app/webroot/uploads/users/".trim($user['logo'][$i])."' title='".$user['name'][$i]."  ".(strlen($user['surname'][$i])>0?$user['surname'][$i]:"")."' /></div>":"")."
						<h3><a href='".$site_path."network/".str_replace(" ","-",strtolower($user['name'][$i])).(strlen($user['surname'][$i])>0?"|".str_replace(" ","-",strtolower($user['surname'][$i])):"")."' title='".$user['name'][$i]."  ".(strlen($user['surname'][$i])>0?$user['surname'][$i]:"")."'>".$user['name'][$i]."  ".(strlen($user['surname'][$i])>0?$user['surname'][$i]:"")."</a></h3>
						".(strlen($user['companyName'][$i])>0?"<br />Company: ".$user['companyName'][$i]:"").
						(strlen($user['phone'][$i])>0 && (int)$user['phone'][$i]>0?"<br />Phone: ".$user['phone'][$i]:"").
						(strlen($user['mobile'][$i])>0 && (int)$user['mobile'][$i]>0?"<br />Mobile: ".$user['mobile'][$i]:"").
						(strlen($user['email'][$i])>0?"<br /><a href='mailto:".$user['email'][$i]."'><i class='icon-envelope-alt' style='border:none'></i> ".$user['email'][$i]:"")."</a>".
					  "</div>";
			}
			echo "</div>
				  <br clear='all' />
            	  <div class='info_text'></div>
            	  <div class='page_navigation'></div>
				</div>";
		}
	} ?>
	</div>
</div>
<?php include("inc/foot.php"); ?>