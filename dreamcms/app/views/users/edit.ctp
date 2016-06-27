<?php echo $jQValidator->validator(); ?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$('#UserCheckPwd').click(function(){
			if($('#UserCheckPwd').is(':checked')){
				$('#showPwdFields').css('display','block');
				//$('#UserCheckPwd').val(1);
			} else {
				$('#showPwdFields').css('display','none');
				//$('#UserCheckPwd').val(0);					
			}
		});
		$('#UserEditForm').submit(function(){
			if($('#UserCheckPwd').is(':checked')){
				if($('#UserNpassword').val() == '' || $('#UserNpassword').val() == null){
					alert('Please enter new password');
					return false;	
				}
				if($('#UserNpassword').val() !=$('#UserCpassword').val()){
					alert('Your passwords do not seem to match. Please type your passwords again.');
					return false;
				}
			}
		});
	});
	function uploadFile(opt, variable, fld){
		// opt    :: option
		// fld    :: folder
		// values :: 
		//           0 = image (general)
		//           1 = image
		//           2 = image
		//           3 = audio file
		//           4 = media file
		var mywin = window.open("<?php echo Configure::read('Company.url');?>app/webroot/uploads/upload.php?id=<?php echo $this->data['User']['id']; ?>&opt="+opt+"&variable="+variable+"&fld="+fld,"uploadwindow","width=400,height=200");
		mywin.focus();
	}
</script>
<div class="users form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo @$this->data['User']['id']; ?></div>
        	</div>
    	</div>
	<?php 
		echo $this->Form->create('User', array('class'=>'editForm'));
		
		echo $this->Form->input('username', array('label' => 'Username *'));
		
		echo $this->Form->input('checkPwd',array('label'=>'Change Password?','type'=>'checkbox','class'=>'checkbox'));
		echo "<div id='showPwdFields' style='display: none;'>";
		echo $this->Form->input('npassword',array('label'=>'New Password','type'=>'password'));
		echo $this->Form->input('cpassword',array('label'=>'Retype Password','type'=>'password'));
		echo "</div>";		
		
		foreach ($options as $option){
			$categoryOptions[$option['Groups']['id']] = $option['Groups']['group'];
		}
	    $categoryOptions[0] = 'Select Group';
		$categoryOptions = array_reverse($categoryOptions, true);
		echo $this->Form->input('group_id', array('label' => 'Group *', 'type' => 'select', 'escape' => false, 'options' => $categoryOptions));
		
		$shOptions[0] = 'None';
		foreach ($shareholders as $shareholder){
			$shOptions[$shareholder['User']['id']] = $shareholder['User']['companyName'];
		}
		echo $this->Form->input('parent_user_id', array('label' => 'Shareholder *', 'type' => 'select', 'escape' => false, 'options' => $shOptions));
		
		foreach ($us_options as $us_options){
			$usCategoryOptions[$us_options['UserStatuses']['id']] = $us_options['UserStatuses']['status'];
		}
		echo $this->Form->input('status_id', array('label' => 'Status *','type' => 'select', 'escape' => false, 'options' => $usCategoryOptions));
		
		echo $this->Form->input('name', array('label' => 'First Name *'));
		echo $this->Form->input('surname', array('label' => 'Surname *'));
		echo $this->Form->input('position');
		echo $this->Form->input('companyName');
		echo $this->Form->input('email', array('label' => 'Email *'));
		echo $this->Form->input('mobile',array('after' => ' <em>e.g. 041 234 5678</em>'));
		echo $this->Form->input('phone',array('after' => ' <em>e.g. 031 234 5678</em>'));
		echo $this->Form->input('fax',array('after' => ' <em>e.g. 031 234 5555</em>'));
		
		echo $this->Form->input('streetAddress');
		//$stStates[0] = 'Please Select';
		foreach ($stateOptions as $stState){
			$stStates[$stState['Tblstate']['ID']] = $stState['Tblstate']['State'];
		}		
		echo $this->Form->input('streetSuburb');
		echo $this->Form->input('street_state_id', array('label' => 'State (Street Address)','type' => 'select', 'escape' => false, 'options' => $stStates));
		echo $this->Form->input('streetPostcode');
		echo $this->Form->input('postalAddress');
		echo $this->Form->input('postalSuburb');
		//$ptStates[0] = 'Please Select';
		foreach ($stateOptions as $ptState){
			$ptStates[$ptState['Tblstate']['ID']] = $ptState['Tblstate']['State'];
		}
		echo $this->Form->input('postal_state_id', array('label' => 'State (Postal Address)','type' => 'select', 'escape' => false, 'options' => $ptStates));
		echo $this->Form->input('postalPostcode');
				
		echo $this->Form->input('googleMap');
		echo $this->Form->input('website', array('after' => ' <em>(General)</em>'));
		echo $this->Form->input('websiteLogin', array('after' => ' <em>(User Login - applicable to banks)</em>'));
		echo $this->Form->input('linkedIn');
		
		if(strlen($this->data['User']['logo'])<=0){
			$jsString1 = "javascript:uploadFile('1', 'UserLogo', 'users');document.getElementById('UserLogo_img').src='".Configure::read('Company.url')."app/webroot/uploads/users/'+document.getElementById('UserLogo').value";
			echo '<div class="input file">';
			echo '<label for="UserLogo">Logo</label>';
			echo '<input readonly="true" name="data[User][logo]" id="UserLogo" value="'.$this->data['User']['logo'].'">';
			echo '<input name="uploadUserLogo" type="button" class="uploadButton" id="uploadUserLogo" onMouseUp="'.$jsString1.'" value="Upload File">';
			$jsString2 = "javascript:document.getElementById('UserLogo').value=''; document.getElementById('UserLogo_img').src='".Configure::read('Company.url')."app/webroot/uploads/users/blank.gif'";
			echo '<input name="removeUserLogo" type="button" class="uploadButton" id="removeUserLogo" onMouseUp="'.$jsString2.'" value="Remove File" /><br /><em>Recommended image size: 105px x 97px</em>';
			echo '<div style="width:120px; height: 100px;padding:0px 50px 0px 0px;float: right;">';
			echo '<img src="'.Configure::read('Company.url').'app/webroot/uploads/users/blank.gif"  id="UserLogo_img" name="UserLogo_img" height="100">';
			echo '</div>';
			echo '</div>';
		} else { ?>
			<div class="input">
            	<label for="UserLogo">Logo</label>
            	<img src="<?php echo Configure::read('Company.url');?>app/webroot/uploads/users/<?php echo $this->data['User']['logo'];?>" height="100"/>
				<?php echo $this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'deletefile', $this->data['User']['id']), array('escape' => false,'id'=>'record','title'=>'delete file'), sprintf(__('Are you sure you want to delete this file?', true)));?><br clear='all'><span style="margin-left:187px;"><em>Recommended image size: 105px x 97px</em></span>
             </div>
		<?php
        }
		echo $this->Form->input('live', array('type' => 'checkbox', 'label'=>'Push content Live?', 'class'=>'checkbox'));
	?>

		<?php 
				echo $this->Form->button('Submit', array('type'=>'submit','style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('contoller'=>'users','action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>

	</div>
</div>