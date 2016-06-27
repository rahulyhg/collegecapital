<?php
//******************************************************
// CHANGE REQUEST: Nyree 29/11/13
if (isset($this->params['named']['group']))  {
   $_SESSION['group'] = $this->params['named']['group'];
} else  {
	$_SESSION['group'] = "";
}

if (isset($this->params['named']['lender']))  {
   $_SESSION['lender'] = $this->params['named']['lender'];
} else  {
	$_SESSION['lender'] = "";
}

//******************************************************
// CHANGE REQUEST: Nyree 7/4/14
if (isset($this->params['named']['month']))  {
   $_SESSION['month'] = $this->params['named']['month'];
} else  {
	$_SESSION['month'] = "";
}

if (isset($this->params['named']['year']))  {
   $_SESSION['year'] = $this->params['named']['year'];
} else  {
	$_SESSION['year'] = "";
}
//*******************************************************
$this->set('page','claims');
echo $this->Html->css('thickbox.css'); 
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
	echo $this->Html->script('thickbox.js'); 
}
?>
<script language="javascript" type="text/javascript">
function select_onclick(strAction, strSelect, radAction, radVbi)  {	
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";	
	
	if (document.getElementById("select_lenders") != null)  {
 	   strGroup = document.getElementById("select_lenders").value;
	} else  {
	   strGroup = "";
	}

	if (document.getElementById("select_broker") != null)  {
	   strBroker = document.getElementById("select_broker").value;	
	} else  {
	   strBroker = "";
	}

	strActioned = radAction;
	strVbi = radVbi;
	
	//******************************************************
	// CHANGE REQUEST Nyree  4/4/14
	//******************************************************
	if (document.getElementById("month") != null)  {
	   strMonth = document.getElementById("month").value;	
	} else  {
	   strMonth = "";
	}

	if (document.getElementById("year") != null)  {
	   strYear = document.getElementById("year").value;	
	} else  {
	   strYear = "";
	}	

	strHrefPeriod = "/month:" + strMonth + "/year:" + strYear;
	// END CHANGE REQUEST
	//******************************************************
	
	if (radAction >= 0)  {
       strHrefAction = "/action:" + strActioned;
	} else  {
		strHrefAction = "";	   	
	}

    if (radVbi >= 0)  {
       strHrefVbi = "/vbi:" + strVbi;
	} else  {
		strHrefVbi = "";	   	
	}

    strHref = "";
    if (strSelect == 'broker')  {
	   strHref="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/group:" + strBroker + strHrefAction + strHrefVbi + strHrefPeriod;
	} 
	
	if (strSelect == 'lender')  {
	   strHref="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/lender:1/group:" + strGroup + strHrefAction + strHrefVbi + strHrefPeriod;
	}	
	
	if (strSelect == 'action')  {
		if (strGroup == 0)  {
		   strHref="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/group:" + strBroker + strHrefAction + strHrefVbi + strHrefPeriod;
		} else  {
		   strHref="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/lender:1/group:" + strGroup + strHrefAction + strHrefVbi + strHrefPeriod;
		} 
	}	

	location.href = strHref;
}

	$(document).ready(function(){
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : <?php echo $pageLimit;?>	
		});
		$("#actionItems").click(function() {
			//alert("Handler for .click() called.");  // TEST
			var checkedVals = $('.actionCheck:checkbox:checked').map(function() {
				return this.value;
			}).get();
			idArray = checkedVals.join(",");
			// alert(idArray);  // TEST
			if(idArray.length>0) {
				if(confirm("Are you sure you wish to action these " + checkedVals.length + " items"))
					document.location.href='/claims/publish/'+idArray;
			} else {
				alert("You have not selected any items to action!");
			}
		});
	});
