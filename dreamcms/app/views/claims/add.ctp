<?php
//******************************************************
// CHANGE REQUEST: Nyree 29/11/13	
$_SESSION['group'] = @$this->Paginator->options['url']['group'];
//******************************************************

echo $jQValidator->validator();
$this->set('page','claims'); ?>
<script language="javascript" type="text/javascript">
$(function()
{
	//setting the date format for the datepicker
	Date.format = 'dd/mm/yyyy';
	var settlementDate = new Date();
	//var fortnight = settlementDate.getDate()+7;	// removed as requested by CC (2013.05.01)
	//settlementDate.setDate(fortnight);			// removed as requested by CC (2013.05.01)
	$('#ClaimSettlementDate').datePicker({startDate:'01/01/1996'}).val(settlementDate.asString()).trigger('change');
});
</script>
<div class="claims form">
	<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Add Transaction Item</div>
        	</div>
    	</div>
		<?php 
		echo $this->Form->create('Claim', array('class'=>'editForm'));
		echo '<div style="position:relative; top: -25px;left:190px;width:350px;padding:0px; height: 0;">';
		echo $this->Form->button('Submit', array('type'=>'submit'));
		//echo $this->Form->button('Reset', array('type'=>'reset'));
		//******************************************************
        // CHANGE REQUEST: Nyree 29/11/13				
		//$url = array('action'=>'index');		
		if ($_SESSION['lender'] == "")  {
		   $url = array('action'=>'index/page:1/group:'. $_SESSION['group']);					   
		} else  {
		   $url = array('action'=>'index/page:1/lender:1/group:'. $_SESSION['group']);  					   
		}
		//******************************************************
		echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
        echo '</div>';
		
        echo $this->Form->input('clientName', array('type'=>'text'));
		foreach ($brokerOptions as $brokerOption){
			$brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['name'].(strlen($brokerOption['Users']['surname'])>0?" ".$brokerOption['Users']['surname']:"").(strlen($brokerOption['Users']['companyName'])>0?" - ".$brokerOption['Users']['companyName']:"");
		}
		echo $this->Form->input('claims_user_broker', array('label'=>'Broker', 'type' => 'select', 'escape' => false, 'options' => $brokers));
		
		foreach ($industryProfileOptions as $industryProfileOption){
			$industries[$industryProfileOption['ClaimsIndustryprofile']['id']] = $industryProfileOption['ClaimsIndustryprofile']['industryProfile'];
		}
		echo $this->Form->input('industryprofile_id', array('label'=>'Industry Profile', 'type' => 'select', 'escape' => false, 'options' => $industries));
		
		$lenders[$lenderOption['ClaimsLender']['id']] = "Please select";
		foreach ($lenderOptions as $lenderOption){
			    // CHANGE REQUEST Nyree 06/07/2015
				// Combining of ANZ and ANZ Edge Transactions
				if ($lenderOption['ClaimsLender']['id'] == 1)  {				 
				   $lenders[$lenderOption['ClaimsLender']['id']] = "ANZ / ANZ Edge"; //$lenderOption['ClaimsLender']['lender'] . " / ANZ Edge";
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
		
		echo $this->Form->input('netRate', array('type'=>'text','id' => 'ClaimNetRate', 'after' => '%  <em>E.g. 5 or 5.50</em>'));
		echo $this->Form->input('invoiceNumber', array('type'=>'text'));
		echo $this->Form->input('newUsed', array('type' => 'checkbox', 'label'=>'New (or Used)', 'after' => '&nbsp;<em>Select if New</em>'));
		echo $this->Form->input('amount', array('label' => 'Amount Financed', 'type'=>'text','id' => 'ClaimAmount', 'after' => '&nbsp;<em>Please do not use , (comma). E.g. 1000.50</em>', 'before' => '$ ', 'value' => '0.00'));
		echo $this->Form->input('brokerageAmount', array('label' => 'Brokerage Amount (excluding GST)', 'type'=>'text','id' => 'ClaimBrokerageAmount', 'after' => '&nbsp;<em>Please do not use , (comma). E.g. 1000.50</em>', 'before' => '$ ', 'value' => '0.00'));
		echo $this->Form->input('docFeeAmount', array('label' => 'Document Fee Amount', 'type'=>'text','id' => 'ClaimDocFeeAmount', 'after' => '&nbsp;<em>Please do not use , (comma). E.g. 1000.50</em>', 'before' => '$ ', 'value' => '0.00'));
		echo $this->Form->input('terms', array('label'=>'Terms (months)','type'=>'text','id' => 'ClaimTerms'));
		echo $this->Form->input('settlementDate', array('class'=>'dateField','id' => 'ClaimSettlementDate', 'readonly' => 'true'));
		echo $this->Form->input('notes', array('label'=>'Additional notes', 'type' => 'textarea'));
		//******************************************************
        // CHANGE REQUEST: Nyree 11/12/13	
		// CHANGE REQUEST: Nyree 25/2/14 - Adding Lender Business Rules to determine this field.
		//******************************************************
		//echo $this->Form->input('vbi', array('type' => 'checkbox', 'label'=>'Mark as VBI'));
		//******************************************************
		if($_SESSION['Auth']['User']['group_id']==1){
			echo $this->Form->input('actioned', array('type' => 'checkbox', 'label'=>'Mark as actioned?'));
		}		
		?>

      	<?php 
				echo $this->Form->button('Submit', array('type'=>'submit', 'style'=>'margin-left: 190px;'));
				//echo $this->Form->button('Reset', array('type'=>'reset'));				
				//******************************************************
                // CHANGE REQUEST: Nyree 29/11/13				
				//$url = array('contoller'=>'claims','action'=>'index');
				if ($_SESSION['lender'] == "")  {
				   $url = array('action'=>'index/page:1/group:'. $_SESSION['group']);					   
				} else  {
				   $url = array('action'=>'index/page:1/lender:1/group:'. $_SESSION['group']);  					   
				}
				//******************************************************
				echo $this->Form->button('Cancel', array('type'=>'button','onclick'=>"window.location='".$this->Html->url($url)."'"));
		?>

	</div>
</div>