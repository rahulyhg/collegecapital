<?php echo $jQValidator->validator(); ?>
<script type="text/javascript" language="javascript">
function uploadFile(opt, variable, fld){
	// opt    :: option
	// fld    :: folder
	// values :: 
	//           0 = image (general)
	//           1 = image
	//           2 = image
	//           3 = audio file
	//           4 = media file
	var mywin = window.open("<?php echo Configure::read('Company.url');?>app/webroot/uploads/upload.php?id=<?php echo $this->data['Client']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
	mywin.focus();
}
</script>

<div class="users form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Users</div>
        	</div>
    	</div>
	<?php 
		echo $this->Form->create('Client', array('class'=>'editForm'));
		echo $this->Form->input('name', array('label' => 'First Name *'));
		echo $this->Form->input('surname', array('label' => 'Surname *'));
		
		foreach ($options as $option){
			$categoryOptions[$option['ClientsCategory']['id']] = $option['ClientsCategory']['category'];
		}
		echo $this->Form->input('category_id', array('label' => 'Category *', 'type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		
		foreach ($us_options as $us_options){
			$usCategoryOptions[$us_options['UserStatuses']['id']] = $us_options['UserStatuses']['status'];
		}
		echo $this->Form->input('status_id', array('label' => 'Status *','type' => 'select', 'escape' => false, 'options' => $usCategoryOptions));
		
		echo $this->Form->input('position');
		echo $this->Form->input('companyName');
		echo $this->Form->input('email', array('label' => 'Email *'));
		echo $this->Form->input('mobile',array('after' => ' <em>e.g. 041 234 5678</em>'));
		echo $this->Form->input('phone',array('after' => ' <em>e.g. 031 234 5678</em>'));
		echo $this->Form->input('fax',array('after' => ' <em>e.g. 031 234 5555</em>'));
		
		echo $this->Form->input('streetAddress');
		echo $this->Form->input('streetSuburb');
		//$stStates[0] = 'Please Select';
		foreach ($stateOptions as $stState){
			$stStates[$stState['Tblstate']['ID']] = $stState['Tblstate']['State'];
		}
		echo $this->Form->input('street_state_id', array('label' => 'State (Street Address)','type' => 'select', 'escape' => false, 'options' => $stStates, 'default' => 11));
		echo $this->Form->input('streetPostcode');
		echo $this->Form->input('postalAddress');
		echo $this->Form->input('postalSuburb');
		//$ptStates[0] = 'Please Select';
		foreach ($stateOptions as $ptState){
			$ptStates[$ptState['Tblstate']['ID']] = $ptState['Tblstate']['State'];
		}
		echo $this->Form->input('postal_state_id', array('label' => 'State (Postal Address)','type' => 'select', 'escape' => false, 'options' => $ptStates, 'default' => 11));
		echo $this->Form->input('postalPostcode');
				
		echo $this->Form->input('googleMap');
		echo $this->Form->input('website', array('after' => ' <em>(General)</em>'));
		echo $this->Form->input('linkedIn');
		
		//Profile Photo
		$jsString1 = "javascript:uploadFile('1', 'ClientLogo', 'clients');document.getElementById('ClientLogo_img').src='".Configure::read('Company.url')."app/webroot/uploads/clients/'+document.getElementById('ClientLogo').value";
		echo '<div class="input file">';
		echo '<label for="ClientLogo">Logo</label>';
		echo '<input readonly="true" name="data[Client][logo]" id="ClientLogo" value="'.$this->data['Client']['logo'].'">';
		echo '<input name="uploadClientLogo" type="button" class="uploadButton" id="uploadClientLogo" onMouseUp="'.$jsString1.'" value="Upload File">';
		$jsString2 = "javascript:document.getElementById('ClientLogo').value=''; document.getElementById('ClientLogo_img').src='".Configure::read('Company.url')."app/webroot/uploads/clients/blank.gif'";
		echo '<input name="removeClientLogo" type="button" class="uploadButton" id="removeClientLogo" onMouseUp="'.$jsString2.'" value="Remove File" /><br /><em>Recommended image size: 105px x 97px</em>';
		echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
		echo '<img src="'.Configure::read('Company.url').'app/webroot/uploads/clients/blank.gif"  id="ClientLogo_img" name="ClientLogo_img" height="100">';
		echo '</div>';
		echo '</div>';
		//Profile Photo code ends here
        
	?>
      		<?php 
				echo $this->Form->button('Submit', array('type'=>'submit','style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('contoller'=>'news','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
			?>

	</div>
</div>