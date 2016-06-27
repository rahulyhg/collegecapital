<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"VBI Structure.xls" );
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
echo "<h1><u>College Capital VBI structure</u></h2>";
//echo "<h2>Period: " . $period . "</h2>";

$preLenderName = "";
$counter = 0;

echo "<table><tr><td></td></tr><tr>";

foreach ($vbi as $vbiItem){	  
    foreach ($lenderOptions as $lenderOption){						
		if($lenderOption['ClaimsLender']['id']==$vbiItem['Vbi']['lender_id']){
			$strLenderName = $lenderOption['ClaimsLender']['lender'];
		}
	}
	
	// CHANGE REQUEST Nyree 06/07/2015
	// Combining of ANZ and ANZ Edge Transactions
	if (($strLenderName == "ANZ") || ($strLenderName == "ANZ EDGE"))  {
	   $strLenderName = "ANZ / ANZ Edge";
	}
	// END CHAGE REQUEST					
	 
	if ($strLenderName != $preLenderName)  {	
		if ($preLenderName != "")  {
			echo "</table>";
			echo "</table>";
		}
		
		if (($counter % 4) == 0)  {
			if ($counter > 0)  {
			   echo "<td></td>";
			}
		    echo "<td>";	
		}
		 $counter++;	
		
		echo "<p><table border='1' width=' 1000'><tr><td>";
		echo "<table>";
		echo "<tr>";
		echo "<td colspan='4' ><font color='green'>" . $strLenderName . "</font></td>";
		echo "</tr>";
		
		$preLenderName = $strLenderName;
	}
	
	echo "<tr>";		
	echo "<td align='center'>$" . (float)$vbiItem['Vbi']['range_start'] . $vbiItem['Vbi']['range_start_uom'];
	if ($vbiItem['Vbi']['range_end'] == '')  {
  	    echo "+";
	}
	echo "</td>";
	
	if ($vbiItem['Vbi']['range_end'] > 0)  {
	    echo "<td align='center'>to</td>";
	} else  {
		echo "<td align='center'></td>";
	}
	
	if ($vbiItem['Vbi']['range_end'] > 0)  {
	   echo "<td align='center'>$" . (float)$vbiItem['Vbi']['range_end'] . $vbiItem['Vbi']['range_end_uom'] . "</td>";
	} else  {
       echo "<td align='center'></td>";
	}
	echo "<td>" . $vbiItem['Vbi']['rate'] . "%</td>";
	echo "</tr>";
}
echo "</table>";
echo "</table>";
echo "</td></tr></table>";
?> 
