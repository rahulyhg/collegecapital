<?php
echo $jQValidator->validator();
$this->set('page','vbisSplit'); ?>
<script language="javascript" type="text/javascript">
function button_onclick(strAction)  {			
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";
	
	strGroup = document.getElementById("VbisSplitBrokerId").value;
	strMonth = document.getElementById("VbisSplitPeriodMonth").value;
	strYear = document.getElementById("VbisSplitPeriodYear").value;
	location.href="http://" + strDomainName + "/vbis_splits/" + strAction + "/home/page:1/group:" + strGroup + "/month:" + strMonth + "/year:" + strYear;
}
	
$(function()
{
	//setting the date format for the datepicker
	Date.format = 'dd/mm/yyyy';
	var settlementDate = new Date();	
	$('#ClaimSettlementDate').datePicker({startDate:'01/01/1996'}).val(settlementDate.asString()).trigger('change');
});
</script>
<div class="vbisSplits form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add VBI Item</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('VbisSplit', array('class'=>'editForm'));
		echo '<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">';
		echo $this->Form->button('Submit', array('type'=>'submit'));				
		$url = array('action'=>'index');				
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
        echo '</div>';
		
		// Broker Groups List    
		foreach ($brokerOptions as $brokerOption){
			//$brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['name'].(strlen($brokerOption['Users']['surname'])>0?" ".$brokerOption['Users']['surname']:"").(strlen($brokerOption['Users']['companyName'])>0?" - ".$brokerOption['Users']['companyName']:"");
			$brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['companyName'];
		}
		echo $this->Form->input('broker_id', array('label'=>'Broker', 'type' => 'select', 'escape' => false, 'options' => $brokers));	
		
		// Period
		if (isset($this->params['named']['year']))  {
		   $selYear = $this->params['named']['year'];
		} else  {
		   $selYear = date("Y");
		}
		
		if (isset($this->params['named']['month']))  {
		   $selMonth = $this->params['named']['month'];
		} else  {
		   $selMonth = date("m");
		}	
			
		$months = array();
		for ($i=1; $i<=12; $i++)  {
			$timestamp = mktime(0,0,0,$i,1,$todayYear);
		   	$months[$i] = date("M", $timestamp);
		}
		
        echo "<div>";
        echo $form->input('period_month' , array('label' => 'Period', 'type'=>'select', 'div' => '','style'=>'width:70px;', 'options' => $months, 'default' => $selMonth));
        echo $this->Form->input('period_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;', 'default'=> $selYear));
        echo "</div>";
        		     		
		echo $this->Form->input('payout_rate', array('type'=>'text','style'=>'width:40px;', 'after' => ' %'));
		 
		echo $this->Form->input('cba_doc_fee_incentive', array('label'=>'CBA Doc Fee Incentive', 'type'=>'text', 'style'=>'width:60px;','before' => '$ '));		
		echo $this->Form->input('cba_doc_fee_incentive_note', array('label'=>'CBA Doc Fee Incentive Note', 'type'=>'textarea'));	
		
		echo $this->Form->input('clawback', array('label'=>'Clawback','type'=>'text','style'=>'width:60px;','before' => '$ '));		
		echo $this->Form->input('clawback_note', array('label'=>'Clawback Note','type'=>'textarea'));		
		
		//$status = array(0=>'Open', 1=>'Locked');
		//echo $this->Form->input('status', array('label'=>'Status', 'type' => 'select', 'style'=>'width:100px;', 'escape' => false, 'options' => $status));			
		?>

      	<?php 
				echo $this->Form->button('Submit', array('type'=>'submit', 'style'=>'margin-left: 190px;'));						
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
		?>

	</div>
</div>