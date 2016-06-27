<?php
//App::import("Vendor", "Excel/Classes/PHPExcel");
App::import('Vendor','Excel/Classes/PHPExcel', array('file' => 'PHPExcel.php'));

$objPHPExcel = new PHPExcel();

$objWorksheet = $objPHPExcel->getActiveSheet();

if (sizeof($claimsPeriod) > 0)  {
  // ***********************************************************************************************************************
  // Financier
  // ***********************************************************************************************************************
  $fromArray = array();
  
  // Add Headings
  $values = array();
  array_push($values, 'Financier');
  array_push($values, $period);
  array_push($fromArray, $values);
  
  $rowCounter = 1;
  $financierTotal = 0;
  $claimAmt = 0;
  foreach ($claimsPeriod as $claimPeriod)  {
	  $values = array();
	  
	  // Get Lender
	 $strLenderName = "";  
	 foreach ($lenderOptions as $lenderOption){
		if ($lenderOption['ClaimsLender']['id'] == $claimPeriod['Claims']['lender_id']) {
		  $strLenderName = $lenderOption['ClaimsLender']['lender'];
		  
		  if ($strLenderName == "ANZ EDGE")  {
		     $strLenderName = "ANZ/ANZ Edge";	
		  }
		}
	 }      
	 
	  if ($claimPeriod['Claims']['lender_id'] != "1")  {
		 $claimAmt += $claimPeriod['0']['amounts'];
		 
	     array_push($values, $strLenderName);		
	     array_push($values, $claimAmt);
	     array_push($fromArray, $values);
	  
	     $rowCounter++;
	     $financierTotal += $claimAmt;
		 $claimAmt = 0;
	  } else  {
		 $claimAmt += $claimPeriod['0']['amounts'];  
	  }
  }
  
  // Add Financier Total
  $values = array();
  array_push($values, '', $financierTotal);
  array_push($fromArray, $values);
  
  $objWorksheet->fromArray($fromArray);
  
  //	Set the Labels for each data series we want to plot
  $dataseriesLabels = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$1', NULL, 1),	
	  //new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	
  );
  //	Set the X-Axis Labels
  $xAxisTickValues = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$' . $rowCounter, NULL, 4),	
  );
  //	Set the Data values for each data series we want to plot
  $dataSeriesValues = array(
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$2:$B$' . $rowCounter, NULL, 4),
	  //new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$' . $rowCounter, NULL, 4),
  );
  
  //	Build the dataseries
  $series = new PHPExcel_Chart_DataSeries(
	  PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
	  PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,	// plotGrouping
	  range(0, count($dataSeriesValues)-1),			// plotOrder
	  $dataseriesLabels,								// plotLabel
	  $xAxisTickValues,								// plotCategory
	  $dataSeriesValues								// plotValues
  );
  //	Set additional dataseries parameters
  $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
  
  //	Set the series in the plot area
  $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
  
  //	Set the chart legend
  $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
  
  $title = new PHPExcel_Chart_Title('Financier');
  
  //	Create the chart
  $chart = new PHPExcel_Chart(
	  'financier',	// name
	  $title,			// title
	  $legend,		// legend
	  $plotarea,		// plotArea
	  true,			// plotVisibleOnly
	  0,				// displayBlanksAs
	  NULL			// xAxisLabel
	  //$yAxisLabel	// yAxisLabel
  );
  
  //	Set the position where the chart should appear in the worksheet
  $chart->setTopLeftPosition('D2');
  $chart->setBottomRightPosition('I' . $rowCounter);
  
  //	Add the chart to the worksheet
  $objWorksheet->addChart($chart);
  
  // Cell Styling
  $rowEndStyle = $rowCounter + 1;
  $objWorksheet->getStyle('B2:B'.  $rowEndStyle)->getNumberFormat()->setFormatCode("[$$-C09]#,##0.00");
  $objWorksheet->getStyle('A1:B1')->getFont()->setBold(true);
  $objWorksheet->getStyle('B' . $rowEndStyle)->getFont()->setBold(true);
  // ***********************************************************************************************************************
  // Financier Volume
  // ***********************************************************************************************************************
  // Add Blank Entries to Array
  $values = array();
  array_push($values, '');
  array_push($fromArray, $values);
  array_push($fromArray, $values);
  
  $rowCounter += 5;
  $rowStart = $rowCounter;
  
  // Add Headings
  $values = array();
  array_push($values, 'Financier Volume');
  array_push($values, $period);
  array_push($fromArray, $values);
  
  // Get Total Volume
  $totalVolume = 0;
  foreach ($claimsPeriod as $claimPeriod)  {
	  $totalVolume += $claimPeriod['0']['amounts'];
  }
  
  $claimAmt = 0;
  
  foreach ($claimsPeriod as $claimPeriod)  {
	  $values = array();
	  
	  // Get Lender
	 $strLenderName = "";  
	 foreach ($lenderOptions as $lenderOption){
		if ($lenderOption['ClaimsLender']['id']==$claimPeriod['Claims']['lender_id']) {
		  $strLenderName = $lenderOption['ClaimsLender']['lender'];
		  if ($strLenderName == "ANZ EDGE")  {
		     $strLenderName = "ANZ/ANZ Edge";	
		  }
		}
	 }      
	 
	  if ($claimPeriod['Claims']['lender_id'] != "1")  {
		 $claimAmt += $claimPeriod['0']['amounts'];
		 
	     $volumePercent = ($claimAmt / $totalVolume)  * 100;
	     array_push($values, $strLenderName);		
	     array_push($values, number_format($volumePercent,2));
	     array_push($fromArray, $values);
	  
	     $rowCounter++;
		 $claimAmt = 0;
	  } else  {
		 $claimAmt += $claimPeriod['0']['amounts'];  
	  }
  }
  
  $objWorksheet->fromArray($fromArray);
  
  $rowEnd = $rowCounter - 1;
  //	Set the Labels for each data series we want to plot
  $dataseriesLabels = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.$rowStart, NULL, 1),		
  );
  //	Set the X-Axis Labels
  $xAxisTickValues = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$' . $rowStart . ':$A$' . $rowEnd, NULL, 4),	
  );
  //	Set the Data values for each data series we want to plot
  $dataSeriesValues = array(
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$' . $rowStart . ':$B$' . $rowEnd, NULL, 4),	
  );
  
  //	Build the dataseries
  $series = new PHPExcel_Chart_DataSeries(
	  PHPExcel_Chart_DataSeries::TYPE_PIECHART,		// plotType
	  PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
	  range(0, count($dataSeriesValues)-1),			// plotOrder
	  $dataseriesLabels,								// plotLabel
	  $xAxisTickValues,								// plotCategory
	  $dataSeriesValues								// plotValues
  );
  
  //	Set the series in the plot area
  $layout1 = new PHPExcel_Chart_Layout();
  $layout1->setShowCatName(TRUE);
  $layout1->setShowVal(TRUE);
  $layout1->setShowPercent(TRUE);
  $plotarea = new PHPExcel_Chart_PlotArea($layout1, array($series));
  
  //	Set the chart legend
  $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
  
  $title = new PHPExcel_Chart_Title('Financier Volume');
  
  //	Create the chart
  $chart = new PHPExcel_Chart(
	  'financier',	// name
	  $title,			// title
	  $legend,		// legend
	  $plotarea,		// plotArea
	  true,			// plotVisibleOnly
	  0,				// displayBlanksAs
	  NULL,			// xAxisLabel
	  NULL			// yAxisLabel
  );
  
  //	Set the position where the chart should appear in the worksheet
  $rowEndStyle = $rowCounter - 1;
  $chart->setTopLeftPosition('D' . $rowStart);
  $chart->setBottomRightPosition('I' . $rowEndStyle);
  
  //	Add the chart to the worksheet
  $objWorksheet->addChart($chart);
  
  // Cell Styling
  $rowStartStyle = $rowStart - 1;
  $objWorksheet->getStyle('A' . $rowStartStyle . ':B' . $rowStartStyle)->getFont()->setBold(true);
  // ***********************************************************************************************************************
  // Broker Group Contribution
  // ***********************************************************************************************************************
  // Add Blank Entries to Array
  $values = array();
  array_push($values, '');
  array_push($fromArray, $values);
  array_push($fromArray, $values);
  array_push($fromArray, $values);
  
  $rowCounter += 4;
  $rowStart = $rowCounter;
  
  // Add Headings
  $values = array();
  array_push($values, 'Broker Group Contribution');
  array_push($values, 'ANZ/ANZ Edge', 'BOM', 'BOQ', 'CBA', 'CFAL', 'MAQ', 'NAB', 'WPC', 'Other', 'Suncorp');
  array_push($fromArray, $values);
  
  //$rowCounter = 0;
  $currentBroker = "";
  
  $anzAmt = 0;
  $bomAmt = 0;
  $boqAmt = 0;
  $cbaAmt = 0;
  $cfalAmt = 0;
  $maqAmt = 0;
  $nabAmt = 0;
  $wpcAmt = 0;
  $otherAmt = 0;
  $suncorpAmt = 0;
  $anzTotal = 0;
  $bomTotal = 0;
  $boqTotal = 0;
  $cbaTotal = 0;
  $cfalTotal = 0;
  $maqTotal = 0;
  $nabTotal = 0;
  $wpcTotal = 0;
  $otherTotal = 0;
  $suncorpTotal = 0;
  
  foreach ($claimByBrokerGroups as $claimPeriod)  {
	  $values = array();		   
	  
	  if (($currentBroker !=  $claimPeriod['Users']['parent_user_id'])  && ($currentBroker != "")) {		
		  // Get Broker
		  $strBrokerName = "";  
		  foreach ($brokerOptions as $brokerOption){
			 if ($brokerOption['Users']['id']==$currentBroker) {
				$strBrokerName = $brokerOption['Users']['companyName'];
			}
		 }   
	  
		  array_push($values, $strBrokerName);		
		  array_push($values, $anzAmt, $bomAmt, $boqAmt, $cbaAmt, $cfalAmt, $maqAmt, $nabAmt, $wpcAmt, $otherAmt, $suncorpAmt);
		  array_push($fromArray, $values);
				 
		  $anzAmt = 0;
		  $bomAmt = 0;
		  $boqAmt = 0;
		  $cbaAmt = 0;
		  $cfalAmt = 0;
		  $maqAmt = 0;
		  $nabAmt = 0;
		  $wpcAmt = 0;
		  $otherAmt = 0;
		  $suncorpAmt = 0;
		  
		  $currentBroker = $claimPeriod['Users']['parent_user_id'];
		  $rowCounter++;
		 
	  }  else  {
		 $currentBroker = $claimPeriod['Users']['parent_user_id'];	
	  }
	  
	  switch ($claimPeriod['Claims']['lender_id'])  {
		 case 1:   $anzAmt 	    += $claimPeriod['0']['amounts'];	$anzTotal += $claimPeriod['0']['amounts']; 			break;		  
		 case 2:   $bomAmt  	     = $claimPeriod['0']['amounts'];	$bomTotal += $claimPeriod['0']['amounts']; 			break;
		 case 3:   $boqAmt  		 = $claimPeriod['0']['amounts'];	$boqTotal += $claimPeriod['0']['amounts']; 			break;
		 case 4:   $cfalAmt 		 = $claimPeriod['0']['amounts'];	$cfalTotal += $claimPeriod['0']['amounts'];			break;
		 case 5:   $cbaAmt  		 = $claimPeriod['0']['amounts'];	$cbaTotal += $claimPeriod['0']['amounts']; 			break;
		 case 6:   $maqAmt  		 = $claimPeriod['0']['amounts'];	$maqTotal += $claimPeriod['0']['amounts']; 			break;
		 case 7:   $nabAmt  		 = $claimPeriod['0']['amounts'];	$nabTotal += $claimPeriod['0']['amounts']; 			break;
		 case 8:   $suncorpAmt	 = $claimPeriod['0']['amounts'];	$suncorpTotal += $claimPeriod['0']['amounts'];	 	break;
		 case 17:  $anzAmt 	    += $claimPeriod['0']['amounts'];	$anzTotal += $claimPeriod['0']['amounts']; 			break;
		 default:  $otherAmt      += $claimPeriod['0']['amounts'];	$otherTotal += $claimPeriod['0']['amounts']; 		break;
	  }	   		
  }
  
  // Write last row
  $strBrokerName = "";  
  foreach ($brokerOptions as $brokerOption){
	 if ($brokerOption['Users']['id']==$currentBroker) {
		$strBrokerName = $brokerOption['Users']['companyName'];
	 }
  }   
	  
  array_push($values, $strBrokerName);		
  array_push($values, $anzAmt, $bomAmt, $boqAmt, $cbaAmt, $cfalAmt, $maqAmt, $nabAmt, $wpcAmt, $otherAmt, $suncorpAmt);
  array_push($fromArray, $values);
  
  // Add Broker Group Contribution Totals
  $values = array();
  array_push($values, '', $anzTotal, $bomTotal, $boqTotal, $cbaTotal, $cfalTotal, $maqTotal, $nabTotal, $wpcTotal, $otherTotal, $suncorpTotal);
  array_push($fromArray, $values);
  
  $objWorksheet->fromArray($fromArray);
  
  $objWorksheet->fromArray($fromArray);
  
  //	Set the Labels for each data series we want to plot
  $rowLabel = $rowStart - 1;
  $dataseriesLabels = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$B$' . $rowLabel, NULL, 1),
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$' . $rowLabel, NULL, 1),	
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$D$' . $rowLabel, NULL, 1),	
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$E$' . $rowLabel, NULL, 1),
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$F$' . $rowLabel, NULL, 1),
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$G$' . $rowLabel, NULL, 1),
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$H$' . $rowLabel, NULL, 1),
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$I$' . $rowLabel, NULL, 1),
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$J$' . $rowLabel, NULL, 1),
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$K$' . $rowLabel, NULL, 1),	
  );
  //	Set the X-Axis Labels
  $xAxisTickValues = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$' . $rowStart .':$A$' . $rowCounter, NULL, 4),	
  );
  //	Set the Data values for each data series we want to plot
  $dataSeriesValues = array(
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$' . $rowStart .':$B$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$' . $rowStart .':$C$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$D$' . $rowStart .':$D$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$E$' . $rowStart .':$E$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$F$' . $rowStart .':$F$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$G$' . $rowStart .':$G$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$H$' . $rowStart .':$H$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$I$' . $rowStart .':$I$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$J$' . $rowStart .':$J$' . $rowCounter, NULL, 4),
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$K$' . $rowStart .':$K$' . $rowCounter, NULL, 4),	
  );
  
  //	Build the dataseries
  $series = new PHPExcel_Chart_DataSeries(
	  PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
	  PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
	  range(0, count($dataSeriesValues)-1),			// plotOrder
	  $dataseriesLabels,								// plotLabel
	  $xAxisTickValues,								// plotCategory
	  $dataSeriesValues								// plotValues
  );
  //	Set additional dataseries parameters
  $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
  
  //	Set the series in the plot area
  $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
  
  //	Set the chart legend
  $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
  
  $title = new PHPExcel_Chart_Title('Broker Group Contribution');
  
  //	Create the chart
  $chart = new PHPExcel_Chart(
	  'financier',	// name
	  $title,			// title
	  $legend,		// legend
	  $plotarea,		// plotArea
	  true,			// plotVisibleOnly
	  0,				// displayBlanksAs
	  NULL			// xAxisLabel
	  //$yAxisLabel	// yAxisLabel
  );
  
  //	Set the position where the chart should appear in the worksheet
  $rowEnd = $rowCounter + 10;
  $chart->setTopLeftPosition('M' . $rowStart);
  $chart->setBottomRightPosition('U' . $rowEnd);
  
  //	Add the chart to the worksheet
  $objWorksheet->addChart($chart);
  
  // Cell Styling
  $rowCounter++;
  $rowStartStyle = $rowStart - 1;
  $rowEndStyle = $rowCounter;
  
  $objWorksheet->getStyle('B' . $rowStartStyle . ':K'.  $rowCounter)->getNumberFormat()->setFormatCode("[$$-C09]#,##0.00");
  $objWorksheet->getStyle('A' . $rowStartStyle . ':K' . $rowStartStyle)->getFont()->setBold(true);
  $objWorksheet->getStyle('A' . $rowStartStyle . ':K' . $rowStartStyle)->getFont()->setBold(true);
  $objWorksheet->getStyle('B' . $rowEndStyle . ':K' . $rowEndStyle)->getFont()->setBold(true);
  // ***********************************************************************************************************************
  // Broker Group Volume
  // ***********************************************************************************************************************
  // Add Blank Entries to Array
  $values = array();
  array_push($values, '');
  array_push($fromArray, $values);
  array_push($fromArray, $values);
  
  $rowCounter += 4;
  $rowStart = $rowCounter;
  
  // Add Headings
  $values = array();
  array_push($values, 'Broker Group Volume ($ and %)');
  array_push($values, $period);
  array_push($fromArray, $values);
  
  $currentBroker = "";
  $amt = 0;
  $brokerGroupVolumeTotal = 0;
  
  foreach ($claimByBrokerGroups as $claimPeriod)  {
	  $values = array();		   
		 
	  if (($currentBroker !=  $claimPeriod['Users']['parent_user_id'])  && ($currentBroker != "")) {
		  // Get Broker
		  $strBrokerName = "";  
		  foreach ($brokerOptions as $brokerOption){
			 if ($brokerOption['Users']['id']==$currentBroker) {
				$strBrokerName = $brokerOption['Users']['companyName'];
			}
		 }   
	  
		  array_push($values, $strBrokerName);		
		  array_push($values, $amt);
		  array_push($fromArray, $values);
				 
		  $amt = 0;		
		  
		  $currentBroker = $claimPeriod['Users']['parent_user_id'];
		  $rowCounter++;
		 
	  }  else  {	       
		  $currentBroker = $claimPeriod['Users']['parent_user_id'];
	  }
	  
	  $amt += $claimPeriod['0']['amounts']; 	
	  $brokerGroupVolumeTotal += $claimPeriod['0']['amounts'];
  }
  // Write last row
  $strBrokerName = "";  
  foreach ($brokerOptions as $brokerOption){
	 if ($brokerOption['Users']['id']==$currentBroker) {
		$strBrokerName = $brokerOption['Users']['companyName'];
	 }
  }   
	  
  array_push($values, $strBrokerName);		
  array_push($values, $amt);
  array_push($fromArray, $values);
  
  // Add Broker Group Contribution Totals
  $values = array();
  array_push($values, '', $brokerGroupVolumeTotal);
  array_push($fromArray, $values);
  
  $objWorksheet->fromArray($fromArray);
  
  //	Set the Labels for each data series we want to plot
  $dataseriesLabels = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$'.$rowStart, NULL, 1),		
  );
  //	Set the X-Axis Labels
  $xAxisTickValues = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$' . $rowStart . ':$A$' . $rowCounter, NULL, 4),	
  );
  //	Set the Data values for each data series we want to plot
  $dataSeriesValues = array(
	  new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$B$' . $rowStart . ':$B$' . $rowCounter, NULL, 4),	
  );
  
  //	Build the dataseries
  $series = new PHPExcel_Chart_DataSeries(
	  PHPExcel_Chart_DataSeries::TYPE_PIECHART,		// plotType
	  PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
	  range(0, count($dataSeriesValues)-1),			// plotOrder
	  $dataseriesLabels,								// plotLabel
	  $xAxisTickValues,								// plotCategory
	  $dataSeriesValues								// plotValues
  );
  
  //	Set the series in the plot area
  $layout1 = new PHPExcel_Chart_Layout();
  $layout1->setShowCatName(TRUE);
  $layout1->setShowVal(TRUE);
  $layout1->setShowPercent(TRUE);
  $plotarea = new PHPExcel_Chart_PlotArea($layout1, array($series));
  
  //	Set the chart legend
  $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
  
  $title = new PHPExcel_Chart_Title('Broker Group Volume');
  
  //	Create the chart
  $chart = new PHPExcel_Chart(
	  'financier',	// name
	  $title,			// title
	  $legend,		// legend
	  $plotarea,		// plotArea
	  true,			// plotVisibleOnly
	  0,				// displayBlanksAs
	  NULL,			// xAxisLabel
	  NULL			// yAxisLabel
  );
  
  //	Set the position where the chart should appear in the worksheet
  $rowEnd = $rowCounter + 10;
  $chart->setTopLeftPosition('D' . $rowStart);
  $chart->setBottomRightPosition('I' . $rowEnd);
  
  //	Add the chart to the worksheet
  $objWorksheet->addChart($chart);
  
  // Cell Styling
  $rowStartStyle = $rowStart - 1;
  $rowEndStyle = $rowCounter + 1;
  
  $objWorksheet->getStyle('B' . $rowStartStyle . ':B'.  $rowEndStyle)->getNumberFormat()->setFormatCode("[$$-C09]#,##0.00");
  $objWorksheet->getStyle('A' . $rowStartStyle . ':B' . $rowStartStyle)->getFont()->setBold(true);
  $objWorksheet->getStyle('B' . $rowEndStyle)->getFont()->setBold(true);
  // ***********************************************************************************************************************
  // Adjust Column Widths
  foreach(range('A','K') as $columnID) {
	  $objWorksheet->getColumnDimension($columnID) ->setAutoSize(true);
  }
} else  {
  // Write No Data Error Message
  $fromArray = array();
  $values = array();
  array_push($values, 'No Data available for the selected period: ' . $period);
  array_push($fromArray, $values);	
  $objWorksheet->fromArray($fromArray);
  $objWorksheet->getStyle('A1')->getFont()->setBold(true);
}

// Write Spreadsheet
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);

// Output Excel to Browser
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Graph Master Data " . $period . ".xls"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');

$objWriter->save('php://output');
exit;

?>
