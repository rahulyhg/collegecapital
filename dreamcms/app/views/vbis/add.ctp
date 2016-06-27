<?php
echo $jQValidator->validator();
$this->set('page','vbis'); ?>
<script language="javascript" type="text/javascript">
function button_onclick(strAction)  {			
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";
	
	strGroup = document.getElementById("VbiLenderId").value;
	//strMonth = document.getElementById("VbiPeriodMonth").value;
	//strYear = document.getElementById("VbiPeriodYear").value;
	location.href="http://" + strDomainName + "/vbis/" + strAction + "/home/page:1/group:" + strGroup; // + "/month:" + strMonth + "/year:" + strYear;
}
	
$(function()
{
	//setting the date format for the datepicker
	Date.format = 'dd/mm/yyyy';
	var settlementDate = new Date();	
	$('#ClaimSettlementDate').datePicker({startDate:'01/01/1996'}).val(settlementDate.asString()).trigger('change');
});
</script>
<div class="vbis form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add VBI Item</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Vbi', array('class'=>'editForm'));
		echo '<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">';
		echo $this->Form->button('Submit', array('type'=>'submit'));				
		$url = array('action'=>'index');				
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
        echo '</div>';
		
		// Lenders List      
		foreach ($lenderOptions as $lenderOption){
			// CHANGE REQUEST Nyree 06/07/2015
			// Combining of ANZ and ANZ Edge Transactions
			if ($lenderOption['ClaimsLender']['id'] == 1)  {				 
			   $lenders[$lenderOption['ClaimsLender']['id']] = $lenderOption['ClaimsLender']['lender'] . " / ANZ Edge";
			} else if ($lenderOption['ClaimsLender']['id'] == 17)  {
			   // Do Nothing for Lender ANZ Edge as combined with ANZ
			} else  {
			   $lenders[$lenderOption['ClaimsLender']['id']] = $lenderOption['ClaimsLender']['lender'];
			}
			// END CHAGE REQUES			
		}
		if (isset($this->params['named']['group']))  {
		   $selLender = $this->params['named']['group'];
		} else  {
		   $selLender = '';
		}
		
		echo $this->Form->input('lender_id', array('label'=>'Lender', 'type' => 'select', 'escape' => false, 'options' => $lenders, 'default' => $selLender));
		
		// Period
//		if (isset($this->params['named']['year']))  {
//		   $selYear = $this->params['named']['year'];
//		} else  {
//		   $selYear = date("Y");
//		}
//		
//		if (isset($this->params['named']['month']))  {
//		   $selMonth = $this->params['named']['month'];
//		} else  {
//		   $selMonth = date("m");
//		}	
//			
//		$months = array();
//		for ($i=1; $i<=12; $i++)  {
//			$timestamp = mktime(0,0,0,$i,1,$todayYear);
//		   	$months[$i] = date("M", $timestamp);
//		}
//		
//        echo "<div>";
//        echo $form->input('period_month' , array('label' => 'Period', 'type'=>'select', 'div' => '','style'=>'width:70px;', 'options' => $months, 'default' => $selMonth));
//        echo $this->Form->input('period_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;', 'default'=> $selYear));
//        echo "</div>";
        
		$range_uom = array('m'=>'m', 'k'=>'k');
		echo "<div>";       		
		echo $this->Form->input('range_start', array('type'=>'text', 'div' => '', 'style'=>'width:40px;', 'before' => '$ '));
		echo $this->Form->input('range_start_uom', array('type'=>'select','label' => false, 'style'=>'width:60px;', 'div' => '', 'options' => $range_uom));
		echo "</div>";
		
		echo "<div>"; 
		echo $this->Form->input('range_end', array('type'=>'text', 'div' => '', 'style'=>'width:40px;','before' => '$ '));
		echo $this->Form->input('range_end_uom', array('type'=>'select','label' => false ,'style'=>'width:60px;', 'div' => '', 'options' => $range_uom));
		echo "</div>";
		
		echo $this->Form->input('rate', array('label'=>'Rate','type'=>'text','style'=>'width:50px;','after' => ' %'));		
		
		//$status = array(0=>'Open', 1=>'Locked');
		//echo $this->Form->input('status', array('label'=>'Status', 'type' => 'select', 'style'=>'width:100px;', 'escape' => false, 'options' => $status));			
		?>

      	<?php 
				echo $this->Form->button('Submit', array('type'=>'submit', 'style'=>'margin-left: 190px;'));						
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
		?>

	</div>
</div>