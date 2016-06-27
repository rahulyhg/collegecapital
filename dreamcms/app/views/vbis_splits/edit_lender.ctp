<script language="javascript" type="text/javascript">
    function button_onclick(strAction)  {					
		//strDomainName = "echo00/ccap.collegecapital/index.php";
		strDomainName = "ccap.collegecapital.com.au";
		
		strGroup = document.getElementById("VbisSplitBrokerId").value;		
		strMonth = document.getElementById("VbisSplitPeriodMonth").value;
		strYear = document.getElementById("VbisSplitPeriodYear").value;
	
		location.href="http://" + strDomainName + "/vbis_splits/" + strAction + "/home/page:1/group:" + strGroup + "/month:" + strMonth + "/year:" + strYear;
	}
</script>
<?php 
echo $jQValidator->validator(); 
$this->set('page','vbisSplit');?>
<div class="vbisSplits form">
    <div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['VbisSplit']['id']; ?></div>
        	</div>
    	</div>
        <?php
		if($this->data['VbisSplit']['status'] == 1 && $_SESSION['Auth']['User']['group_id']==3){
			echo "<p>Sorry, you cannot edit this VBI Split. It has already been closed.</p>";
			$url = array('action'=>'index');
			echo $this->Form->button('Return to VBI Split', array('type'=>'button', 'style' => 'width: auto;', 'onclick'=>"window.location='".$this->Html->url($url)."'"));
		} else {
			echo $this->Form->create('VbisSplit', array('class'=>'editForm')); ?>
			<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">
			<?php
				echo $this->Form->button('Submit', array('type'=>'submit'));							
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
			?>	
			</div>	
			<?php
			echo $this->Form->input('id');
						
			// Lenders List    
		    foreach ($lenderOptions as $lenderOption){			
			    // CHANGE REQUEST Nyree 06/07/2015
				// Combining of ANZ and ANZ Edge Transactions
				if ($lenderOption['ClaimsLender']['id'] == 1)  {
				   if (($this->data['VbisSplit']['lender_id'] == 1) || ($this->data['VbisSplit']['lender_id'] == 17))  {
					  $lenderId = $this->data['VbisSplit']['lender_id'];
				   } else  {
					  $lenderId = $lenderOption['ClaimsLender']['id'];
				   }	
				   $lenders[$lenderId] = $lenderOption['ClaimsLender']['lender'] . " / ANZ Edge";
				} else if ($lenderOption['ClaimsLender']['id'] == 17)  {
				   // Do Nothing for Lender ANZ Edge as combined with ANZ
				} else  {
				   $lenders[$lenderOption['ClaimsLender']['id']] = $lenderOption['ClaimsLender']['lender'];
				}
				// END CHAGE REQUEST			   
		    }
		    echo $this->Form->input('lender_id', array('label'=>'Lender', 'type' => 'select', 'escape' => false, 'options' => $lenders));		
				
			$todayYear = date("Y");
		    $todayMonth = date("m");
		    $months = array();
		    for ($i=1; $i<=12; $i++)  {
		    	$timestamp = mktime(0,0,0,$i,1,$todayYear);
		    	$months[$i] = date("M", $timestamp);
		    }
			
			echo "<div>";
            echo $form->input('period_month' , array('label' => 'Period', 'type'=>'select', 'div' => '','style'=>'width:70px;', 'options' => $months, 'default' => date("m", strtotime($this->data['VbisSplit']['start_date']))));
            echo $this->Form->input('period_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;', 'default'=> date("Y", strtotime($this->data['VbisSplit']['start_date']))));
            echo "</div>";
						
		    echo $this->Form->input('clawback', array('label'=>'Clawback','type'=>'text','style'=>'width:60px;','before' => '$ '));				    				       		    																				

			echo $this->Form->button('Submit', array('type'=>'submit', 'style'=>'margin-left: 190px;'));                   
			echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
		}
	?>
	</div>
</div>