<?php
$this->set('page','vbis');
echo $this->Html->css('thickbox.css'); 
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
	echo $this->Html->script('thickbox.js'); 
}
?>
<script language="javascript" type="text/javascript">
    function select_onchange(strAction, strType)  {			
		//strDomainName = "echo00/ccap.collegecapital/index.php";
		strDomainName = "ccap.collegecapital.com.au";
		
		strGroup = "";
	    strLender = "";
			
		if (strType == "broker")  {
		   strGroup = "/group:" + document.getElementById("select_brokers").value;			  
		}
		
		if (strType == "lender")  {		
  		   strLender = "/lender:" + document.getElementById("select_lenders").value;		  
		}
		
		if (strType == "period")  {		
		   if (document.getElementById("select_lenders").value != "0")  {
			  strLender = "/lender:" + document.getElementById("select_lenders").value;		   		
		   }
		   if (document.getElementById("select_brokers").value != "0")  {
			  strGroup = "/group:" + document.getElementById("select_brokers").value;		   		
		   }
		}
		
		strMonth = document.getElementById("select_month").value;
		strYear = document.getElementById("select_year").value;
		
		location.href="http://" + strDomainName + "/vbis_splits/" + strAction + "/home/page:1" + strGroup + strLender + "/month:" + strMonth + "/year:" + strYear;
	}
	
	$(document).ready(function(){
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : <?php echo $pageLimit;?>	
		});
		$("#actionItems").click(function() {		
			var checkedVals = $('.actionCheck:checkbox:checked').map(function() {
				return this.value;
			}).get();
			idArray = checkedVals.join(",");
			if(idArray.length>0) {
				if(confirm("Are you sure you wish to action these " + checkedVals.length + " items"))
					document.location.href='/vbis/publish/'+idArray;
			} else {
				alert("You have not selected any items to action!");
			}
		});
	});
