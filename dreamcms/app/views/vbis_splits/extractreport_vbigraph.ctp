<script language="javascript" type="text/javascript">
function button_onclick(strAction)  {		
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";
	
	href = "http://" + strDomainName + "/vbis_splits/" + strAction + "/home/page:1/";
	errMsg = "";
	 
	switch (document.getElementById("VbisSplitReportData").value)  {		  		   
	       case '0': strMonth = document.getElementById("VbisSplitPeriodMonth").value;
	                 strYear = document.getElementById("VbisSplitPeriodYear").value;
					 
					 if ((strMonth == "") || (strYear == ""))  { 
					    errMsg = "Please select a Month and Year";
					 } else  {					
					    href += "month:" + strMonth + "/year:" + strYear;
					 }
				     break; 
		  
		   case '1': strMonth = document.getElementById("VbisSplitQuarterMonth").value;
	                 strYear = document.getElementById("VbisSplitQuarterYear").value;
					 
					 if ((strMonth == "") || (strYear == ""))  { 
					    errMsg = "Please select a Quarter and Year";
					 } else  {	 
 					    href += "qtrmonth:" + strMonth + "/qtryear:" + strYear;					
					 }
					 break;
		  
		   case '2': currentDate = new Date(); 		
		             strYear = currentDate.getFullYear();
					 href += "ytd:" + strYear;								 
				     break;
		   
		   case '3': strToDate = document.getElementById("ClaimToDate").value; 
		             strFromDate = document.getElementById("ClaimFromDate").value; 
		             
					 if ((strToDate == "") || (strFromDate == ""))  { 
					    errMsg = "Please select a Start Date and End Date";
					 } else  {	
					    href += "todate:" + strToDate + "/fromdate:" + strFromDate;					
					 }
				     break;
    }
	
	if (errMsg == "")  {	
	   location.href= href;
	} else  {
	   alert(errMsg);
	}
}
</script>
	<script language="javascript" type="text/javascript">
	function report_data_onchange()  {		
	    document.getElementById("VbisSplitPeriodMonth").disabled = true;
		document.getElementById("VbisSplitPeriodYear").disabled = true;
		
		document.getElementById("VbisSplitQuarterMonth").disabled = true;
		document.getElementById("VbisSplitQuarterYear").disabled = true;
		
		document.getElementById("ClaimFromDate").disabled = true;
		document.getElementById("ClaimToDate").disabled = true;
				
	    switch (document.getElementById("VbisSplitReportData").value)  {
	       case '0': document.getElementById("VbisSplitPeriodMonth").disabled = false;
		             document.getElementById("VbisSplitPeriodYear").disabled = false;   
				     break; 
		  
		   case '1': document.getElementById("VbisSplitQuarterMonth").disabled = false;
		             document.getElementById("VbisSplitQuarterYear").disabled = false;
					 break;
		  
		   case '2': break;
		   
		   case '3': document.getElementById("ClaimFromDate").disabled = false;
		             document.getElementById("ClaimToDate").disabled = false;
					 break;
	    }
	}
	
    $(function()
    {
        var date = new Date();
        var currentMonth = date.getMonth(); // current month
        var currentDate = date.getDate(); // current date
        var currentYear = date.getFullYear(); //this year
            
        $('#ClaimFromDate').datePicker({
            startDate:'01/01/1996',
            endDate: (new Date()).asString()
        });
        $('#ClaimToDate').datePicker({
            startDate:'01/01/1996',
            endDate: (new Date()).asString()
        });
    });
    </script>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
	//design export to excel functionality
	if(isset($report) && count($report)>0){
		$curDate = mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"),1000);
		
		//create CSV file based on the data
		$filename = "claim_report_".$curDate.".csv";
		// create a file pointer connected to the output stream
		$path = dirname(dirname(dirname(__FILE__))).'/webroot/uploads/vbireports/'.$filename;
		$output = fopen($path, 'w') or die('cannot find file');
		$htmlExcel = "<table><tr><td>Client Name</td><td>Net Rate</td></tr></table>";
		fwrite($output, $htmlExcel);
		// output the column headings
		//fputcsv($output, array('Lender','Period','Range Start', 'Range End', 'Rate'));
		
		//for($i=0;$i<count($report);$i++){;         
//			fputcsv($output, $report[$i]);
//		}
		fclose($output);
		echo '<div style="width: 100%;">
 
                    <div style="width: 90%; float: left;">
                        <h2>Extract VBI Split Report</h2>
                    </div>
                    <div style="padding-top: 20px;  float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>

        <br clear="all" />
			<div style="padding:10px; width:95%;">
				<p>The report you have requested has been generated successfully!<br /><br />					
				   <a href="'.Configure::read('Company.url').'app/webroot/uploads/vbireports/'.$filename.'" target="_blank">Click here</a> to download the report. Try another report <a href="javascript: history.go(-1);">here</a>.
				</p>
			</div>


		</div>';
	} else {
		echo '<div style="width: 100%;">

                    <div style="width: 90%; float: left;">
                       <h2> Extract Transaction Report</h2>
                    </div>
                    <div style="padding-top: 20px;  float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>

        <br clear="all" />

			<div style="padding:10px; width:95%;">Unfortunately, no reports could be drawn from the database for the values provide. Please change the filters and <a href="javascript:history.go(-1);">try again.</a>

		</div>';
	}
} else {
?>
    <div style="width: 100%;">  
        <div style="width: 90%; float: left;">
            <h2>Extract VBI Graphical Report</h2>
        </div>
        <div style="padding-top: 20px; float: right;">
           <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
        </div>	
        <br clear="all" />

            <?php 
                echo $this->Form->create('VbisSplit', array('class'=>'editForm'));	
				
				// Report Data Selection
				$report_data = array('Month', 'Quarter', 'Year To Date for ' . date("Y"), 'Date Range');
                echo $form->input('report_data' , array('label' => 'Report Data Selection', 'type'=>'select', 'div' => '','style'=>'width:170px;', 'options' => $report_data, 'onchange' => 'report_data_onchange()'));    
											
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
			        $timestamp = mktime(0,0,0,$i,1,date("Y"));
		   	        $months[$i] = date("M", $timestamp);
		        }						            
				
				echo "<p><p>";
				
			    echo "<div>";
                echo $form->input('period_month' , array('label' => 'Month', 'type'=>'select', 'div' => '','style'=>'width:70px;', 'options' => $months, 'default' => $selMonth));
                echo $this->Form->input('period_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;', 'default'=> $selYear));
                echo "</div>";
		        
				$quarters = array('Q1 Jan-Mar', 'Q2 Apr-Jun', 'Q3 Jul-Sep', 'Q4 Oct-Dec');
			    echo "<div>";
                echo $form->input('quarter_month' , array('label' => 'Quarter', 'type'=>'select', 'div' => '','style'=>'width:120px;', 'options' => $quarters, 'disabled' => 'disabled'));
                echo $this->Form->input('quarter_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;', 'default'=> $selYear, 'disabled' => 'disabled'));
                echo "</div>";
				
			    echo "<div>";
				echo $this->Form->input('range_start', array('label'=> 'Date Range', 'class'=>'dateField','id' => 'ClaimFromDate', 'disabled' => 'disabled','style'=>'width:80px;', 'div' => ''));
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to&nbsp;&nbsp;";
                echo $this->Form->input('range_end', array('label'=> '', 'class'=>'dateField','id' => 'ClaimToDate', 'disabled' => 'disabled','style'=>'width:80px;', 'div' => ''));         
                echo "</div>";
								     			   							
				$url = "button_onclick('reportOutputVbigraph')";  					   				
				echo $this->Html->link('Extract Report', '#', array('onClick'=>$url)); 				                			    
            ?>
</div>
<?php } ?>