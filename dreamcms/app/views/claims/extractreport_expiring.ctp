<script language="javascript" type="text/javascript">
function button_onclick(strAction)  {		
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";
	
	// Borker & Lender selections		
	strGroup = document.getElementById("TransactionExpiringBrokerId").value;		
	strLender = document.getElementById("TransactionExpiringLenderId").value;

	// Dates selection
	strToday = new Date();
	strToday = strToday.getFullYear() + "-" + (strToday.getMonth()+1) + "-" + strToday.getDate();

	strToday30 = new Date();
	strToday30.setDate(strToday30.getDate() + 30);
	strToday30 = strToday30.getFullYear() + "-" + (strToday30.getMonth()+1) + "-" + strToday30.getDate();

	strToday90 = new Date();
	strToday90.setDate(strToday90.getDate() + 90);
	strToday90 = strToday90.getFullYear() + "-" + (strToday90.getMonth()+1) + "-" + strToday90.getDate();
	
	strClaimFromDate = new Date(document.getElementById("ClaimFromDate").value);
	strClaimFromDate = strClaimFromDate.getFullYear() + "-" + (strClaimFromDate.getMonth()+1) + "-" + strClaimFromDate.getDate();
	
	strClaimToDate = new Date(document.getElementById("ClaimToDate").value);
	strClaimToDate = strClaimToDate.getFullYear() + "-" + (strClaimToDate.getMonth()+1) + "-" + strClaimToDate.getDate();
	
	switch (document.getElementById("TransactionExpiringReportData").value)  {		  		   
	   case '0': strDates = "/startDate:" + strToday + "/endDate:" + strToday30;
				 break; 
	  
	   case '1': strDates = "/startDate:" + strToday + "/endDate:" + strToday90;
				 break;
	  
	   case '2': strDates = "/startDate:" +  strClaimFromDate + "/endDate:" +  strClaimToDate;
				 break;	   	   
}

	// Page Reload
	location.href="http://" + strDomainName + "/claims/" + strAction + "/home/page:1/group:" + strGroup + "/lender:" + strLender + strDates;
}

	function report_data_onchange()  {		
	    document.getElementById("ClaimFromDate").disabled = true;
		document.getElementById("ClaimToDate").disabled = true;				
				
	    if (document.getElementById("TransactionExpiringReportData").value == "2")  {
	       document.getElementById("ClaimFromDate").disabled = false;
		   document.getElementById("ClaimToDate").disabled = false;   			
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
            <h2>Extract Broker Expiring Report</h2>
        </div>
        <div style="padding-top: 20px; float: right;">
           <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
        </div>	
        <br clear="all" />

            <?php 
                echo $this->Form->create('TransactionExpiring', array('class'=>'editForm'));
				
				// Broker Groups List  							 
		        if ($_SESSION['Auth']['User']['group_id']==1){ //for super users		
  				   $brokers[0] = 'All Shareholders';
				   foreach ($brokerOptions as $brokerOption){			      
			         $brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['companyName'];
		           }
		           if (isset($this->params['named']['group']))  {
		              $selBroker = $this->params['named']['group'];
		           } else  {
		              $selBroker = '';
		           }
		        						      
		           echo $this->Form->input('broker_id', array('label'=>'Shareholder', 'type' => 'select', 'escape' => false, 'options' => $brokers, 'default' => $selBroker));
				}  elseif ($_SESSION['Auth']['User']['group_id']== 3) { // For Broker users					
				   echo $this->Form->input('broker_id', array('type' => 'hidden', 'value' => $_SESSION['Auth']['User']['parent_user_id']));
				}  elseif ($_SESSION['Auth']['User']['group_id']== 2) { // For Principal users					
				   echo $this->Form->input('broker_id', array('type' => 'hidden', 'value' => $_SESSION['Auth']['User']['id']));
				}
									
  				$lenders[0] = 'All Lenders';
			    foreach ($lenderOptions as $lenderOption){
				   if ($lenderOption['ClaimsLender']['id'] == 1)  {
						 $lenders[$lenderOption['ClaimsLender']['id']] = "ANZ / ANZ Edge"; //$lenderOption['ClaimsLender']['lender'] . " / ANZ Edge";
					  } else if ($lenderOption['ClaimsLender']['id'] == 17)  {
						  // Do Nothing for Lender ANZ Edge as combined with ANZ
					  } else  {
				         $lenders[$lenderOption['ClaimsLender']['id']] = $lenderOption['ClaimsLender']['lender'];
					  }
			    }
			    echo $this->Form->input('lender_id', array('label'=> 'Lender','type' => 'select','options' => $lenders));								
				
				$report_data = array('Next 30 days', 'Next 3 months', 'Date Range');
                echo $form->input('report_data' , array('label' => 'Data Selection', 'type'=>'select', 'options' => $report_data, 'onchange' => 'report_data_onchange()')); 
				
				echo "<div class='input select'>";
				echo $this->Form->input('range_start', array('label'=> 'Date Range', 'class'=>'dateField','id' => 'ClaimFromDate', 'disabled' => 'disabled','style'=>'width:80px;', 'div' => ''));
				echo "&nbsp;&nbsp;to&nbsp;&nbsp;";
                echo $this->Form->input('range_end', array('label'=> '', 'class'=>'dateField','id' => 'ClaimToDate', 'disabled' => 'disabled','style'=>'width:80px;', 'div' => ''));         
                echo "</div>";
								
				$url = "button_onclick('reportOutputExpiring')";  					   				
				echo $this->Html->link('Extract Report', '#', array('onClick'=>$url)); 				                			    
            ?>
</div>
<?php } ?>