</script>
<div class="claims index">
	<div style="clear:both;display:block;height:40px">
    	<?php			
		if($_SESSION['Auth']['User']['group_id']==3 || $_SESSION['Auth']['User']['group_id']==1){ //brokers/admin
			echo "<div style='float:left; padding-right:10px'>";//						
			$jsString = "select_onchange('index', 'broker')";
			
			// Broker Groups List
			$brokers[0] = 'Select Broker Groups';
			foreach ($brokerOptions as $brokerOption){
			   $brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['name'].(strlen($brokerOption['Users']['surname'])>0?" ".$brokerOption['Users']['surname']:"").(strlen($brokerOption['Users']['companyName'])>0?" - ".$brokerOption['Users']['companyName']:"");
			   $brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['companyName'];
		    }
			$groupValue = @$this->Paginator->options['url']['group'];										
						
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
			    $timestamp = mktime(0,0,0,$i,1,$selYear);
		   	    $months[$i] = date("M", $timestamp);
		    }
		    		
			echo "<div>";
			echo $this->Form->input('select_brokers', array('label'=> '', 'div' => '','type' => 'select','options' => $brokers,'onchange'=> $jsString,'default' => $groupValue));  
			
			// Lenders List
			$lenders[0] = 'Select Lenders';
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
			$jsString = "select_onchange('index', 'lender')";
			$lenderValue = @$this->Paginator->options['url']['lender'];		
			  			
			echo $this->Form->input('select_lenders', array('label'=> '', 'div' => '','type' => 'select','options' => $lenders,'onchange'=> $jsString,'default' => $lenderValue));    			
			echo "</div>";
			
			echo "<div>";
			
			$jsString = "select_onchange('index', 'period')";
			echo $this->Form->input('select_month', array('label'=> '', 'div' => '','type' => 'select','style'=>'width:70px;', 'options' => $months,'onchange'=> $jsString,'default' => $selMonth));
			echo $this->Form->input('select_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;','onchange'=> $jsString, 'default'=> $selYear));
			echo "</div>";
			echo "</div>";
		}
		?>
    </div>
    <div id="wrap-tabs">
        <?php 
			if($_SESSION['Auth']['User']['group_id']<4) {?>
            <div class="menu-tab">
                
				<?php 
				echo "<span class='tab'>";
				$jsString = "select_onchange('add', 'broker')";
				echo $this->Html->link('add new broker', '#', array('onClick'=>$jsString, 'style' => 'margin-left: 5px;'));
				echo "</span>";
				
				echo "<span class='tab' style='margin-left: 10px;'>";
				$jsString = "select_onchange('add_lender', 'lender')";
				echo $this->Html->link('add new lender', '#', array('onClick'=>$jsString)); 
				echo "</span>";
				?>	
            </div>
        <?php
		 	} ?>
        <div class="menu-tab">
            <span class="tab-hi"><?php echo $this->Html->link(__('display all', true), array('action' => 'index'));?></span>
        </div>
    </div>
    <div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:20px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div> 
            <div style="width:180px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('broker/lender');?></div>
            </div>                  
            <div style="width:60px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('period');?></div>
            </div>
            <div style=" width:50px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('payout');?></div>
            </div>
            <div style=" width:85px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('cba doc fee');?></div>
            </div>
            <div style=" width:75px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('clawback');?></div>
            </div>
            <div style=" width:30px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('status');?></div>
            </div>
            <div style="width:120px" id="record_header" align="center">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
    	<div id="paging_container" class="container">        
            <ul id="vbis" class="content">
		<?php
		if($vbis){
			$i = 0;
			foreach ($vbis as $vbi):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				$recordType = "";
				$strBrokerLenderName = "";
				foreach ($brokerOptions as $brokerOption){
					if($brokerOption['Users']['id']==$vbi['VbisSplit']['broker_id']){
						//$strBrokerName = $brokerOption['Users']['name'] . " " . $brokerOption['Users']['surname'] . " - " . $brokerOption['Users']['companyName'];
					   $strBrokerLenderName = $brokerOption['Users']['companyName'];
					   $recordType = "broker";
					}
				}	
				
				foreach ($lenderOptions as $lenderOption){
					if($lenderOption['ClaimsLender']['id']==$vbi['VbisSplit']['lender_id']){
						//$strBrokerName = $brokerOption['Users']['name'] . " " . $brokerOption['Users']['surname'] . " - " . $brokerOption['Users']['companyName'];
					   $strBrokerLenderName = $lenderOption['ClaimsLender']['lender'];
					   $recordType = "lender";
					}
				}	
				
				// CHANGE REQUEST Nyree 06/07/2015
				// Combining of ANZ and ANZ Edge Transactions
				if (($strBrokerLenderName == "ANZ") || ($strBrokerLenderName == "ANZ EDGE"))  {
				   $strBrokerLenderName = "ANZ / ANZ Edge";
				}
				// END CHAGE REQUEST							
		?>
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:20px" id="record_row">
                <div id="record_detail"><?php echo $vbi['VbisSplit']['id']; ?>&nbsp;</div>
            </div> 
                 
            <div style="width:180px" id="record_row">
                <div id="record_detail"><?php echo $strBrokerLenderName; ?>&nbsp;</div>
            </div>                  
            <div style="width:60px" id="record_row">
                <div id="record_detail"><?php echo date("M", strtotime($vbi['VbisSplit']['start_date'])) . " " . date("Y", strtotime($vbi['VbisSplit']['start_date'])); ?>&nbsp;</div>
            </div>                  
            <div style="width:50px" id="record_row">
                <div id="record_detail" align="right"><?php ((float)$vbi['VbisSplit']['payout_rate'] > 0)? (float)$vbi['VbisSplit']['payout_rate'] . "%" : ""; ?>&nbsp;</div>
            </div>  
            <div style="width:80px" id="record_row">
                <div id="record_detail" align="right"><?php if ($vbi['VbisSplit']['cba_doc_fee_incentive'] > 0)  { echo  "$" . number_format($vbi['VbisSplit']['cba_doc_fee_incentive'], 2); } ?>&nbsp;</div>
            </div> 
            <div style="width:70px" id="record_row">
                <div id="record_detail" align="right"><?php if ($vbi['VbisSplit']['clawback'] > 0)  {  echo  "$" . number_format($vbi['VbisSplit']['clawback'], 2); } ?>&nbsp;</div>
            </div>            
            <div style="width:70px" id="record_row">
                <div id="record_detail" align="center"><?php echo ($vbi['VbisSplit']['status'] == 0 ? "Open":"Locked") ?>&nbsp;</div>
            </div> 
            <div style="width:40px" id="record_row">                    
				<?php if (($_SESSION['Auth']['User']['group_id']==1) && ($vbi['VbisSplit']['status']==0)){ //display edit only to Super User if actioned
				         if ($recordType == "broker")  {
                            echo '<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $vbi['VbisSplit']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>'; 
						 } else  {
						    echo '<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit_lender', $vbi['VbisSplit']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>'; 
				         }
                      }
				?>
            </div>
            <div style="width:50px" id="record_row">
				<?php if (($_SESSION['Auth']['User']['group_id']==1) && ($vbi['VbisSplit']['status']==0)){
                          echo '<div id="record_option" class="imgLock">'.$this->Html->link($html->image("publish0.gif",array('id'=>'lock','alt'=>'lock')), array('action' => 'lock', $vbi['VbisSplit']['id']), array('escape' => false,'id'=>'record','title'=>'lock'), sprintf(__('Are you sure you want to lock # %s?', true), $vbi['VbisSplit']['id'])).'</div>'; 
                      }                      
                ?>
            </div>
            <div style="width:50px" id="record_row">
				<?php if (($_SESSION['Auth']['User']['group_id']==1) && ($vbi['VbisSplit']['status']==0)){ //display edit only to Super User if actioned
                          echo '<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $vbi['VbisSplit']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $vbi['VbisSplit']['id'])).'</div>'; 
                      }                      
                ?>
            </div>              
        </div> 
		<?php endforeach; ?>
        </ul>

        <br clear="all" />
        <div class="info_text"></div>
        <div class="page_navigation"></div>
        </div>
    <?php
		} else {
			echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
		}
	?>
    </div>
</div></div>