<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"VBI Split.xls" );
header ("Content-Description: Generated Report" );
?>
<HTML xmlns:x="urn:schemas-microsoft-com:office:excel">
<HEAD>
<?php 
// Write Report
echo '<style>
        body {font-size: 11px; color: #333; font-family: Droid Sans, arial, sans-serif;}
        table { padding: 0px; margin: 0; width:800px;}
		tr { padding: 0px; margin: 0;}
		td { padding: 0px; margin: 0; width:100px;}
        h1 {font-size: 18px; padding-bottom: 10px; }
        h2 {font-size: 17px; padding: 0px; margin:0}
        h3 { font-size: 16px; text-transform:uppercase; margin:0 padding-bottom:5px;}
		h4 { font-size: 14px; color: green;}
     </style>';
?>
<style>
  <!--table
  @page
     {mso-header-data:"";
    mso-page-orientation:landscape;}
     br
     {mso-data-placement:same-cell;}
  -->
</style>
  <!--[if gte mso 9]><xml>
   <x:ExcelWorkbook>
    <x:ExcelWorksheets>
     <x:ExcelWorksheet>
      <x:Name></x:Name>
      <x:WorksheetOptions>
       <x:FitToPage/>
       <x:Print>
       <x:FitWidth>1</x:FitWidth>
       <x:FitHeight>1000</x:FitHeight>
       <x:ValidPrinterInfo/>
       </x:Print> 
      </x:WorksheetOptions>
     </x:ExcelWorksheet>
    </x:ExcelWorksheets>
   </x:ExcelWorkbook>
  </xml><![endif]--> 
<?php

echo "<table>";
echo "<tr><td style='background-color:#8DB4E2' colspan='3'>";				 
echo "<font size='4'><b>College Capital - VBI Split " . $period . "</b></font>";
echo "</td></tr>";

$preBrokerName = "";
$counter = 0;
$settingMgtFee = $settingMgtFee["VbisSetting"]["value"];

// Write Broker Headings
echo "<tr>";
echo "<td align='center' style='background-color:#DCE6F1; height:40; width:180; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Broker Group</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:130; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Broker totals</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:140; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Non VBI Business</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:140; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Total VBI Volume</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:140; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Total Financier<br>Amount less " . $settingMgtFee . "%</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:140; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Incentive payments<br>(GST Inclusive)</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Less Clawback</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:140; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Total Invoice<br>(GST Inclusive)</b></font></td>";
echo "</tr>";

$GrandTotalInvoice = 0;
$GrandTotalBrokers = 0;
$GrandTotalVolumeBrokers = 0;
$vbiNABTotal = 0;
$nonVbiVolumeTotal = 0;

// Write VBI Split By Broker
// ***************************************************************************************************************
foreach ($claimsBroker as $claims) {
   // VBI Business Amount
   $businessAmtVBI = $claims[0]['amounts']; 
   
   // Non-VBI Business Amount
   $businessAmtNonVBI = 0;
   foreach ($claimsBrokerNonVBI as $claimBrokerNonVBI) {
      if ($claims['Users']['parent_user_id'] == $claimBrokerNonVBI['Users']['parent_user_id'])  {
	     $businessAmtNonVBI = $claimBrokerNonVBI[0]['amounts']; 
	  }
   }
   
   // Business Amount (VBI & Non-VBI)
   $businessAmt = $businessAmtVBI + $businessAmtNonVBI;
   	 
   echo "<tr>";
   $strBrokerName = "";
   foreach ($brokerOptions as $brokerOption){
      if ($brokerOption['Users']['id']==$claims['Users']['parent_user_id']) {
		$strBrokerName = $brokerOption['Users']['companyName'];
	  }
   }
   
    $vbiPayoutRate = "";
	$vbiCbaIncentive = "";
	$vbiClawback = "";
   	foreach ($vbisSplits as $vbisSplit){							
		if($claims['Users']['parent_user_id']==$vbisSplit['VbisSplit']['broker_id']){          	
		  $vbiPayoutRate = $vbisSplit['VbisSplit']['payout_rate'];
		  $vbiCbaIncentive = $vbisSplit['VbisSplit']['cba_doc_fee_incentive'];
		  $vbiClawback = $vbisSplit['VbisSplit']['clawback'];
		}
	}
	
   // Write Broker Group Name
   echo "<td nowrap>" . $strBrokerName . "</td>";
   
   // Write VBI Business      
   echo "<td align='right'>$" . number_format($businessAmt, 2) . "</td>";
   
   // Write Non-VBI Business     
   echo "<td align='right'><font color='red'>$" . number_format($businessAmtNonVBI, 2) . "</font></td>";
   
   // Write Total VBI Volume
   $vbiVolumeTotal = $businessAmtVBI;
   echo "<td align='right'>$" . number_format($businessAmtVBI, 2) . "</td>";
   
   // Write Total Invoice inc GST   
   // ***********************************************************************************************         
    $subTotalByBroker = 0;
	$subTotalByLender = 0;
	$prevLender = "";
	$prevLenderId = "";
	
    foreach ($claimsByBroker as $claimByBroker)  {	
	    if ($claimByBroker["Claims"]["vbi"] == 1)  {
			if ($claims['Users']['parent_user_id'] == $claimByBroker["Users"]["parent_user_id"])  {			
			   if ($prevLender != $claimByBroker["Lenders"]["lender"])  {				
				  $vbiRate = getVBIStructureRate($claimsLender, $vbiStructures, $prevLender, $prevLenderId);
					 
				  if ($vbiRate > 0)  {
					 $vbiCalRate = $vbiRate - $settingMgtFee;
						
					 $subTotalByLenderVBI = $subTotalByLender * ($vbiCalRate / 100);   
					 $subTotalByBroker += $subTotalByLenderVBI;					 	
				  }
					 
				  $subTotalByLender = 0;
			   }
			
			   $prevLender = $claimByBroker["Lenders"]["lender"];
			   $prevLenderId = $claimByBroker["Claims"]["lender_id"];
				
			   $subTotalByLender += $claimByBroker["Claims"]["amount"];   		    
			}	
		}
	}
	
    $vbiRate = getVBIStructureRate($claimsLender, $vbiStructures, $prevLender, $prevLenderId);
				 
    if ($vbiRate > 0)  {
	   $vbiCalRate = $vbiRate - $settingMgtFee;
	  
	   $subTotalByLenderVBI = $subTotalByLender * ($vbiCalRate / 100);   
	   $subTotalByBroker += $subTotalByLenderVBI;	  	 
    }		
   
    $subTotalInvoice = 0;
   
    echo "<td align='right'>$". number_format($subTotalByBroker, 2) . "</td>";
    // ***********************************************************************************************         

   // Write CBA Doc Fee Incentive
   if ($vbiCbaIncentive > 0)  {
      echo "<td align='right'>$" . number_format($vbiCbaIncentive, 2) . "</td>";
   } else  {
      echo "<td></td>";
   }
      
   // Write Clawback
   if ($vbiClawback > 0)  {
      echo "<td align='right'><font color='red'>$-" . number_format($vbiClawback, 2) . "</font></td>";
   } else  {
      echo "<td></td>";
   }
   
   // Write Total Invoice
   $TotalInvoice = $subTotalByBroker + $vbiCbaIncentive - $vbiClawback;
   echo "<td align='right'>$" . number_format($TotalInvoice, 2) . "</td>";
      	
   echo "</tr>";
   
   $nonVbiVolumeTotal += $businessAmtNonVBI;
   
   $GrandTotalInvoice += $businessAmtVBI;
   $GrandTotalBrokers += $TotalInvoice;
   $GrandTotalVolumeBrokers += $vbiVolumeTotal;
}

echo "<tr>";

// Write Non-VBI Business Total
echo "<td></td><td></td>";
echo "<td align='right'<font color='gray'>$" . number_format($nonVbiVolumeTotal, 2) . "</font></td>";

// Write Grand Total
echo "<td></td><td></td><td></td><td></td><td align='right'><b>$" . number_format($GrandTotalBrokers, 2) . "</b></td>";

echo "</tr>";

// Write Other - Retain CC
$totalLenderInvoice = 0;
foreach ($claimsLender as $claimLender) {
   // Get VBI Rate
   $vbiRate = '';
   foreach ($vbiStructures as $vbiStructure){	  				
      if ($claimLender['lenders']['id']==$vbiStructure['Vbis']['lender_id'])  { 
		 $rangeStart = $vbiStructure['Vbis']['range_start'];
		 if ($rangeStart > 0)  {
		    if ($vbiStructure['Vbis']['range_start_uom'] == 'k')  {
		       $rangeStart = $rangeStart * 1000;
			} else  {
			   $rangeStart = $rangeStart * 1000000;
			}
		 }
		   
		 $rangeEnd = $vbiStructure['Vbis']['range_end'];
		 if ($rangeEnd > 0)  {
		    if ($vbiStructure['Vbis']['range_end_uom'] == 'k')  {
		       $rangeEnd = $rangeEnd * 1000;
			} else  {
			   $rangeEnd = $rangeEnd * 1000000;
			}
		 }
		 
		 
		 if ($claimLender[0]['amounts'] >= $rangeStart)  {
			  if ($rangeEnd != "")  {
			    if ($claimLender[0]['amounts'] < $rangeEnd)  {    	
		           $vbiRate = $vbiStructure['Vbis']['rate'];
				}
			  } else  {
				$vbiRate = $vbiStructure['Vbis']['rate'];
			  }
		  }		
	  }
   }

   $totalLenderInvoice += $claimLender[0]['amounts'] * ($vbiRate / 100); 
}
   
$totalOtherRetainCC = $totalLenderInvoice - $GrandTotalBrokers;  
echo "<tr>";
echo "<td>Other - Retain CC</td>";
echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
echo "<td align='right'><i>$" . number_format($totalOtherRetainCC, 2) . "</i></td>";
echo "</tr>";

// Write Retain College Capital
$totalRetainCC = $GrandTotalBrokers + $totalOtherRetainCC;
echo "<tr>";
echo "<td><i>Retain College Capital</i></td>";
echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
echo "<td align='right'><b>$" . number_format($totalRetainCC, 2) . "</b></td>";
echo "</tr>";

// Write Rounding
//echo "<tr>";
//echo "<td><i>Rounding</i></td>";
//echo "<td align='right'><font color='red'>VALUE?</font></td>";
//echo "</tr>";

// Write Total
echo "<tr>";
echo "<td><b>Total</b></td>";
echo "<td align='right'></td>";
echo "<td align='right'></td>";
echo "<td align='right'><b>$" . number_format($GrandTotalVolumeBrokers, 2) . "</b></td>";
echo "</tr>";

// ***************************************************************************************************************
// Write VBI Split By Lender
// ***************************************************************************************************************

// Write Blank Row
echo "<tr><td></td></tr>";

// Write Lender Headings
echo "<tr>";
echo "<td align='center' style='background-color:#DCE6F1; height:40; width:180; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Lender</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:130; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Lender totals</b></font></td>";
echo "<td style='background-color:#DCE6F1;'></td>";
echo "<td style='background-color:#DCE6F1;'></td>";
echo "<td style='background-color:#DCE6F1;'></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:140; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>VBI % paid</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Less Clawback</b></font></td>";
echo "<td align='center' style='background-color:#DCE6F1; width:140; vertical-align:middle; border-top:solid; border-bottom:solid; border-left:solid; border-right:solid;'><font size='3'><b>Total Invoice<br>(GST Inclusive)</b></font></td>";
echo "</tr>";
	 
$GrandTotalLenders = 0;
$GrandTotalInvoice = 0;
$ANZTotal = 0;

foreach ($claimsLender as $claims) {   	      
   // Write Lender Name
   $lenderName = $claims['lenders']['lender'];
   
   if ($lenderName == "ANZ")  {	  
      $ANZTotal += $claims[0]['amounts'];
   }
   
   if ($lenderName != "ANZ")  {
	  echo "<tr>";
	  
	  if ($lenderName == "ANZ EDGE")  {
	     echo "<td nowrap>ANZ</td>";
		 $ANZTotal += $claims[0]['amounts'];
		 echo "<td align='right'>$" . number_format($ANZTotal, 2) . "</td>";
		 
		 $lenderTotal = $ANZTotal;
		 $lenderID = 1;
	  } else  {
         echo "<td nowrap>" . $lenderName . "</td>";
		 echo "<td align='right'>$" . number_format($claims[0]['amounts'], 2) . "</td>";
		 
		 $lenderTotal = $claims[0]['amounts'];
		 $lenderID = $claims['lenders']['id'];		 
	  }
	            
      // Write Blank Columns
      echo "<td></td>";
      echo "<td></td>";
      echo "<td></td>";
   
	   // Write VBI Structure Rate
	   $vbiRate = '';
	   foreach ($vbiStructures as $vbiStructure){	  				
			if ($lenderID == $vbiStructure['Vbis']['lender_id'])  { 
			   $rangeStart = $vbiStructure['Vbis']['range_start'];
			   if ($rangeStart > 0)  {
				  if ($vbiStructure['Vbis']['range_start_uom'] == 'k')  {
					  $rangeStart = $rangeStart * 1000;
				  } else  {
					 $rangeStart = $rangeStart * 1000000;
				  }
			   }
			   
			   $rangeEnd = $vbiStructure['Vbis']['range_end'];
			   if ($rangeEnd > 0)  {
				  if ($vbiStructure['Vbis']['range_end_uom'] == 'k')  {
					  $rangeEnd = $rangeEnd * 1000;
				  } else  {
					 $rangeEnd = $rangeEnd * 1000000;
				  }
			   }
			 
			  if ($lenderTotal >= $rangeStart)  {
				  if ($rangeEnd != "")  {
					if ($lenderTotal < $rangeEnd)  {    	
					   $vbiRate = $vbiStructure['Vbis']['rate'];
					}
				  } else  {
					$vbiRate = $vbiStructure['Vbis']['rate'];
				  }
			  }
			}
		}
	 
	   if ($vbiRate != '')  {	
		  echo "<td align='right'>" . $vbiRate . "%</td>";
	   } else  {
		  echo "<td align='right'></td>";  
	   }
	   
	   // Write Clawback
	   $vbiClawback = "";
	   foreach ($vbisSplits as $vbisSplit){							
		  if ($claims['lenders']['id'] == $vbisSplit['VbisSplit']['lender_id']) {          			 
			 $vbiClawback = $vbisSplit['VbisSplit']['clawback'];
		  }
	   }
	   if ($vbiClawback > 0)  {
		  echo "<td align='right'><font color='red'>$-" . number_format($vbiClawback, 2) . "</font></td>";
	   } else  {
		  echo "<td></td>";
	   }  
	   
	   // Write Total Invoice
	   $TotalInvoice = ($lenderTotal * ($vbiRate / 100)) - $vbiClawback;
	   echo "<td align='right'>$" . number_format($TotalInvoice, 2) . "</td>";
	   
	   echo "</tr>";
   
   
   $GrandTotalInvoice += $TotalInvoice;   
   $GrandTotalLenders += $lenderTotal;
   
   }
}

echo "<tr>";

// Write VBI Volume
echo "<td><b>VBI Volume</b></td>";
echo "<td align='right'><b>$" . number_format($GrandTotalLenders, 2) . "</b></td>";

// Write Blank Columns
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";   
echo "<td></td>";   
//echo "<td></td>";   

// Write Total Invoice for Lenders
echo "<td align='right'><b>$" . number_format($GrandTotalInvoice, 2) . "</b></td>";

echo "</tr>";

// Write Blank Row
echo "<tr><td></td></tr>";

// Write Not Included in VBI Calculation
echo "<tr>";
echo "<td colspan='4'><u><i>Not included in VBI calculation for " . $period . "</i></u></td>";
echo "</tr>";

// Write Other Non VBI
$totalNonVbi = 0;
$nonVbiTotalOthers = 0;

foreach ($claimsNonVbi as $claims) {
	if (($claims["lenders"]["id"] == 23) || ($claims["lenders"]["id"] == 24))  {
	   if ($claims["lenders"]["id"] == 24)  {
		  $strLenderName = "Canon/College Capital";
	   } else  {
		 $strLenderName = $claims["lenders"]["lender"];	
	   }
	   
	   echo "<tr>";
	   echo "<td>" . $strLenderName . "</td>"; 
	   echo "<td align='right'>" . number_format($claims[0]['amounts'], 2) . "</td>";    	
       echo "</tr>";		
	} else  {
	// Others Category	
	   $nonVbiTotalOthers += $claims[0]['amounts'];
	}	
		
    $totalNonVbi += $claims[0]['amounts'];
}

// Write Total for Lender - Others
echo "<tr>";
echo "<td>Others</td>";
echo "<td align='right'>$" . number_format($nonVbiTotalOthers, 2) . "</td>";
echo "</tr>";

// Write NAB total if end of quarter
//if ($monthNo % 3 == 0)  {
//   echo "<tr>";
//   echo "<td>NAB (" . $NABColumn . ")</td>";
//   echo "<td align='right'>$" . number_format($vbiNABTotal, 2) . "</td>";
//   echo "</tr>";	
//}

// Write a Not Included in VBI Calculation total
$grandTotalNonVbi = $totalNonVbi + $vbiNABTotal;
echo "<tr>";
echo "<td></td>";
//echo "<td align='right'><b>$" . number_format($grandTotalNonVbi, 2) . "</b></td>";
echo "<td align='right'><b>$" . number_format($totalNonVbi, 2) . "</b></td>";
echo "</tr>";	


// Write Blank Row
echo "<tr><td></td></tr>";

// Write All Financiers Total
$GrandTotalLendersAll = $GrandTotalLenders + $grandTotalNonVbi;
echo "<tr>";
echo "<td><b>All Financiers total</b></td>";
echo "</tr>";
echo "<tr>";
echo "<td><b>NBW June 13</b></td>";
echo "<td align='right'><b>$" . number_format($GrandTotalLendersAll,2) . "</b></td>";
echo "</tr>";

// Write Blank Row
echo "<tr><td></td></tr>";

// Write Blank Row
echo "<tr><td></td></tr>";

// Write Report Disclosure
echo "<tr>";
echo "<td colspan='4' style='font-size:9pt; color:Gray;'><b><u><i>Report Disclosure</i></u></b></td>";
echo "</tr>";


if (isset($excludeBrokers))  {
   echo "<tr>";
   echo "<td style='font-size:9pt; color:Gray;'>Broker Exclusions</td>";
   echo "<td colspan='15' style='font-size:9pt; color:Gray;'>";

   $counter = 0;	
   foreach ($excludeBrokers as $excludeBroker)  {	   
	  foreach($brokerOptions as $brokerOption)  {
		 // var_dump($brokerOption);		 
         if ($brokerOption['Users']['id'] == $excludeBroker)  {
			if ($counter > 0)  {
				echo ", ";
			}
		    echo $brokerOption['Users']['companyName'];
		 }
	  }
	  $counter++;
   }
   echo "</td>";
   echo "</tr>"; 
}


if (isset($excludeLenders))  {
   echo "<tr>";
   echo "<td style='font-size:9pt; color:Gray;'>Lender Exclusions</td>";
   echo "<td colspan='15' style='font-size:9pt; color:Gray;'>";

   $counter = 0;	
   foreach ($excludeLenders as $excludeLender)  {	   
	  foreach($lenderOptions as $lenderOption)  {
		  
         if ($lenderOption['ClaimsLender']['id'] == $excludeLender)  {
			if ($counter > 0)  {
				echo ", ";
			}
		    echo $lenderOption['ClaimsLender']['lender'];
		 }
	  }
	  $counter++;
   }
   echo "</td>";
   echo "</tr>"; 
}

if (sizeof($claimsOverridden) > 0)  {      
   foreach ($claimsOverridden as $claimOverridden)  {	   	 		
      echo "<tr>";
      echo "<td style='font-size:9pt; color:Gray;'>VBI Overridden</td>";
      echo "<td colspan='15' style='font-size:9pt; color:Gray;'>";
		 
	  echo $claimOverridden['Claims']['id'] . " " . $claimOverridden['Claims']['clientName'] . " (";		  		  
	  echo $claimOverridden['Users']['companyName'];
	  
	  foreach($lenderOptions as $lenderOption)  {		  
         if ($lenderOption['ClaimsLender']['id'] == $claimOverridden['Claims']['lender_id'])  {
			 echo ", " . $lenderOption['ClaimsLender']['lender'];
		 }
	  }
	  		 	  	  
	  echo ") $" . number_format($claimOverridden['Claims']['amount'],2) . ", " . $claimOverridden['Claims']['terms'] . " months";
	  
	  if ($claimOverridden['Claims']['vbi'] == 1)  {
		 echo " - VBI"; 
	  } else  {
		 echo " - No VBI"; 
	  }
	  
	  echo "</td>";
      echo "</tr>"; 
   }   
}

// Transactions that do not match current VBI Business Rules
$aVBIDisclosures = array();

foreach ($claimsAll as $claimAll) {
   foreach ($lenderOptions as $lenderOption){
      if ($lenderOption['ClaimsLender']['id'] == $claimAll['Claims']['lender_id']) {
		  
		  $vbiBusinessRule = $lenderOption['ClaimsLender']['vbi'];
		  
		  
		   if ($lenderOption['ClaimsLender']['vbi'] == 1)  {
              if ((($lenderOption['ClaimsLender']['amount'] > 0) && ($claimAll['Claims']['amount'] < $lenderOption['ClaimsLender']['amount']))   ||   (($lenderOption['ClaimsLender']['term'] != "") && ($claimAll['Claims']['terms'] < $lenderOption['ClaimsLender']['term']))) {
		   	     $vbiBusinessRule = 0; 		   
		      }			
		   }	
		   
		   if ($vbiBusinessRule != $claimAll['Claims']['vbi'])  {
 			  echo "<tr><td style='font-size:9pt; color:Gray;'>VBI Business Rule Exception</td>";
			  echo "<td colspan='15' style='font-size:9pt; color:Gray;'> " . $claimAll['Claims']['id'] . " " . $claimAll['Claims']['clientName'] . " (" . $claimAll['Users']['companyName'] .  ", " . $claimAll['lenders']['lender'] . ") $" . number_format($claimAll['Claims']['amount'],2) . ", " . $claimAll['Claims']['terms'] . " months";
			  
			  if ($claimAll['Claims']['vbi'] == 1)  {
			     echo " - VBI"; 
			  } else  {
				 echo " - No VBI";   
			  }
			  echo "</td></tr>";	
		   }
	  }
   }
}

echo "</table>";

// ******************************************************************************************************************************************************************************************************************
// FUNCTIONS
// ******************************************************************************************************************************************************************************************************************
function getVBIStructureRate($claimsLender, $vbiStructures, $prevLender, $prevLenderId)  {
   // Get VBI Struture Rate based on the total Lender transactions for the month				 
   $vbiRate = 0;
		   
   foreach ($claimsLender as $claimLender) {   
	  if (($prevLender != "") && ($claimLender['lenders']['lender'] == $prevLender))  {				  			
		 foreach ($vbiStructures as $vbiStructure){	  											
			 if ($prevLenderId == $vbiStructure['Vbis']['lender_id'])  { 					
				$rangeStart = $vbiStructure['Vbis']['range_start'];
				if ($rangeStart > 0)  {
				   if ($vbiStructure['Vbis']['range_start_uom'] == 'k')  {
					  $rangeStart = $rangeStart * 1000;
				   } else  {
					  $rangeStart = $rangeStart * 1000000;
				   }
				}
	   
				$rangeEnd = $vbiStructure['Vbis']['range_end'];
				if ($rangeEnd > 0)  {
				   if ($vbiStructure['Vbis']['range_end_uom'] == 'k')  {
					  $rangeEnd = $rangeEnd * 1000;
				   } else  {
					  $rangeEnd = $rangeEnd * 1000000;
				   }
				}
	 
				if ($claimLender[0]['amounts'] >= $rangeStart)  {
				   if ($rangeEnd != "")  {
					  if ($claimLender[0]['amounts'] < $rangeEnd)  {    	
						 $vbiRate = $vbiStructure['Vbis']['rate'];
					  }
				   } else  {
					  $vbiRate = $vbiStructure['Vbis']['rate'];
				   }
				}
			 }
		 }
	  }
   }
				 
   return($vbiRate);				 
}				 
?> 
