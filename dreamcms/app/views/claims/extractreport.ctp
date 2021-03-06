<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
	//design export to excel functionality
	if(isset($report) && count($report)>0){
		$curDate = mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"),1000);
		//print_r($report);
		//create CSV file based on the data
		$filename = "claim_report_".$curDate.".csv";
		// create a file pointer connected to the output stream
		$path = dirname(dirname(dirname(__FILE__))).'/webroot/uploads/claimreports/'.$filename;
		//echo $path;
		$output = fopen($path, 'w') or die('cannot find file');
		
		// output the column headings
//		fputcsv($output, array('Id','Client Name','Net Rate','Amount Financed', 'Brokerage Amount', 'Document Fee Amount','Terms','Created Date','Settlement Date','Actioned','Broker Name', 'Broker Surname','Company Name', 'Industry Profile','Lender','Goods Description','Product Type', 'Shareholder'));
		fputcsv($output, array('Client Name','Net Rate','Amount Financed', 'Brokerage Amount', 'Document Fee Amount','Terms','Created Date', 'Invoice Number', 'Notes','Settlement Date','Actioned', 'New/Used','Broker Name','Company Name', 'Industry Profile','Lender','Goods Description','Product Type', 'Shareholder'));
		
//		var_dump($report);
		
		for($i=0;$i<count($report);$i++){
			unset($report[$i]["id"]);
			if(strlen($report[$i]["created"]>10)) $report[$i]["created"] = substr($report[$i]["created"],0,10); 
			if(strlen($report[$i]["ClaimSettlementDate"]>10)) $report[$i]["ClaimSettlementDate"] = substr($report[$i]["ClaimSettlementDate"],0,10); 
			$report[$i]["name"] .= " ".$report[$i]["surname"];
			unset($report[$i]["surname"]);
			fputcsv($output, $report[$i]);
		}
		fclose($output);
		echo '<div style="width: 100%;">
 
                    <div style="width: 90%; float: left;">
                        <h2>Extract Transaction Report</h2>
                    </div>
                    <div style="padding-top: 20px;  float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>

        <br clear="all" />
			<div style="padding:10px; width:95%;">
				<p>The report you have requested has been generated successfully!<br /><br />
					<!-- Total Transaction Amount: <strong>$'.number_format($reportTotalAmount,2).'</strong><br /><br />-->
					<a href="'.Configure::read('Company.url').'app/webroot/uploads/claimreports/'.$filename.'" target="_blank">Click here</a> to download the report. Try another report <a href="javascript: history.go(-1);">here</a>.
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
	<script language="javascript" type="text/javascript">
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
    <div style="width: 100%;">
  
                    <div style="width: 90%; float: left;">
                        <h2>Extract Transaction Report</h2>
                    </div>
                    <div style="padding-top: 20px; float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>
	
        <br clear="all" />

            <?php 
                echo $this->Form->create('Claim', array('class'=>'editForm'));
                echo $this->Form->input('FromDate', array('class'=>'dateField','id' => 'ClaimFromDate', 'readonly' => 'true','style'=>'width:100px;'));
                echo $this->Form->input('ToDate', array('class'=>'dateField','id' => 'ClaimToDate', 'readonly' => 'true','style'=>'width:100px;'));
				
				$DDSOptions[0] = "Pending";$DDSOptions[1] = "Actioned";$DDSOptions[2]="ALL";                           			
				echo $this->Form->input('ClaimStatusID', array('label'=>'Claim Status','class'=>'text', 'type' => 'select', 'options' => $DDSOptions));
				
				//******************************************************
                // CHANGE REQUEST: Nyree 29/11/13
				$SortOptions = array('' => 'None', 'shareholder' => 'Shareholder', 'lender' => 'Lender');
				echo $this->Form->input('Sort', array('label'=>'Sort','class'=>'text', 'type' => 'select', 'options' => $SortOptions));
				//******************************************************
				
				//******************************************************
                // CHANGE REQUEST: Nyree 19/12/13
				if ($_SESSION['Auth']['User']['group_id']==1){ //for super users		
  				   $brokers[0] = 'All Shareholders';
			       foreach ($brokerOptions as $brokerOption){
				      $brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['companyName'];
			       }
			       echo $this->Form->input('select_broker', array('label'=> 'Shareholder','type' => 'select','options' => $brokers));				
				}
				//******************************************************
				
				//******************************************************
                // CHANGE REQUEST: Nyree 13/02/14
				if ($_SESSION['Auth']['User']['group_id']==1){ //for super users		
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
			       echo $this->Form->input('select_lender', array('label'=> 'Lender','type' => 'select','options' => $lenders));				
				}
				//******************************************************
				
			    echo $this->Form->button('Extract Report', array('type'=>'submit', 'style'=>'margin: 10px 110px; width: auto; padding: 0;'));
            ?>

</div>
<?php } ?>