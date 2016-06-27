<?php
// Get Broker Name
$strBrokerName = "";  
foreach ($brokerGroups as $brokerGroup){	  
   $strBrokerName = $brokerGroup['Users']['companyName'];
}     
   
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Broker Expiring.xls" );
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

// Set Report Name
$strReportName = "College Capital - Broker Expiring Report,  ";
			 
if (isset($brokerName[0]["Users"]["companyName"]))  {
   $strReportName .= $brokerName[0]["Users"]["companyName"];
} else  {
    $strReportName .= "All Shareholders";
}

if ($lender != "")  {
   $strReportName .= ", All Lenders";
} else  {
	if (isset($claims[0]['Lenders']['lender']))  {
	   $strReportName .= ", " . $claims[0]['Lenders']['lender'];
	}
}

$startDate = explode("-", $startDate);
$startDate = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0];

$endDate = explode("-", $endDate);
$endDate = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0];

$strReportName .= " (" . $startDate . " to " . $endDate . ")";

// Write Headings
echo "<table>";
echo "<tr><td style='background-color:#8DB4E2' colspan='5'>";	
echo "<font size='4'><b>". $strReportName . "</b></font>";
echo "</td></tr>";

// Write Column Headigs
echo "<tr>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Shareholder</td>";
echo "<td align='left' style='width:80' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Lender</td>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Client Name</td>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Product Type</td>";
echo "<td align='left' style='width:130' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Settlement Date</td>";
echo "<td align='left' style='width:110' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Maturity Date</td>";
echo "<td align='left' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Goods Description</td>";
echo "<td align='left' style='width:60' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Term</td>";
echo "<td align='left' style='width:145' bgcolor='#BDD7EE' x:autofilterrange=\"A1:I1\">Financed Amount $</td>";
echo "</tr>";	


// Write rows
// ***************************************************************************************************************
$currentShareholder = "";

foreach ($claims as $claim) {	
    $settlementDate = date("d/m/Y", strtotime($claim[0]['ClaimSettlementDate']));
	$maturityDate = date("d/m/Y",strtotime(date("Y-m-d", strtotime($claim[0]['ClaimSettlementDate'])) . " +" . $claim['Claims']['terms'] . " months"));
//var_dump($claim);  
	
    echo "<tr>";    
	echo "<td align='left' nowrap>" . $claim['Users']['companyName'] . "</td>";
	echo "<td align='left' nowrap>" . $claim['Lenders']['lender'] . "</td>";
	echo "<td align='left' nowrap>" . $claim['Claims']['clientName'] . "</td>";	
	echo "<td align='left' nowrap>" . $claim['ProductTypes']['productType'] . "</td>";
	echo "<td align='center' nowrap>" . $settlementDate . "</td>";
	echo "<td align='center' nowrap>" . $maturityDate . "</td>";
	echo "<td align='left' nowrap>" . $claim['GoodsDescs']['goodsDescription'] . "</td>";
	echo "<td align='center' nowrap>" . $claim['Claims']['terms'] . "</td>";
	echo "<td align='right' nowrap>" . number_format($claim['Claims']['amount'], 2) . "</td>";
    echo "</tr>";	

    $currentShareholder = $claim['Users']['companyName'];
}

echo "</table>";

?> 
