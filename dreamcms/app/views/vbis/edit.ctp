<script language="javascript" type="text/javascript">
    function button_onclick(strAction)  {			
		//strDomainName = "echo00/ccap.collegecapital/index.php";
		strDomainName = "ccap.collegecapital.com.au";
		
		strGroup = document.getElementById("VbiLenderId").value;
		//strMonth = document.getElementById("VbiPeriodMonth").value;
		//strYear = document.getElementById("VbiPeriodYear").value;
		location.href="http://" + strDomainName + "/vbis/" + strAction + "/home/page:1/group:" + strGroup; // + "/month:" + strMonth + "/year:" + strYear;
	}
</script>
<?php 
echo $jQValidator->validator(); 
$this->set('page','vbis');?>
<div class="vbis form">
    <div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['Vbi']['id']; ?></div>
        	</div>
    	</div>
        <?php
		if($this->data['Vbi']['status'] == 1 && $_SESSION['Auth']['User']['group_id']==3){
			echo "<p>Sorry, you cannot edit this VBI. It has already been closed.</p>";
			$url = array('action'=>'index');
			echo $this->Form->button('Return to VBI', array('type'=>'button', 'style' => 'width: auto;', 'onclick'=>"window.location='".$this->Html->url($url)."'"));
		} else {
			echo $this->Form->create('Vbi', array('class'=>'editForm')); ?>
			<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">
			<?php
				echo $this->Form->button('Submit', array('type'=>'submit'));							
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
			?>	
			</div>	
			<?php
			echo $this->Form->input('id');
						
			foreach ($lenderOptions as $lenderOption){
				// CHANGE REQUEST Nyree 06/07/2015
				// Combining of ANZ and ANZ Edge Transactions
				if ($lenderOption['ClaimsLender']['id'] == 1)  {
				   if (($this->data['Vbi']['lender_id'] == 1) || ($this->data['Vbi']['lender_id'] == 17))  {
					  $lenderId = $this->data['Vbi']['lender_id'];
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
				
//			$todayYear = date("Y");
//		    $todayMonth = date("m");
//		    $months = array();
//		    for ($i=1; $i<=12; $i++)  {
//		    	$timestamp = mktime(0,0,0,$i,1,$todayYear);
//		    	$months[$i] = date("M", $timestamp);
//		    }
//			
//			echo "<div>";
//            echo $form->input('period_month' , array('label' => 'Period', 'type'=>'select', 'div' => '','style'=>'width:70px;', 'options' => $months, 'default' => date("m", strtotime($this->data['Vbi']['start_date']))));
//            echo $this->Form->input('period_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;', 'default'=> date("Y", strtotime($this->data['Vbi']['start_date']))));
//            echo "</div>";
			
			$range_start = (float)$this->data['Vbi']['range_start'];			
            $range_end = (float)$this->data['Vbi']['range_end'];		    
			       
		    $range_uom = array('m'=>'m', 'k'=>'k');
		    echo "<div>";       		
		    echo $this->Form->input('range_start', array('type'=>'text', 'div' => '', 'style'=>'width:40px;', 'before' => '$ ', 'value' => $range_start));
		    echo $this->Form->input('range_start_uom', array('type'=>'select','label' => false, 'style'=>'width:60px;', 'div' => '', 'options' => $range_uom));
		    echo "</div>";
		
		    echo "<div>"; 
		    echo $this->Form->input('range_end', array('type'=>'text', 'div' => '', 'style'=>'width:40px;','before' => '$ ', 'value' => $range_end));
		    echo $this->Form->input('range_end_uom', array('type'=>'select','label' => false ,'style'=>'width:60px;', 'div' => '', 'options' => $range_uom));
		    echo "</div>";
		
		    echo $this->Form->input('rate', array('label'=>'Rate','type'=>'text','style'=>'width:50px;','after' => ' %'));		
		
		    //$status = array(0=>'Open', 1=>'Locked');
		    //echo $this->Form->input('status', array('label'=>'Status', 'type' => 'select', 'style'=>'width:100px;', 'escape' => false, 'options' => $status));																							

			echo $this->Form->button('Submit', array('type'=>'submit', 'style'=>'margin-left: 190px;'));                   
			echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"button_onclick('index')"));
		}
	?>
	</div>
</div>