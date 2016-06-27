<?php 
//******************************************************
// CHANGE REQUEST: Nyree 29/11/13	
//$_SESSION['group'] = @$this->Paginator->options['url']['group'];
//******************************************************
echo $jQValidator->validator(); 
$this->set('page','claims');?>
<script language="javascript" type="text/javascript">
$(function()
{
	//setting the date format for the datepicker
	Date.format = 'dd/mm/yyyy';
	var settlementDate = new Date();
	var fortnight = settlementDate.getDate()+7;
	settlementDate.setDate(fortnight);
	$('#ClaimSettlementDate').datePicker({startDate:'01/01/1996'});
});

function btnOverrideVBI_onclick(user_id)  {
   var today = new Date();
   today = today.getFullYear() + "-" + today.getMonth() + "-" + today.getDate() + " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
   
   if (document.getElementById("ClaimVbi2").checked)  {
	   document.getElementById("ClaimVbi2").checked = false;
	   document.getElementById("ClaimVbiOverrideUser").value = user_id;
	   document.getElementById("ClaimVbiOverrideDate").value = today;
	   
	   document.getElementById("ClaimVbi").value = 0;
	   document.getElementById("ClaimVbi2").value = 0;
   } else  {
	   document.getElementById("ClaimVbi2").checked = true;
	   document.getElementById("ClaimVbiOverrideUser").value = user_id;
	   document.getElementById("ClaimVbiOverrideDate").value = today;
	   
	   document.getElementById("ClaimVbi").value = 1;
	   document.getElementById("ClaimVbi2").value = 1;
   }
}
</script>
<div class="claims form">
    <div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Edit Item: <?php echo $this->data['Claim']['id']; ?></div>
        	</div>
    	</div>
        <?php
		if($this->data['Claim']['actioned']==1 && $_SESSION['Auth']['User']['group_id']==3){
			echo "<p>Sorry, you cannot edit this claim. It has already been processed.</p>";
			$url = array('action'=>'index');
			echo $this->Form->button('Return to Claims', array('type'=>'button', 'style' => 'width: auto;', 'onclick'=>"window.location='".$this->Html->url($url)."'"));
		} else {
			echo $this->Form->create('Claim', array('class'=>'editForm')); ?>
			<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">
			<?php
				echo $this->Form->button('Submit', array('type'=>'submit'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));				
				//******************************************************
                // CHANGE REQUEST: Nyree 29/11/13				
				//$url = array('action'=>'index');
				if ($_SESSION['lender'] == "")  {
				   $url = 'index/page:1/group:' . $_SESSION['group'];				   				   
				} else  {
				   $url = 'index/page:1/lender:1/group:'. $_SESSION['group'];  					   
				}
				if ($_SESSION['month'] != "")  {
					$url .= "/month:" . $_SESSION['month']; "/year:" . $_SESSION['year'];
				}
				if ($_SESSION['year'] != "")  {
					$url .= "/year:" . $_SESSION['year'];
				}
				$url = array('action'=> $url);
				//******************************************************
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
			?>	
			</div>	
			<?php
			echo $this->Form->input('id');
			echo $this->Form->input('clientName', array('type'=>'text'));
			foreach ($brokerOptions as $brokerOption){
				$brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['name'].(strlen($brokerOption['Users']['surname'])>0?" ".$brokerOption['Users']['surname']:"").(strlen($brokerOption['Users']['companyName'])>0?" - ".$brokerOption['Users']['companyName']:"");
			}
			echo $this->Form->input('claims_user_broker', array('label'=>'Broker', 'type' => 'select', 'escape' => false, 'options' => $brokers));
			
			foreach ($industryProfileOptions as $industryProfileOption){
				$industries[$industryProfileOption['ClaimsIndustryprofile']['id']] = $industryProfileOption['ClaimsIndustryprofile']['industryProfile'];
			}
			echo $this->Form->input('industryprofile_id', array('label'=>'Industry Profile', 'type' => 'select', 'escape' => false, 'options' => $industries));
			
			foreach ($lenderOptions as $lenderOption){
				// CHANGE REQUEST Nyree 06/07/2015
				// Combining of ANZ and ANZ Edge Transactions
				if ($lenderOption['ClaimsLender']['id'] == 1)  {
				   if (($this->data['Claim']['lender_id'] == 1) || ($this->data['Claim']['lender_id'] == 17))  {
					  $lenderId = $this->data['Claim']['lender_id'];
				   } else  {
					  $lenderId = $lenderOption['ClaimsLender']['id'];
				   }	
				   $lenders[$lenderId] = "ANZ / ANZ Edge"; //$lenderOption['ClaimsLender']['lender'] . " / ANZ Edge";
				} else if ($lenderOption['ClaimsLender']['id'] == 17)  {
				   // Do Nothing for Lender ANZ Edge as combined with ANZ
				} else  {
				   $lenders[$lenderOption['ClaimsLender']['id']] = $lenderOption['ClaimsLender']['lender'];
				}
				// END CHAGE REQUEST				
			}
			echo $this->Form->input('lender_id', array('label'=>'Lender', 'type' => 'select', 'escape' => false, 'options' => $lenders));
			
			foreach ($goodsDescOptions as $goodsDescOption){
				$goods[$goodsDescOption['ClaimsGoodsdesc']['id']] = $goodsDescOption['ClaimsGoodsdesc']['goodsDescription'];
			}
			echo $this->Form->input('goodsdesc_id', array('label'=>'Goods Description','type' => 'select', 'escape' => false, 'options' => $goods));
			
			foreach ($productTypeOptions as $productTypeOption){
				$products[$productTypeOption['ClaimsProducttype']['id']] = $productTypeOption['ClaimsProducttype']['productType'];
			}
			echo $this->Form->input('producttype_id', array('label'=>'Product Type', 'type' => 'select', 'escape' => false, 'options' => $products));
			
			echo $this->Form->input('netRate', array('type'=>'text','id' => 'ClaimNetRate', 'after' => '%  <em>E.g. 5 or 5.50</em>', 'value' => number_format($this->data['Claim']['netRate'],2)));
			echo $this->Form->input('invoiceNumber', array('type'=>'text'));
			echo $this->Form->input('newUsed', array('type' => 'checkbox', 'label'=>'New (or Used)', 'after' => '&nbsp;<em>Select if New</em>'));
			echo $this->Form->input('amount', array('label' => 'Amount Financed','type'=>'text','id' => 'ClaimAmount', 'after' => '&nbsp;<em>Please do not use , (comma). E.g. 1000.50</em>', 'before' => '$ ', 'value' => number_format((float)$this->data['Claim']['amount'],2,'.','')));
			echo $this->Form->input('brokerageAmount', array('label' => 'Brokerage Amount (excluding GST)', 'type'=>'text','id' => 'ClaimBrokerageAmount', 'after' => '&nbsp;<em>Please do not use , (comma). E.g. 1000.50</em>', 'before' => '$ ', 'value' => number_format((float)$this->data['Claim']['brokerageAmount'],2,'.','')));
			echo $this->Form->input('docFeeAmount', array('label' => 'Document Fee Amount', 'type'=>'text','id' => 'ClaimDocFeeAmount', 'after' => '&nbsp;<em>Please do not use , (comma). E.g. 1000.50</em>', 'before' => '$ ', 'value' => number_format((float)$this->data['Claim']['docFeeAmount'],2,'.','')));
			echo $this->Form->input('terms', array('label'=>'Terms (months)','type'=>'text','id' => 'ClaimTerms'));
			echo $this->Form->input('settlementDate', array('class'=>'dateField','id' => 'ClaimSettlementDate', 'readonly' => 'true', 'value' => $this->FormatEpochToDate->formatEpochToDate($this->data['Claim']['settlementDate'])));
			echo $this->Form->input('notes', array('label'=>'Additional notes', 'type' => 'textarea'));		    
			
		    if($_SESSION['Auth']['User']['group_id']==1){
				echo $this->Form->input('actioned', array('type' => 'checkbox', 'label'=>'Mark as actioned?'));
			}
			
			//******************************************************
            // CHANGE REQUEST: Nyree 11/12/13	
			// CHANGE REQUEST: Nyree 25/2/14 - Adding Lender Business Rules to determine this field.
			// CHANGE REQUEST: Nyree 10/6/14 - Allow a Super User to override Lender Business Rules.
		    //******************************************************
			echo $this->Form->input('vbi', array('type'=>'hidden')); 
			
			if  ($this->data['Claim']['vbi'] == 0)  {	    
			    echo $this->Form->input('vbi2', array('type' => 'checkbox', 'label'=>'Mark as VBI', 'disabled' => 'disabled'));	
			} else  {
				echo $this->Form->input('vbi2', array('type' => 'checkbox', 'label'=>'Mark as VBI', 'checked' => 'checked', 'disabled' => 'disabled'));	
			}
			
			if ($_SESSION['Auth']['User']['group_id'] == 1)  {			   
			   echo $this->Form->button('Override VBI', array('type'=>'button','onclick'=> "btnOverrideVBI_onclick('" . $_SESSION['Auth']['User']['id'] . "')", 'style'=>'margin-left: 190px;'));
			   echo $this->Form->input('vbiOverrideUser', array('type'=>'hidden')); 
			   echo $this->Form->input('vbiOverrideDate', array('type'=>'hidden')); 
			   echo "<br /><br />";  	
			}
			
			if (($this->data['Claim']['vbiOverrideUser'] != "") && ($this->data['Claim']['vbiOverrideUser'] != 0))  {
			   $vbiOverrideDate = date('d/m/Y h:i:s', strtotime($this->data['Claim']['vbiOverrideDate']));			  

			   echo "<label style='margin-left:190px'><font color='red'><u>VBI Overridden</u><br />By: " . $vbiOverrideUserName[0]["Users"]["name"] . " " . $vbiOverrideUserName[0]["Users"]["surname"] . "<br />On: " . $vbiOverrideDate . "</font></label>";
			   echo "<br /><br /><br /><br />";
			}								
			//******************************************************
			?>

			<?php 
					echo $this->Form->button('Submit', array('type'=>'submit', 'style'=>'margin-left: 190px;'));
					//echo $this->Form->button('Reset', array('type'=>'reset'));				
					//******************************************************
					//$url = array('contoller'=>'claims','action'=>'index');
                    // CHANGE REQUEST: Nyree 29/11/13				
					if ($_SESSION['lender'] == "")  {
				       $url = 'index/page:1/group:' . $_SESSION['group'];				   				   
				    } else  {
				       $url = 'index/page:1/lender:1/group:'. $_SESSION['group'];  					   
				    }
				    if ($_SESSION['month'] != "")  {
					   $url .= "/month:" . $_SESSION['month'];
				    }
				    if ($_SESSION['year'] != "")  {
					   $url .= "/year:" . $_SESSION['year'];
				    }
				    $url = array('action'=> $url);
					//******************************************************
					echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
			?>

	<?php
		}
	?>
	</div>
</div>