</script>
<div class="claims index">
	<div style="clear:both;display:block;height:40px">
    	<?php
		$totalClaimAmount = 0;
		//******************************************************
        // CHANGE REQUEST: Nyree 29/11/13
		$totalClaimAmountCurrent = 0;
		$totalClaimAmountPrevious = 0;		
		//******************************************************
		// CHANGE REQUEST: Nyree 4/4/13	
		$totalClaimAmountMonth = 0;
		//******************************************************		
		if($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2){ //admin/shareholders		    
			echo "<div style='float:left; padding-right:10px'>";
			//******************************************************
            // CHANGE REQUEST: Nyree 4/4/14
			//******************************************************
			$actionValue = @$this->Paginator->options['url']['action'];	
			if ($actionValue == "")  {
				$actionValue = "-1";
			}
			$vbiValue = @$this->Paginator->options['url']['vbi'];	
			if ($vbiValue == "")  {
				$vbiValue = "-1";
			}
			$jsString = "select_onclick('index', 'action', $actionValue, $vbiValue)";
			
			echo "<div>";
			
			// Months drop down			
			$currentMonth = @$this->Paginator->options['url']['month'];	
			if ($currentMonth == "")  {		
			   $currentMonth = date("m");
			}
						
			$months = array();
			for ($i = 1; $i <= 12; $i++)  {		        
				$timestamp = mktime(0,0,0,$i,1,date("Y"));
		   	    $months[$i] = date("M", $timestamp);
		    }
			
			echo $this->Form->input('month', array('label'=> '','type' => 'select', 'div' => '', 'style'=>'width:90px;', 'options' => $months,'onchange'=> $jsString,'default' => $currentMonth));
			
			// Years drop down						
			$startYear = 2012;
			$currentYear = @$this->Paginator->options['url']['year'];	
			if ($currentYear == "")  {		
			   $currentYear = date("Y");
			}
					
		    $years = array();
		    for ($i = 0; $i <= 10; $i++)  {		
				$years[$startYear + $i]= $startYear + $i;		
		    }		
		   
		    echo $this->Form->input('year', array('label'=> '','type' => 'select','div' => '','style'=>'width:70px;','options' => $years,'onchange'=> $jsString,'default' => $currentYear));
			echo "</div>";
		    //******************************************************
			
			//$jsString = "javascript:location.href='".Configure::read('Company.url')."claims?group='+this.value;";
			//$jsString = "javascript:location.href='/claims/index/home/page:1/sort:settlementDate/direction:desc/group:'+this.value;";
			//******************************************************
            // CHANGE REQUEST: Nyree 10/12/13
			$actionValue = @$this->Paginator->options['url']['action'];	
			if ($actionValue == "")  {
				$actionValue = "-1";
			}
			$vbiValue = @$this->Paginator->options['url']['vbi'];	
			if ($vbiValue == "")  {
				$vbiValue = "-1";
			}
			$jsString = "select_onclick('index', 'broker', $actionValue, $vbiValue)";
			//******************************************************
			
			echo "<div style='float:left; padding-right:10px'>";
			$brokers[0] = 'Select Broker';
			foreach ($brokerOptions as $brokerOption){
				$brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['name']." ".$brokerOption['Users']['surname']. " - ".$brokerOption['Users']['companyName'];
			}
			$groupValue = @$this->Paginator->options['url']['group'];
			
//			if (!isset($_GET['group'])) {
//				echo $this->Form->input('select_broker', array('label'=> '','type' => 'select','options' => $brokers,'onchange'=> $jsString));
//			} else {
//				$groupValue = $_GET['group'];
				echo $this->Form->input('select_broker', array('label'=> '','type' => 'select','options' => $brokers,'onchange'=> $jsString,'default' => $groupValue));
//			}
			echo "</div>";
		} 
		if($_SESSION['Auth']['User']['group_id']==3 || $_SESSION['Auth']['User']['group_id']==1){ //brokers/admin
			echo "<div style='float:left; padding-right:10px'>";
//			$jsString = "javascript:location.href='".Configure::read('Company.url')."claims?lender=1&group='+this.value;";
			//$jsString = "javascript:location.href='/claims/index/home/page:1/sort:settlementDate/direction:desc/lender:1/group:'+this.value;";
			//******************************************************
            // CHANGE REQUEST: Nyree 10/12/13
			$actionValue = @$this->Paginator->options['url']['action'];	
			if ($actionValue == "")  {
				$actionValue = "-1";
			}	
			$vbiValue = @$this->Paginator->options['url']['vbi'];	
			if ($vbiValue == "")  {
				$vbiValue = "-1";
			}
			$jsString = "select_onclick('index', 'lender', $actionValue, $vbiValue)";
			//******************************************************
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
			$groupValue = @$this->Paginator->options['url']['group'];

//			if (!isset($_GET['group'])) {
//				echo $this->Form->input('select_lenders', array('label'=> '','type' => 'select','options' => $lenders,'onchange'=> $jsString));
//			} else {
//				$groupValue = $_GET['group'];
				echo $this->Form->input('select_lenders', array('label'=> '','type' => 'select','options' => $lenders,'onchange'=> $jsString,'default' => $groupValue));
//			}
            echo "</div>";												
		}		
		echo "</div>";
		
		//******************************************************
        // CHANGE REQUEST: Nyree 10/12/13			
		if ($_SESSION['Auth']['User']['group_id'] == 1) { //admin
		   $actionValue = @$this->Paginator->options['url']['action'];
		   if ($actionValue == "")  {
			   $actionValue = "-1";
		   }	
		   $vbiValue = @$this->Paginator->options['url']['vbi'];	
			if ($vbiValue == "")  {
				$vbiValue = "-1";
			}		   
		   $jsString = "select_onclick('index', 'action', this.value, $vbiValue)";
		  		   
		   echo "<div style='float:left; width:30%;'>";
		   echo "<p><b>Status</b><br>";
		   $actions = array('-1'=>'All', 0=>'Pending', 1=>'Actioned');
		   echo $this->Form->input('select_actions', array('type' => 'radio', 'options' => $actions,'div' => '','onchange'=> $jsString,'default' => $actionValue), array('label'=> 'Action:'));
		   echo "</div>";	        
		   		
		   $actionValue = @$this->Paginator->options['url']['action'];
		   if ($actionValue == "")  {
			   $actionValue = "-1";
		   }	
		   $vbiValue = @$this->Paginator->options['url']['vbi'];	
		   if ($vbiValue == "")  {
			  $vbiValue = "-1";
		   }		   	   
		   $jsString = "select_onclick('index', 'action', $actionValue, this.value)";
		 	       
		   echo "<div style='float:left; padding-right:10px'>";
		   echo "<p><b>VBI</b>";
		   $VBIactions = array('-1'=>'All', 1=>'Yes', 2=>'No');
		   echo $this->Form->input('select_vbi', array('type' => 'radio', 'options' => $VBIactions,'onclick'=> $jsString,'default' => $vbiValue), array('label'=> 'Action:'));
		   echo "</div>";	        
		}
		
		if ($actionValue == -1)  {
			$actionValue = Null;
		}
		if ($vbiValue == -1)  {
			$vbiValue = Null;
		}
		//******************************************************		
		?>
    
    <?php echo $this->CustomDisplayFunctions->displayQuickSearch(true,NULL); ?>
    <div id="wrap-tabs">
        <?php echo $this->CustomDisplayFunctions->displaySearchBox(true); ?>
        <?php 
			if($_SESSION['Auth']['User']['group_id']<4) {?>
            <div class="menu-tab">
                <span class="tab">
				<?php 
				//******************************************************
                // CHANGE REQUEST: Nyree 29/11/13
				//echo $this->Html->link(__('add new', true), array('action' => 'add')); 								
				if ($_SESSION['lender'] == "")  {
				   $url = array('action'=>'add/page:1/group:'. $_SESSION['group']);					   
				} else  {
				   $url = array('action'=>'add/page:1/lender:1/group:'. $_SESSION['group']);  					   
				}
				echo $this->Html->link(__('add new', true), $url); 
				//******************************************************				
				?></span>			
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
            <div style="width:35px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>
            <div style="width:120px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('client');?></div>
            </div>
            <div style="width:150px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('lender');?></div>
            </div>
            <div style=" width:70px" id="record_header">
            	<div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->link('Broker', array('sort' => 'claims_user_broker', 'direction' => 'asc'));?></div>
            </div>
            <div style="width:50px" id="record_header">
                <div class="record_detail_header" id="record_detail" align="right" title="in months"><?php echo $this->Paginator->sort('terms');?></div>
            </div>
            <div style="width:80px" id="record_header">
                <div class="record_detail_header" id="record_detail" align="right"><?php echo $this->Paginator->sort('amount');?></div>
            </div>
            <div style=" width:70px" id="record_header">
                <div class="record_detail_header" id="record_detail" align="right"><?php echo $this->Paginator->link('settlement', array('sort' => 'settlementDate', 'direction' => 'desc'));?></div>
            </div>
            <div style="width:120px" id="record_header" align="center">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
    	<div id="paging_container" class="container">        
            <ul id="claims" class="content">
		<?php
		if (isset($vbiValue) && ($vbiValue == 2))  {
		   $vbiValue = "0";
		}
		
		if($claims){
			$i = 0;
			foreach ($claims as $claim):
              $class = null;
			  
			  if ((!isset($actionValue)) || (isset($actionValue) && ($actionValue == $claim['Claim']['actioned']))  ) {			
			  if ((!isset($vbiValue)) || (isset($vbiValue) && ($vbiValue == $claim['Claim']['vbi']))  ) {	
			  	
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
				
				foreach ($lenderOptions as $lenderOption){
					if($lenderOption['ClaimsLender']['id']==$claim['Claim']['lender_id']){
						$strLenderName = $lenderOption['ClaimsLender']['lender'];
					}
				}
				
				// CHANGE REQUEST Nyree 06/07/2015
				// Combining of ANZ and ANZ Edge Transactions
				if (($strLenderName == "ANZ") || ($strLenderName == "ANZ EDGE"))  {
				   $strLenderName = "ANZ / ANZ Edge";
				}
				// END CHAGE REQUEST
				
				foreach ($brokerOptions as $brokerOption){
					if($brokerOption['Users']['id']==$claim['Claim']['claims_user_broker']){
						$strBrokerName = $brokerOption['Users']['name'];
					}
				}
		?>
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:35px" id="record_row">
                <div id="record_detail"><?php echo $claim['Claim']['id']; ?>&nbsp;</div>
            </div>
            <div style="width:120px" id="record_row">
                <div id="record_detail" title="<?php echo $claim['Claim']['clientName'];?>"><?php  
					$clientName = $claim['Claim']['clientName'];
					if(strlen($clientName)>15){
						$clientName = substr($clientName,0,15)."...";
					}
					//******************************************************
                    // CHANGE REQUEST: Nyree 29/11/13				     						
				    if ($_SESSION['lender'] == "")  {
				       $url = array('action'=>'edit/' . $claim['Claim']['id'] . '/page:1/group:'. $_SESSION['group']);					   
				    } else  {
				       $url = array('action'=>'edit/' . $claim['Claim']['id'] . '/page:1/lender:1/group:'. $_SESSION['group']);  					   
				    }
				    //******************************************************	
					if($claim['Claim']['actioned'] == 1){					  
						if($_SESSION['Auth']['User']['group_id']==1){ 
							//echo $this->Html->link(__($clientName, true), array('action' => 'edit', $claim['Claim']['id'])); 							
							echo $this->Html->link(__($clientName, true), $url); 
						} else {
							echo $clientName;
						}
					} else {
						//echo $this->Html->link(__($clientName, true), array('action' => 'edit', $claim['Claim']['id']));
						echo $this->Html->link(__($clientName, true), $url);
					}
				?></div>
            </div>
            <div style="width:150px" id="record_row">
                <div id="record_detail" title="<?php echo $strLenderName;?>"><?php echo (strlen($strLenderName)>20 ? substr($strLenderName, 0, 20)."..": $strLenderName); ?>&nbsp;</div>
            </div>
            <div style=" width:70px" id="record_row">
                <div id="record_detail">
				<?php if($_SESSION['Auth']['User']['group_id']<3){ //if not broker
						echo $strBrokerName." ";
					  } else { //if broker 
					  	echo $_SESSION['Auth']['User']['name'];
					  } ?>
                </div>
            </div>
            <div style="width:50px" id="record_row">
                <div id="record_detail" align="right" title="in months"><?php echo $claim['Claim']['terms']; ?>&nbsp;</div>
            </div>
            <div style="width:80px" id="record_row">
                <div id="record_detail" align="right"><?php echo "$ ".number_format($claim['Claim']['amount'],2); ?>&nbsp;</div>
<?php
    $totalClaimAmount += $claim['Claim']['amount'];
	//******************************************************
    // CHANGE REQUEST: Nyree 29/11/13 
	$todayMonth = date("m");
	$settlementMonth = date('m', $claim['Claim']['settlementDate']);
	if ($todayMonth == $settlementMonth)  {
	   // Add amount to the current month total
	   $totalClaimAmountCurrent += $claim['Claim']['amount'];
	} else  {
	   // Add amount to the previous months total	
	   $totalClaimAmountPrevious += $claim['Claim']['amount'];
	}
	//******************************************************
	// CHANGE REQUEST: Nyree 4/4/13 
	$totalClaimAmountMonth += $claim['Claim']['amount'];
	//******************************************************
?>
            </div>
            <div style="width:70px" id="record_row">
            	<!--<div id="record_detail" align="right"><?php if($claim['Claim']['actioned'] == 0) { echo $this->FormatEpochToDate->formatEpochToDate($claim['Claim']['settlementDate']); } ?></div>-->
            	<div id="record_detail" align="right" <?php if($claim['Claim']['actioned'] == 1) { echo "style='color:#AAA'"; } ?>><?php echo $this->FormatEpochToDate->formatEpochToDate($claim['Claim']['settlementDate']); ?></div>
            </div>
            <div style="width:40px" id="record_row">
<?php			//if ($_SESSION['Auth']['User']['id']==1) {
				if($claim['Claim']['actioned'] == 0) { 
					echo '<div id="record_option">';
				 	if($_SESSION['Auth']['User']['group_id']==1){
						echo $this->Form->input("Claim.action.", array("type" => "checkbox", 'label'=>false, 'class'=>'actionCheck', 'value'=>$claim['Claim']['id'])); //$this->Html->link($html->image("publish0.gif",array('id'=>'action','alt'=>'Mark as actioned?','title'=>'Mark as actioned?')), array('action' => 'publish', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'Mark as actioned?'), sprintf(__('Are you sure you want to action this Transaction ID # %s?', true), $claim['Claim']['id'])).'</div>';
					} else {
						echo $html->image("publish0.gif",array('id'=>'unactioned','alt'=>'Not Yet Actioned','title'=>'Not Yet Actioned'));	
					}
					echo '</div>';
//				} else {
//					echo '<div id="record_option" class="imgPublish1">';
//				 	if($claim['Claim']['actioned'] == 1) { 
//						echo $html->image("publish1.gif",array('id'=>'actioned','alt'=>'Transaction Actioned','title'=>'Transaction Actioned'));
//					} else { 
//						if($_SESSION['Auth']['User']['group_id']==1){
//							echo $this->Html->link($html->image("publish0.gif",array('id'=>'action','alt'=>'Mark as actioned?','title'=>'Mark as actioned?')), array('action' => 'publish', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'Mark as actioned?'), sprintf(__('Are you sure you want to action this Transaction ID # %s?', true), $claim['Claim']['id']));
//						} else {
//							echo $html->image("publish0.gif",array('id'=>'unactioned','alt'=>'Not Yet Actioned','title'=>'Not Yet Actioned'));	
//						}
//					} 
//					echo '</div>';
				}
			?>
            </div>
            
            <div style="width:40px" id="record_row">                    
				<?php if($claim['Claim']['actioned'] == 1){
                        if($_SESSION['Auth']['User']['group_id']==1){ //display edit only to Super User if actioned
                            echo '<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>'; 
                        }
                      } else { //display edit option if not actioned
                          echo '<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>'; 
                      }
				?>
            </div>
            <div style="width:40px" id="record_row">
				<?php if($claim['Claim']['actioned'] == 1){
                        if($_SESSION['Auth']['User']['group_id']==1){ //display edit only to Super User if actioned
                            echo '<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $claim['Claim']['id'])).'</div>'; 
                        }
                      } else {
                          echo '<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $claim['Claim']['id'])).'</div>'; 
                      }
                ?>
            </div>
        </div> 
		<?php 
               }
               }
		     endforeach; ?>
        </ul>
        
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:410px" id="record_row">
            	<div id="record_detail" align="right"><strong>Month Total:</strong></div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo "$ ".number_format($totalClaimAmountMonth,2); ?>&nbsp;</div>
            </div>
		</div>        
        <!-- 
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:410px" id="record_row">
            	<div id="record_detail" align="right"><strong>Current Month Total:</strong></div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo "$ ".number_format($totalClaimAmountCurrent,2); ?>&nbsp;</div>
            </div>
		</div>       
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:410px" id="record_row">
            	<div id="record_detail" align="right"><strong>Previous Months Total:</strong></div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo "$ ".number_format($totalClaimAmountPrevious,2); ?>&nbsp;</div>
            </div>
		</div>    
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:410px" id="record_row">
            	<div id="record_detail" align="right"><strong>Total:</strong></div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo "$ ".number_format($totalClaimAmount,2); ?>&nbsp;</div>
            </div>
		</div> -->    
<?php		//if ($_SESSION['Auth']['User']['id']==1) { 
			if($_SESSION['Auth']['User']['group_id']==1){ ?>
        <div id="record_wrap" <?php echo $class;?> style="height:40px">
             <div style="float:right;padding:5px 10px" id="record_row">
		       	<input type="button" value="  action selected items  " id="actionItems" name="actionItems" />
             </div>
		</div>       
<?php		} ?>
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