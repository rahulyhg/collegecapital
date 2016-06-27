<?php
// Get Broker Name
$strBrokerName = "";  
foreach ($brokerGroups as $brokerGroup){	  
   $strBrokerName = $brokerGroup['Users']['companyName'];
}     
   
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"VBI Broker BreakUp List " . $strBrokerName . " " . substr($period, 0, 3) . " " . substr($period, strlen($period)-4, strlen($period)-1) . ".xls" );
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
        h1 {font-size: 18px; padding-bottom: 10px;}
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
				 
$preBrokerName = "";
$counter = 0;

// Write Headings
echo "<table>";
echo "<tr><td style='background-color:#8DB4E2' colspan='5'>";				 
echo "<font size='4'><b>College Capital - VBI Breakup By Broker,  " . $brokerName[0]["Users"]["companyName"] . ", " . $period . "</b></font>";
echo "</td></tr>";

if ($reportSort == "lender")  {
   writeHeadings("");
}
// Write VBI Split By Broker
// ***************************************************************************************************************
$settingMgtFee = $settingMgtFee["VbisSetting"]["value"];

$totalVolume = 0;
$totalNonVBIVolume = 0;
$subTotal = 0;
$VBITotal = 0;
$brokerTotal = 0;
$brokerVBITotal = 0;
$companyTotal = 0;
$companyVBITotal = 0;

$prevItem = "";
$currItem = "";
$prevItemId = "";
$currItemId = "";

$prevBroker = "";
$currBroker = "";

$prevCompany = "";
$currCompany = "";

