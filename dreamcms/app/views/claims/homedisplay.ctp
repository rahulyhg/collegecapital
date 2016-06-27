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
//*******************************************************
$this->set('page','home');
echo $this->Html->css('thickbox.css'); 
echo $this->Html->css('paginateStyles.css');

if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
	echo $this->Html->script('thickbox.js');
}
//echo "<!-- "; var_dump($this->params["url"]); echo " -->";
//echo "<!-- "; echo $_SERVER['QUERY_STRING']; echo " -->";
//echo "<!-- ";var_dump($this->Paginator->options['url']); echo " -->";
?>
<script language="javascript" type="text/javascript">
function select_onclick(strAction, strSelect, radAction, radVbi)  {	
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";	
	
	strGroup = document.getElementById("select_lenders").value;
	strBroker = document.getElementById("select_broker").value;	
    strActioned = radAction;
	strVbi = radVbi;
	
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
	
    if (strSelect == 'broker')  {
	   location.href="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/group:" + strBroker + strHrefAction + strHrefVbi;
	} 
	
	if (strSelect == 'lender')  {	
	   location.href="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/lender:1/group:" + strGroup + strHrefAction + strHrefVbi;
	}	
	
	if (strSelect == 'action')  {
		if (strGroup == 0)  {
		   location.href="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/group:" + strBroker + strHrefAction + strHrefVbi;
		} else  {
		   location.href="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/lender:1/group:" + strGroup + strHrefAction + strHrefVbi;
		} 
	}	
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
<style>#contentRight {width: 100%; border: none; padding: 0; margin: 0;} </style>
<div class="home">

<div id="band">
<div id="band-left"><h1>cCap Headlines</h1>
<ul>
<!-- dynamic news content - headline category id 14 - display 4 latest - truncate short description to 45 characters and make it display on one line with title (strip p tag?) -->

        <?php foreach ($news as $newsItem): ?>
        <?php if ($newsItem["News"]["category_id"] == "14")  { ?>
			<li><a href="/news/view/<?php echo $newsItem['News']['id'];?>"><strong><?php echo $newsItem['News']['title'];?></strong> - <?php echo substr(strip_tags($newsItem['News']['shortDescription']), 0, 50) . "...";?> <i class="icon-circle-arrow-right white"></i></a></li>
        <?php } ?>
            <?php endforeach; ?>

<!--<li><a href='/news'>View latest headlines here <i class='icon-circle-arrow-right white'></i></a></li>-->
           
		</ul>
</div>
<?php if($iRateDocuments){ ?>
		<div id="band-right"><h1>Interest Rates</h1> 
		<ul><!-- dynamic content -->
<?php	if($_SESSION['Auth']['User']['group_id']!=4) {
			foreach($iRateDocuments as $iRateDocument): ?>
			<li><i class="icon-arrow-right white"></i> <a href="/app/webroot/uploads/rates/<?php echo $iRateDocument['Rate']['documentFile'];?>" target="_blank"><?php echo $iRateDocument['Rate']['title'];?></a></li>
<?php		endforeach; 
		} else {
			echo "<li><i class='icon-arrow-right white'></i> <a href='/rates'>View latest interest rate document here</a></li>";
		}?>		            
		</ul></div>
<?php }?>        
</div>
<?php if($_SESSION['Auth']['User']['group_id']!=4) {?>
<div style="clear: both; height: 0;" ></div>
<div class="col" style="width: 630px; margin-right: 10px;">
<?php if($_SESSION['Auth']['User']['group_id']<4){ ?>	
	<h3><?php __('Unactioned Transactions');?></h3>
    <div style="clear:both;display:block;height:30px">
    	<?php
		$totalClaimAmount = 0;
		//******************************************************
        // CHANGE REQUEST: Nyree 29/11/13
		$totalClaimAmountCurrent = 0;
		$totalClaimAmountPrevious = 0;		
		//******************************************************
		if($_SESSION['Auth']['User']['group_id']==1 || $_SESSION['Auth']['User']['group_id']==2){ //admin/shareholders
			echo "<div style='float:left; padding-right:10px'>";			
			//******************************************************
            // CHANGE REQUEST: Nyree 29/11/13
			// NEED TO CHANGE BACK TO ORIGINAL BEFORE GO-LIVE
			$jsString = "javascript:location.href='/claims/homedisplay/home/page:1/sort:settlementDate/direction:desc/group:'+this.value;";
			//$jsString = "javascript:location.href='http://echo00/ccap.collegecapital/index.php/claims/homedisplay/home/page:1/sort:settlementDate/direction:desc/group:'+this.value;";
			//******************************************************
//			$jsString = "javascript:location.href='?group='+this.value;";
			$brokers[0] = 'Select Broker';
			foreach ($brokerOptions as $brokerOption){
				//$brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['name'];
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
			//******************************************************
            // CHANGE REQUEST: Nyree 29/11/13
			// NEED TO CHANGE BACK TO ORIGINAL BEFORE GO-LIVE
			$jsString = "javascript:location.href='/claims/homedisplay/home/page:1/sort:settlementDate/direction:desc/lender:1/group:'+this.value;";
			//$jsString = "javascript:location.href='http://echo00/ccap.collegecapital/index.php/claims/homedisplay/home/page:1/sort:settlementDate/direction:desc/lender:1/group:'+this.value;";
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
		
		//******************************************************
        // CHANGE REQUEST: Nyree 19/12/13			
//		if ($_SESSION['Auth']['User']['group_id'] == 1) { //admin
//		   $actionValue = @$this->Paginator->options['url']['action'];
//		   if ($actionValue == "")  {
//			   $actionValue = "-1";
//		   }	
//		   $vbiValue = @$this->Paginator->options['url']['vbi'];	
//			if ($vbiValue == "")  {
//				$vbiValue = "-1";
//			}		   
//		   $jsString = "select_onclick('homedisplay', 'action', this.value, $vbiValue)";
//		  		   
//		   echo "<div style='float:left; padding-right:10px'>";
//		   echo "<b>Status</b>";
//		   $actions = array('-1'=>'All', 0=>'Pending', 1=>'Actioned');
//		   echo $this->Form->input('select_actions', array('type' => 'radio', 'options' => $actions,'onchange'=> $jsString,'default' => $actionValue), array('label'=> 'Action:'));
//		   echo "</div>";	        
//		}				
		//******************************************************		
		
		//******************************************************
        // CHANGE REQUEST: Nyree 19/12/13			
		if ($_SESSION['Auth']['User']['group_id'] == 1) { //admin
		   $actionValue = @$this->Paginator->options['url']['action'];
		   if ($actionValue == "")  {
			   $actionValue = "-1";
		   }	
		   $vbiValue = @$this->Paginator->options['url']['vbi'];	
		   if ($vbiValue == "")  {
			  $vbiValue = "-1";
		   }		   	   
		   $jsString = "select_onclick('homedisplay', 'action', $actionValue, this.value)";
		 	       
		   echo "<div style='float:left; padding-right:100px'>";
		   echo "<b>VBI</b>";
		   $VBIactions = array('-1'=>'All', 1=>'Yes', 2=>'No');
		   echo $this->Form->input('select_vbi', array('type' => 'radio', 'options' => $VBIactions,'onclick'=> $jsString,'default' => $vbiValue), array('label'=> 'Action:'));
		   echo "</div>";	        
		}
		
//		if ($actionValue == -1)  {
//			$actionValue = Null;
//		}
        if (isset($vbiValue))  {
 		   if ($vbiValue == -1)  {
			   $vbiValue = Null;
		   }
		} else  {
		   $vbiValue = Null;
		}
		//******************************************************		
		?>
    </div>
    <?php echo $this->CustomDisplayFunctions->displayQuickSearch(false,NULL); ?>
    <div id="wrap-tabs">
        <?php echo $this->CustomDisplayFunctions->displaySearchBox(false); ?>
       <!-- <div class="menu-tab">
            <span class="tab"><?php echo $this->Html->link(__('add new', true), array('action' => 'add')); ?></span>			
        </div>
        <div class="menu-tab">
            <span class="tab-hi">display all </span>
        </div>-->
    </div>
    <div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap" style="background-color: #f5f5f5!important;">
           <!-- <div style="width:30px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>-->
            <div style="width:120px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('client');?></div>
            </div>
            <div style="width:120px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('lender');?></div>
               <!-- <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->link('lender', array('sort' => 'lender_id', 'direction' => 'asc'));?></div>-->
            </div>
           <div style=" width:120px" id="record_header">
            	<div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->link('broker', array('sort' => 'claims_user_broker', 'direction' => 'asc'));?></div>
            </div>
             <div style="width:50px" id="record_header">
                <div class="record_detail_header" id="record_detail" align="right" title="in months"><?php echo $this->Paginator->sort('terms');?></div>
            </div>
            <div style="width:70px" id="record_header">
                <div class="record_detail_header" id="record_detail" align="right"><?php echo $this->Paginator->sort('amount');?></div>
            </div>
            <div style="width:90px" id="record_header">
            	<div class="record_detail_header" id="record_detail" align="right"><?php echo $this->Paginator->link('settlement', array('sort' => 'claims_settlementDate', 'direction' => 'asc'));?></div>
                <!--<div class="record_detail_header" id="record_detail" align="right"><?php echo $this->Paginator->sort('settlementDate');?></div>-->
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
				
				//if ((!isset($actionValue)) || (isset($actionValue) && ($actionValue == $claim['Claim']['actioned']))  ) {			
			    if ((!isset($vbiValue)) || (isset($vbiValue) && ($vbiValue == $claim['Claim']['vbi']))  ) {	
			  
				if ($i++ % 2 == 0) {
					$class = ' class="altrow-home"';
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
						$strBrokerName = $brokerOption['Users']['name']." ".$brokerOption['Users']['surname'];
					}
				}
		?>
        <div id="record_wrap" <?php echo $class;?>>
            <!--<div style="width:30px" id="record_row">
                <div id="record_detail"><?php echo $claim['Claim']['id']; ?>&nbsp;</div>
            </div>-->
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
            <div style="width:120px" id="record_row">
                <div id="record_detail" title="<?php echo $strLenderName;?>"><?php echo (strlen($strLenderName)>20 ? substr($strLenderName, 0, 20)."..": $strLenderName); ?>&nbsp;</div>
            </div>
            <div style=" width:120px" id="record_row">
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
            <div style="width:70px" id="record_row">
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
?>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo $this->FormatEpochToDate->formatEpochToDate($claim['Claim']['settlementDate']);?></div>
            </div>
            <div style="width:40px" id="record_row">
<?php			//if ($_SESSION['Auth']['User']['id']==1) {
				if($_SESSION['Auth']['User']['group_id']==1){ //linked graphic
					echo '<div id="record_option">'.$this->Form->input("Claim.action.", array("type" => "checkbox", 'label'=>false, 'class'=>'actionCheck', 'value'=>$claim['Claim']['id'])).'</div>'; //$this->Html->link($html->image("publish0.gif",array('id'=>'action','alt'=>'Mark as actioned?','title'=>'Mark as actioned?')), array('action' => 'publish', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'Mark as actioned?'), sprintf(__('Are you sure you want to action this Transaction ID # %s?', true), $claim['Claim']['id'])).'</div>';
				//} else {
				//	if($_SESSION['Auth']['User']['group_id']==1){ //linked graphic
				//		echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'action','alt'=>'Mark as actioned?','title'=>'Mark as actioned?')), array('action' => 'publish', $claim['Claim']['id']), array('escape' => false,'id'=>'record','title'=>'Mark as actioned?'), sprintf(__('Are you sure you want to action this Transaction ID # %s?', true), $claim['Claim']['id'])).'</div>';
				//	} else {
				//		echo '<div id="record_option" class="imgPublish0">'.$html->image("publish0.gif",array('id'=>'action','alt'=>'Not yet actioned','title'=>'Not yet actioned.')).'</div>';
				//	}
				}?>
            </div>
        </div> 
		<?php 
		      //}
               }
		     endforeach; ?>
        </ul>
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:390px" id="record_row">
            	<div id="record_detail" align="right"><strong>Current Month Total:</strong></div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo "$ ".number_format($totalClaimAmountCurrent,2); ?>&nbsp;</div>
            </div>
		</div> 
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:390px" id="record_row">
            	<div id="record_detail" align="right"><strong>Previous Months Total:</strong></div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo "$ ".number_format($totalClaimAmountPrevious,2); ?>&nbsp;</div>
            </div>
		</div> 
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:390px" id="record_row">
            	<div id="record_detail" align="right"><strong>Total:</strong></div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail" align="right"><?php echo "$ ".number_format($totalClaimAmount,2); ?>&nbsp;</div>
            </div>
		</div>       
<?php		//if ($_SESSION['Auth']['User']['id']==1) { 
			if($_SESSION['Auth']['User']['group_id']==1){ ?>
        <div id="record_wrap" <?php echo $class;?> style="height:40px">
             <div style="float:right;padding:5px 10px" id="record_row"><!-- <?php echo $totalClaimAmount; ?> -->
		       	<input type="button" value="  action selected items  " id="actionItems" name="actionItems" />
             </div>
		</div>       
<?php		} ?>
        <br clear="all" />
        <div class="info_text"></div>
        <div class="page_navigation"></div>
    <?php
		} else {
			echo $this->CustomDisplayFunctions->displayNoClaimsDetails(true);
		}
	?>
        </div>
    </div>
<?php } ?>    
	</div>


<?php   
// ****************************************************************************************************************************************************
// MTD Performance  
// Change Request - Nyree 29/8/2014
// **************************************************************************************************************************************************** 
echo "<p>";
echo "<div class='col' id='band-mtd'>";
echo "<h1>MTD Performance</h1>";
echo "<b>1 to " . date('d') . " " . date('F Y') . " Financier totals</b>";
echo "<p>";

echo "<table width='90%'>";

$total = 0;

// Write VBI transaction totals by lender
// --------------------------------------
echo "<tr><td><font color='white'>VBI TRANSACTIONS</font></td></tr>";

$vbiTotal = 0;
$vbiTotalOthers = 0;
$anzTotal = 0;

foreach ($claimsLenderVBI as $claimLenderVBI)  {	
    if (($claimLenderVBI["lenders"]["id"] != 25) && ($claimLenderVBI["lenders"]["id"] != 16))  {
	   if ($claimLenderVBI["lenders"]["id"] == 17)  {
  	     $anzTotal = $claimLenderVBI[0]['amounts'];
	   } elseif ($claimLenderVBI["lenders"]["id"] == 1)  {
		 $anzTotal += $claimLenderVBI[0]['amounts'];
	     echo "<tr>";
		 echo "<td>ANZ / ANZ Edge</td>"; 
		 echo "<td align='right'>$" . number_format($anzTotal, 2) . "</td>";    	
		 echo "</tr>";
	   } else  {	   
		 echo "<tr>";
		 echo "<td>" . $claimLenderVBI["lenders"]["lender"] . "</td>"; 
		 echo "<td align='right'>$" . number_format($claimLenderVBI[0]['amounts'], 2) . "</td>";    	
		 echo "</tr>";
	   }
	} else  {
	// Others Category	
	   $vbiTotalOthers += $claimLenderVBI[0]['amounts'];
	}
	
	$vbiTotal += $claimLenderVBI[0]['amounts'];
}

// Write Others Category
if ($vbiTotalOthers > 0)  {
   echo "<tr>";
   echo "<td>Others</td>"; 
   echo "<td align='right'>$" . number_format($vbiTotalOthers, 2) . "</td>";    	
   echo "</tr>";	
}

echo "<tr>";
echo "<td><b>VBI TOTAL</b></td>"; 
echo "<td align='right' style='border-top:solid; border-bottom:double'><b>$" . number_format($vbiTotal, 2) . "</b></td>";    	
echo "</tr>";

echo "<tr><td height='10px'></td></tr>";

// Write Non-VBI transaction totals by lender
// ------------------------------------------
echo "<tr><td><font color='white'>NON-VBI TRANSACTIONS</font></td></tr>";

$nonVbiTotal = 0;
$nonVbiTotalOthers = 0;

foreach ($claimsLenderNonVBI as $claimLenderNonVBI)  {	
    if (($claimLenderNonVBI["lenders"]["id"] == 23) || ($claimLenderNonVBI["lenders"]["id"] == 24))  {
	   if ($claimLenderNonVBI["lenders"]["id"] == 24)  {
		  $strLenderName = "Canon/College Capital";
	   } else  {
		 $strLenderName = $claimLenderNonVBI["lenders"]["lender"];	
	   }
	   
	   echo "<tr>";
	   echo "<td>" . $strLenderName . "</td>"; 
	   echo "<td align='right'>$" . number_format($claimLenderNonVBI[0]['amounts'], 2) . "</td>";    	
       echo "</tr>";		
	} else  {
	// Others Category	
	   $nonVbiTotalOthers += $claimLenderNonVBI[0]['amounts'];
	}
	
	$nonVbiTotal += $claimLenderNonVBI[0]['amounts'];
}

// Write Others Category
echo "<tr>";
echo "<td>Others</td>"; 
echo "<td align='right'>$" . number_format($nonVbiTotalOthers, 2) . "</td>";    	
echo "</tr>";	
	   
echo "<tr>";
echo "<td><b>NON-VBI TOTAL</b></td>"; 
echo "<td align='right' style='border-top:solid; border-bottom:double'><b>$" . number_format($nonVbiTotal, 2) . "</b></td>";    	
echo "</tr>";


// Write Total Transactions
// ------------------------
$total = $vbiTotal + $nonVbiTotal;

echo "<tr><td height='20px'></td></tr>";

echo "<tr>";
echo "<td><b>TRANSACTION TOTAL</b></td>"; 
echo "<td align='right' style='border-top:solid; border-bottom:double'><b>$" . number_format($total, 2) . "</b></td>";    	
echo "</tr>";
	
echo "</table>";
echo "</div>";
// ****************************************************************************************************************************************************
?>

            
    <?php if($news){ ?>
        <div class="col" style="width: 320px;"> <h3>Latest Financier News</h3>
        <?php foreach ($news as $newsItem): ?>
            <?php if ($newsItem["News"]["category_id"] != "14")  { ?>
            <strong><?php echo $newsItem['News']['title'];?></strong> <br />
            <?php echo $newsItem['News']['shortDescription'];?>
            <p class="more"><a href="/news/view/<?php echo $newsItem['News']['id'];?>">MORE <i class="icon-circle-arrow-right"></i></a></p>
            <?php } ?>
        <?php endforeach; ?>
        </div>
<?php 	} 
	} ?>   
</div></div>