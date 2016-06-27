<?php echo $jQValidator->validator(); 
?>
<div class="claimsLenders form">
<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['ClaimsLender']['id']; ?></div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('ClaimsLender', array('class'=>'editForm'));
		echo $this->Form->input('id');
		echo $this->Form->input('lender');
		//******************************************************
        // CHANGE REQUEST: Nyree 24/2/14	
		//******************************************************
		echo $this->Form->input('vbi', array('type' => 'checkbox', 'label'=>'VBI Applicable'));
		
		$termOptions = array('' => 'None', '12' => '12 months', '24' => '24 months', '36' => '36 months');
		echo $this->Form->input('term', array('label'=>'VBI Term (greater than)','class'=>'text', 'type' => 'select', 'options' => $termOptions));
		
		echo $this->Form->input('amount', array('label' => 'VBI Cutoff Amount (greater than)', 'type'=>'text','id' => 'amount', 'after' => '&nbsp;<em>Please do not use , (comma). E.g. 1000.50</em>', 'before' => '$ ', 'value' => '0.00', 'value' => number_format((float)$this->data['ClaimsLender']['amount'],2,'.','')));
		//******************************************************
		
		//******************************************************
        // CHANGE REQUEST: Nyree 10/6/14	
		//******************************************************
		if (($this->data['ClaimsLender']['changeUser'] != "") && ($this->data['ClaimsLender']['changeUser'] != 0)) {
		   $changeDate = date('d/m/Y h:i:s', strtotime($this->data['ClaimsLender']['changeDate']));			  

		   echo "<label style='margin-left:190px'><font color='red'><u>Lender Changed</u><br />By: " . $changeUserName[0]["Users"]["name"] . " " . $changeUserName[0]["Users"]["surname"] . "<br />On: " . $changeDate . "</font></label>";
		   echo "<br /><br /><br /><br />";
		}			
	   //******************************************************
			   
		?>
    	<div id="record_wrap">
            <div class="record_row_desc" id="record_row">
                <div id="record_detail">&nbsp;</div>
            </div>
            <div class="record_row_data" id="record_row">
                <div id="record_data">
		<?php 
				echo $this->Form->button('Submit', array('type'=>'submit'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));
				$url = array('action'=>'index');
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>
        		</div>
            </div>
        </div>
	</div>
</div>