foreach ($claims as $claim) {	   
   // Get Lender Name
   $strLenderName = "";  
   foreach ($lenderOptions as $lenderOption){
      if ($lenderOption['ClaimsLender']['id']==$claim['Claims']['lender_id']) {
		$strLenderName = $lenderOption['ClaimsLender']['lender'];
		if ($strLenderName == "ANZ EDGE")  {
		   $strLenderName = "ANZ";	
		}
	  }
   }  
        
   $currItem = $strLenderName;
   $currItemId = $claim['Claims']['lender_id'];      
   
   $currBroker = $claim['Users']['name'] . " " . $claim['Users']['surname'];      
   $currCompany = $claim['Users']['companyName'];      

   if ($prevItem != $currItem)  {   
	  $borderStyle = "style='border-top:solid;'";
   } else  {
	  $borderStyle = ""; 
   }
     
   if (($prevItem != $currItem) || ($reportSort == "broker") && ($currBroker != $prevBroker) || ($reportSort == "comapany") && ($currCompany != $prevCompany))   {
	   if ($subTotal > 0)  {	   
		   // Write Total Financed       
		   echo "<td align='right' nowrap " . $bgColor . "style='border-bottom:solid;'>$" . number_format($subTotal,2) . "</td>";
		   
		   // Write VBI %	   
		   // --------------------------------------------------------------------------
		   // Get VBI Struture Rate based on the total Lender transactions for the month
		   // --------------------------------------------------------------------------
		   $vbiRate = 0;
		   foreach ($claimsLender as $claims) {   
			  if ($claims['lenders']['lender'] == $prevItem)  {			  
				 $vbiRate =  "";
				 foreach ($vbiStructures as $vbiStructure){	  						
					 if ($prevItemId == $vbiStructure['Vbis']['lender_id'])  { 			
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
			 
						if ($claims[0]['amounts'] >= $rangeStart)  {
						   if ($rangeEnd != "")  {
							  if ($claims[0]['amounts'] < $rangeEnd)  {    	
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
		   // --------------------------------------------------------------------------
		   if ($vbiRate > 0)  {
			  // Write VBI %
			  $vbiCalRate = $vbiRate - $settingMgtFee;
			  echo "<td nowrap " . $bgColor . "style='border-bottom:solid;'>" . $vbiCalRate . "</td>";
	   
			  // Write VBI $     
			  $vbiAmount = $subTotal * ($vbiCalRate / 100);   
			  echo "<td align='right' nowrap " . $bgColor . "style='border-bottom:solid;'>$" . number_format($vbiAmount,2) . "</td>";   
			  
			  $VBITotal += $vbiAmount;	  		  
			  $brokerVBITotal += $vbiAmount;
			  $companyVBITotal += $vbiAmount;
		   } else  {
			  echo "<td nowrap " . $bgColor . "style='border-bottom:solid;'></td>";  
			  echo "<td nowrap " . $bgColor . "style='border-bottom:solid;'></td>";  		  
		   }
	     
	   } else  {
		   echo "<td nowrap " . "style='border-bottom:solid;'></td>";  
		   echo "<td nowrap " . "style='border-bottom:solid;'></td>"; 
		   echo "<td nowrap " . "style='border-bottom:solid;'></td>";  	
	   }
	   echo "</tr>";   	   	   	   	   
	   	   
	   $subTotal = 0;
   } else  {	  
	   echo "</tr>";   	   	   
   }
   
   if ($claim['Claims']['vbi'] != 1)  {
	  $bgColor = "bgcolor='#FFC000'";   
   } else  {
      $bgColor = "";
   }   
   
   // For Report sorted by Broker
   if (($reportSort == "broker") && ($currBroker != $prevBroker))  {
	   if ($prevBroker != "")  {
		  // Write Total Volume for Broker
		  echo "<tr>";
		  echo "<td style='border-top:solid;'></td>";
		  echo "<td align='right' style='border-top:solid;border-bottom:double'>" . number_format($brokerTotal, 2) . "</td>";
		  echo "<td colspan='8' style='border-top:solid;'></td>";
		  echo "<td align='right' style='border-top:solid;'><b>" . number_format($brokerVBITotal,2) . "</b></td>";
		  echo "</tr>";
 	      echo "<tr><td></td></tr>";
	   }
	   writeHeadings($currBroker);
	   
	   $brokerTotal = 0;
	   $brokerVBITotal = 0;
	   
	   $borderStyle = "";
	   $prevBroker = $currBroker;	   
   }
   
   // For Report sorted by Company
   if (($reportSort == "company") && ($currCompany != $prevCompany))  {
	   if ($prevCompany != "")  {
		  // Write Total Volume for Company
		  echo "<tr>";
		  echo "<td style='border-top:solid;'></td>";
		  echo "<td align='right' style='border-top:solid;border-bottom:double'>" . number_format($companyTotal, 2) . "</td>";
		  echo "<td colspan='8' style='border-top:solid;'></td>";
		  echo "<td align='right' style='border-top:solid;'><b>" . number_format($companyVBITotal,2) . "</b></td>";
		  echo "</tr>";
 	      echo "<tr><td></td></tr>";
	   }
	   writeHeadings($currCompany);
	   
	   $companyTotal = 0;
	   $companyVBITotal = 0;
	   
	   $borderStyle = "";
	   $prevCompany = $currCompany;	   
   }
   
   echo "<tr>";   	
   // Write Client Name
   echo "<td nowrap " . $bgColor . $borderStyle . ">" . $claim['Claims']['clientName'] . "</td>";
   
   // Write Amount Financed  
   echo "<td align='right' " . $bgColor . $borderStyle . ">$" . number_format($claim['Claims']['amount'], 2) . "</td>";
   
   // Write Notes   
   //echo "<td nowrap " . $bgColor . "></td>";
   
   // Write Settlement Date  
   echo "<td nowrap " . $bgColor . $borderStyle . ">" . date("d/m/Y", strtotime($claim[0]['ClaimSettlementDate'])) . "</td>";
   
   // Write Actioned
   if ($claim['Claims']['actioned'] == 0)  {
	  echo "<td align='center' " . $bgColor . $borderStyle . ">No</td>";
   } else  {
      echo "<td align='center' " . $bgColor . $borderStyle . ">Yes</td>";
   }
  
   // Write Broker Name   
   echo "<td nowrap " . $bgColor . $borderStyle . ">" . $claim['Users']['name'] . " " . $claim['Users']['surname'] . "</td>";
   
   // Write Company Name
   echo "<td nowrap " . $bgColor . $borderStyle . ">" . $claim['Users']['companyName'] . "</td>";
   
   // Write Lender      
   echo "<td align='left' " . $bgColor . $borderStyle . ">" . $strLenderName . "</td>";  
	
   // Write Shareholder       
   echo "<td nowrap " . $bgColor . $borderStyle . ">" . $strBrokerName . "</td>";		   
      
   if ($claim['Claims']['vbi'] == 0)  {     
      $totalNonVBIVolume += $claim['Claims']['amount'];
   }
   $totalVolume += $claim['Claims']['amount'];
   
   if ($claim['Claims']['vbi'] == 1)  {
      $subTotal += $claim['Claims']['amount'];
   }
   
   $brokerTotal += $claim['Claims']['amount'];   
   $companyTotal += $claim['Claims']['amount'];   
   
   $prevItem = $strLenderName;
   $prevItemId = $claim['Claims']['lender_id'];
 
   $prevBroker = $claim['Users']['name'] . " " . $claim['Users']['surname'];
   $prevCompany = $claim['Users']['companyName'] ;
}

// Write Total Financed       
echo "<td  align='right' nowrap " . $bgColor . "style='border-bottom:solid;'>$" . number_format($subTotal,2) . "</td>";
	   
// Write VBI %       
// --------------------------------------------------------------------------
// Get VBI Struture Rate based on the total Lender transactions for the month
// --------------------------------------------------------------------------
$vbiRate = 0;
foreach ($claimsLender as $claims) {   
  if ($claims['lenders']['lender'] == $prevItem)  {			  
	 $vbiRate =  "";
	 foreach ($vbiStructures as $vbiStructure){	  						
		 if ($prevItemId == $vbiStructure['Vbis']['lender_id'])  { 			
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
 
			if ($claims[0]['amounts'] >= $rangeStart)  {
			   if ($rangeEnd != "")  {
				  if ($claims[0]['amounts'] < $rangeEnd)  {    	
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
// --------------------------------------------------------------------------
if ($vbiRate > 0)  {
   // Write VBI %
   $vbiCalRate = $vbiRate - $settingMgtFee;
   echo "<td nowrap " . $bgColor . "style='border-bottom:solid;'>" . $vbiCalRate . "</td>";
      
   // Write VBI $     
   $vbiAmount = $subTotal * ($vbiCalRate / 100);   
   echo "<td align='right' nowrap " . $bgColor . "style='border-bottom:solid;'>$" . number_format($vbiAmount,2) . "</td>";   
} else  {
   echo "<td nowrap " . $bgColor . "style='border-bottom:solid;'></td>";  
   echo "<td nowrap " . $bgColor . "style='border-bottom:solid;'></td>";  		  
}
	   
echo "</tr>";   	

$VBITotal += $vbiAmount;

// Write Total Volume for Broker
if ($reportSort == "broker")  {
	$brokerVBITotal += $vbiAmount;
	echo "<tr>";
	echo "<td style='border-top:solid;'></td>";
	
	echo "<td align='right' style='border-top:solid;border-bottom:double'>$" . number_format($brokerTotal, 2) . "</td>";
	echo "<td colspan='8' style='border-top:solid;'></td>";
	echo "<td align='right'><b>$" . number_format($brokerVBITotal,2) . "</b></td>";
	echo "</tr>";
	echo "<tr><td></td></tr>";
}

//  Write Total Volume for Company
if ($reportSort == "company")  {
	$companyVBITotal += $vbiAmount;
	
	echo "<tr>";
	echo "<td style='border-top:solid;'></td>";
	
	echo "<td align='right' style='border-top:solid;border-bottom:double'>" . number_format($companyTotal, 2) . "</td>";
	echo "<td colspan='8' style='border-top:solid;'></td>";
	echo "<td align='right' style='border-top:solid;'><b>" . number_format($companyVBITotal,2) . "</b></td>";
	echo "</tr>";
	echo "<tr><td></td></tr>";
}  

// Write Total Volume
echo "<tr>";

if (($reportSort == "broker") || ($reportSort == "company")) {
   echo "<td></td>";
} else  {
	echo "<td style='border-top:solid;'></td>";
}
echo "<td align='right' style='border-top:solid;border-bottom:double'>$" . number_format($totalVolume, 2) . "</td>";

if (($reportSort == "broker") || ($reportSort == "company")) {
   echo "<td colspan='8'></td>";
} else  {
	echo "<td colspan='8' style='border-top:solid;'></td>";
}

echo "<td align='right'><b>$" . number_format($VBITotal,2) . "</b></td>";
echo "</tr>";

// Write Blank Rows
echo "<tr><td></td></tr>";

// Write Total Volume
echo "<tr>";
echo "<td bgcolor='#F8CBAD'>Total Volume</td>";
echo "<td bgcolor='#F8CBAD' align='right'>$" . number_format($totalVolume, 2) . "</td>";

// Legend
echo "<td></td>";
echo "<td><b>Legend</b></td>";
echo "</tr>";

// Write Non VBI
echo "<tr>";
echo "<td bgcolor='#F8CBAD'>less Non VBI</td>";
echo "<td bgcolor='#F8CBAD' align='right'><font color='red'>-$" . number_format($totalNonVBIVolume, 2) . "</font></td>";

// Legend
echo "<td></td>";
echo "<td bgcolor='#FFC000'><b></b></td>";
echo "<td>Highlighted transactions are Non-VBI</td>";
echo "</tr>";

// Write Total VBI Applicable
$totalVBIVolume = $totalVolume - $totalNonVBIVolume;
echo "<tr>";
echo "<td bgcolor='#F8CBAD'>Total VBI Applicable " . substr($period, 0, 3) . "</td>";
echo "<td bgcolor='#F8CBAD' align='right'>$" . number_format($totalVBIVolume, 2) . "</td>";
echo "</tr>";

$cbaIncentive = 0;
$clawback = 0;
foreach ($vbiSplits as $vbiSplit) {
	$cbaIncentive += $vbiSplit['VbisSplit']['cba_doc_fee_incentive'];
	$clawback += $vbiSplit['VbisSplit']['clawback'];
}
	
// Write Total Financier Amt Received
//$x6 = $totalVBIVolume * 0.006;
echo "<tr>";
echo "<td bgcolor='#F8CBAD'>Total Financier Amt Received (less " . $settingMgtFee . "%)</td>";
//echo "<td bgcolor='#F8CBAD' align='right'>$" . number_format($x6, 2) . "</td>";
echo "<td bgcolor='#F8CBAD' align='right'>$" . number_format($VBITotal, 2) . "</td>";
echo "</tr>";

// Write CBA Incentive   
echo "<tr>";
echo "<td bgcolor='#F8CBAD'>plus CBA Incentive</td>";
echo "<td bgcolor='#F8CBAD' align='right'>$ " . number_format($cbaIncentive, 2) . "</td>";
echo "</tr>";

// Write Clawback  
echo "<tr>";
echo "<td bgcolor='#F8CBAD'>less Clawback</td>";
echo "<td bgcolor='#F8CBAD' align='right'><font color='red'>-$" . number_format($clawback, 2) . "</font></td>";
echo "</tr>";

// Write Total VBI Applicable
//$grandTotalVolume = $x6 + $cbaIncentive - $clawback;
$grandTotalVolume = $VBITotal + $cbaIncentive - $clawback;
echo "<tr>";
echo "<td bgcolor='#F8CBAD' nowrap><b>Total VBI Applicable " . substr($period, 0, 3) . " " . substr($period, strlen($period)-4, strlen($period)-1) . " (inc GST)</b></td>";
echo "<td bgcolor='#F8CBAD' align='right'><b>$" . number_format($grandTotalVolume, 2) . "</b></td>";
echo "</tr>";

// Write Blank Rows
echo "<tr><td></td></tr>";

// Write Clawbacks
echo "<tr><td><b><u>Clawbacks</b></u></td></tr>";
echo "<tr>";
echo "<td><b>CBA Doc Fee Incentive Note</b></td>";
echo "<td align='right'><b>Amount</b></td>";
echo "<td colspan='3'><b>Clawback Note</b></td>";
echo "<td align='right'><b>Amount</b></td>";
echo "</tr>";
	
foreach ($vbiSplits as $vbiSplit) {
  echo "<tr>";
  
  // CBA Doc Fee Incentive
  echo "<td align='left'>". $vbiSplit['VbisSplit']['cba_doc_fee_incentive_note'] . "</td>";
  if ($vbiSplit['VbisSplit']['cba_doc_fee_incentive'] > 0)  {
	 echo "<td align='right'>$". number_format($vbiSplit['VbisSplit']['cba_doc_fee_incentive'],2) . "</td>";
  } else  {
	 echo "<td></td>";	
  }	
  
  // Clawback
  echo "<td align='left' colspan='3' nowrap>". $vbiSplit['VbisSplit']['clawback_note'] . "</td>";
  if ($vbiSplit['VbisSplit']['clawback'] > 0)  {
	 echo "<td align='right'>$". number_format($vbiSplit['VbisSplit']['clawback'],2) . "</td>";
  } else  {
	 echo "<td></td>";	
  }
  
  echo "</tr>";
}

echo "</table>";

function writeHeadings($broker)  {
	if ($broker != "")  {
	   echo "<tr>";
	   echo "<td align='left' bgcolor='#BDD7EE'><u><b>" . $broker . "</b></u></td>";
	   echo "</tr>";	
	}
	
	echo "<tr>";
	echo "<td align='left' style='width:300' bgcolor='#BDD7EE'>Client Name</td>";
	echo "<td align='center' bgcolor='#BDD7EE'>Amount Financed</td>";
	//echo "<td align='left' bgcolor='#BDD7EE'>Notes</td>";
	echo "<td align='center' bgcolor='#BDD7EE'>Settlement Date</td>";
	echo "<td align='center' bgcolor='#BDD7EE'>Actioned</td>";
	echo "<td align='left' bgcolor='#BDD7EE'>Broker Name</td>";
	echo "<td align='left' bgcolor='#BDD7EE'>Company Name</td>";
	echo "<td align='left' bgcolor='#BDD7EE'>Lender</td>";
	echo "<td align='left' bgcolor='#BDD7EE'>Shareholder</td>";
	echo "<td align='left' bgcolor='#BDD7EE'>Total Financed</td>";
	echo "<td align='left' bgcolor='#BDD7EE'>VBI %</td>";
	echo "<td align='left' bgcolor='#BDD7EE'>VBI $</td>";
	echo "</tr>";	
}
?> 
