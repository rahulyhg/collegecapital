<script language="javascript" type="text/javascript">
function button_onclick(strAction)  {		
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";
	
	strGroup = document.getElementById("VbisSplitBrokerId").value;
	strMonth = document.getElementById("VbisSplitPeriodMonth").value;
	strYear = document.getElementById("VbisSplitPeriodYear").value;
	strSort = document.getElementById("VbisSplitSort").value;
	
	location.href="http://" + strDomainName + "/vbis_splits/" + strAction + "/home/page:1/group:" + strGroup + "/month:" + strMonth + "/year:" + strYear + "/sort:" + strSort;
}
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
            <h2>Extract VBI Broker Break Up Report</h2>
        </div>
        <div style="padding-top: 20px; float: right;">
           <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
        </div>	
        <br clear="all" />

            <?php 
                echo $this->Form->create('VbisSplit', array('class'=>'editForm'));
				// Broker Groups List  				 
		        foreach ($brokerOptions as $brokerOption){
			       //$brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['name'].(strlen($brokerOption['Users']['surname'])>0?" ".$brokerOption['Users']['surname']:"").(strlen($brokerOption['Users']['companyName'])>0?" - ".$brokerOption['Users']['companyName']:"");
			      $brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['companyName'];
		        }
		        if (isset($this->params['named']['group']))  {
		           $selBroker = $this->params['named']['group'];
		        } else  {
		           $selBroker = '';
		        }
		        				
		        echo "<div>";
		        echo $this->Form->input('broker_id', array('label'=>'Broker', 'type' => 'select', 'div' => '', 'escape' => false, 'options' => $brokers, 'default' => $selBroker));
		        echo "</div>";
				
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
		
			    echo "<div>";
                echo $form->input('period_month' , array('label' => 'Period', 'type'=>'select', 'div' => '','style'=>'width:70px;', 'options' => $months, 'default' => $selMonth));
                echo $this->Form->input('period_year', array('label' => false, 'type'=>'text', 'div' => '','style'=>'width:40px;', 'default'=> $selYear));
                echo "</div>";		             			   				
				
				$status = array(0=>'All', 1=>'Open', 2=>'Locked');
				echo "<div>";
		        echo $this->Form->input('status', array('label'=>'Status', 'type' => 'select', 'div' => '', 'style'=>'width:100px;', 'escape' => false, 'options' => $status));			
				echo "</div>";
								
				$sort = array('lender'=>'Lender', 'broker'=>'Broker', 'company'=>'Company');
				echo "<div>";
		        echo $this->Form->input('sort', array('label'=>'Sort', 'type' => 'select', 'div' => '', 'style'=>'width:100px;', 'escape' => false, 'options' => $sort));			
				echo "</div>";
								
				$url = "button_onclick('reportOutputBreakup')";  					   				
				echo $this->Html->link('Extract Report', '#', array('onClick'=>$url)); 				                			    
            ?>
</div>
<?php } ?>