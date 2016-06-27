<script language="javascript" type="text/javascript">
function button_onclick(strAction)  {		
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	strDomainName = "ccap.collegecapital.com.au";	
	
	objBroker = document.getElementById("VbisSplitBrokerId");
	strGroup = "";
	for (i=0; i < objBroker.length; i++) {
       if (objBroker[i].selected)  {           	   
          strGroup = strGroup + objBroker[i].value + ",";
       }
    }    
	
	objLender = document.getElementById("VbisSplitLenderId");
	strLender = "";
	for (i=0; i < objLender.length; i++) {
       if (objLender[i].selected)  {           	   
          strLender = strLender + objLender[i].value + ",";
       }
    }     
	
//	objLenderVBI = document.getElementById("VbisSplitLenderVBIId");
//	strLenderVBI = "";
//	for (i=0; i < objLenderVBI.length; i++) {
//       if (objLenderVBI[i].selected)  {           	   
//          strLenderVBI = strLenderVBI + objLenderVBI[i].value + ",";
//       }
//    }       
	
    strVBI = document.getElementById("VbisSplitVBIResult").value;
	strVBIException = document.getElementById("VbisSplitVBIException").value;
	strVBIStructure = document.getElementById("VbisSplitVBIStructure").value;
	strVBISplit = document.getElementById("VbisSplitVBISplit").value;
	
	strMonth = document.getElementById("VbisSplitPeriodMonth").value;
	strYear = document.getElementById("VbisSplitPeriodYear").value;
	strStatus = ""; //document.getElementById("VbisSplitStatus").value;
		
	location.href="http://" + strDomainName + "/vbis_splits/" + strAction + "/home/page:1/group:" + strGroup + "/lender:" + strLender + "/month:" + strMonth + "/year:" + strYear + "/status:" + strStatus + "/vbi:" + strVBI + "/vbiexception:" + strVBIException + "/vbistructure:" + strVBIStructure + "/vbisplit:" + strVBISplit;
}

function selVBI_onclick()  {
   //strDomainName = "echo00/ccap.collegecapital/index.php";
   //strDomainName = "ccap.collegecapital.com.au";
   strDomainName = "";
	
   document.getElementById("VbisSplitVBIResult").value = document.activeElement.value;	

   if (document.activeElement.value != 1)  {
      parent.window.location.href = strDomainName + "/claims_lenders" ;
   }
}

function selVBIException_onclick()  {
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	//strDomainName = "ccap.collegecapital.com.au";
	strDomainName = "";
	
   document.getElementById("VbisSplitVBIException").value = document.activeElement.value;	
   
   if (document.activeElement.value != 1)  {
      parent.window.location.href = strDomainName + "/claims" ;
   }
}

function selVBIStructure_onclick()  {
	//strDomainName = "echo00/ccap.collegecapital/index.php";
	//strDomainName = "ccap.collegecapital.com.au";
	strDomainName = "";
	
   document.getElementById("VbisSplitVBIStructure").value = document.activeElement.value;	
   
   if (document.activeElement.value != 1)  {
      parent.window.location.href = strDomainName + "/vbis" ;
   }   
}

function selVBISplit_onclick()  {
	//strDomainName = "http://echo00/ccap.collegecapital/index.php";
	//strDomainName = "ccap.collegecapital.com.au";
	strDomainName = "";
	
   document.getElementById("VbisSplitVBISplit").value = document.activeElement.value;	
   
   if (document.activeElement.value != 1)  {
      parent.window.location.href = strDomainName + "/vbis_splits" ;
   }   
}
</script>
<?php

if (isset($vbiNotSet) && ($vbiNotSet))  {
//echo "Here";	
}

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
                    <!--<div style="padding-top: 20px;  float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>-->

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
                    <!--<div style="padding-top: 20px;  float: right;">
                        <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
                    </div>-->

        <br clear="all" />

			<div style="padding:10px; width:95%;">Unfortunately, no reports could be drawn from the database for the values provide. Please change the filters and <a href="javascript:history.go(-1);">try again.</a>

		</div>';
	}
} else {
?>
    <div style="width: 100%;">  
        <div style="width: 90%; float: left;">
            <h2>Extract VBI Split Report</h2>
        </div>
        <!--<div style="padding-top: 20px; float: right;">
           <a href="#" onClick="javascript: self.parent.tb_remove();return false;">Close</a>
        </div>-->	
        <br clear="all" />

            <?php 
			    echo "<style>.editForm label { width: 45%; float: left; }</style>";
                echo $this->Form->create('VbisSplit', array('class'=>'editForm'));
				
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
				
				// Broker Groups List  
				$brokers[0] = '';    
		        foreach ($brokerOptions as $brokerOption){			      
			       $brokers[$brokerOption['Users']['id']] = $brokerOption['Users']['companyName'];
		        }		       
		        				
		        echo "<div>";				
		        echo $this->Form->input('broker_id', array('label'=>'Select Brokers to exclude from report:<br><br><i>(for multiple selections, <br>press Ctrl and left mouse click)</i>', 'type' => 'select', 'multiple' => 'multiple', 'div' => '', 'escape' => false, 'options' => $brokers, 'size' => 5, 'style' => 'width:300px'));
		        echo "</div>";
				
				// Lender Groups List  	
				$lenders[0] = ''; 			
		        foreach ($lenderOptions as $lenderOption){			       
				   if ($lenderOption['ClaimsLender']['id'] == 1)  {
						 $lenders[$lenderOption['ClaimsLender']['id']] = "ANZ / ANZ Edge" ; //$lenderOption['ClaimsLender']['lender'] . " / ANZ Edge";
					  } else if ($lenderOption['ClaimsLender']['id'] == 17)  {
						  // Do Nothing for Lender ANZ Edge as combined with ANZ
					  } else  {
				         $lenders[$lenderOption['ClaimsLender']['id']] = $lenderOption['ClaimsLender']['lender'];
					  }
		        }
		        				
		        echo "<div>";
		        echo $this->Form->input('lender_id', array('label'=>'Select Lenders to exclude from report:', 'type' => 'select', 'multiple' => 'multiple', 'div' => '', 'escape' => false, 'options' => $lenders, 'size' => 5, 'style' => 'width:300px'));
		        echo "</div>";
				
				// VBI Business Rules
				echo "<br>";
				$VBIstatus = array( 1=>'Yes, please extract the report with these VBI rules', 0=>'No, I need to update the VBI rules for this period', ''=>'Not sure, I need to check the VBI rules');
				echo "<div>";
			    echo $this->Form->input('VBI', array('type' => 'radio', 'legend'=>'Are the VBI rules valid for the current period?', 'div' => '', 'escape' => false, 'options' => $VBIstatus, 'size' => 5, 'style' => 'width:200px', 'onclick' => 'selVBI_onclick();'));  
		        echo $this->Form->input('VBIResult', array('type' => 'hidden'));  
				echo "</div>";
  				echo "<br>";

				// VBI Structure
				echo "<br>";
				$VBIstatus = array( 1=>'Yes, please extract the report with these VBI structures', 0=>'No, I need to update the VBI structures for this period', ''=>'Not sure, I need to check the VBI structures');
				echo "<div>";
			    echo $this->Form->input('VBIStructure', array('type' => 'radio', 'legend'=>'Are the VBI structures valid for the current period?', 'div' => '', 'escape' => false, 'options' => $VBIstatus, 'size' => 5, 'style' => 'width:200px;', 'onclick' => 'selVBIStructure_onclick();'));  
		        echo $this->Form->input('VBIStructure', array('type' => 'hidden'));  
				echo "</div>";
  				echo "<br>";
				
				// VBI Split
				echo "<br>";
				$VBIstatus = array( 1=>'Yes, please extract the report with these VBI splits', 0=>'No, I need to update the VBI splits for this period', ''=>'Not sure, I need to check the VBI splits');
				echo "<div>";
			    echo $this->Form->input('VBISplit', array('type' => 'radio', 'legend'=>'Are the VBI splits valid for the current period?', 'div' => '', 'escape' => false, 'options' => $VBIstatus, 'size' => 5, 'style' => 'width:200px', 'onclick' => 'selVBISplit_onclick();'));  
		        echo $this->Form->input('VBISplit', array('type' => 'hidden'));  
				echo "</div>";
  				echo "<br>";				
								
				// VBI Exception Business Rules
				echo "<br>";
				$VBIstatus = array( 0=>'Yes, I need to override some transactions', 1=>'No, I am ready to extract the report');
				echo "<div>";
			    echo $this->Form->input('VBIException', array('type' => 'radio', 'legend'=>'Are there any exceptions to the VBI rules for this period?', 'div' => '', 'escape' => false, 'options' => $VBIstatus, 'size' => 5, 'style' => 'width:200px', 'onclick' => 'selVBIException_onclick();'));  
		        echo $this->Form->input('VBIException', array('type' => 'hidden'));  
				echo "</div>";
  				echo "<br>";				
				
		        // Lender Groups List 
//				$lendersVBI[0] = '';  				
//		        foreach ($lenderOptions as $lenderOption){
//				   $strLender = "";
//					
//				   if ($lenderOption['ClaimsLender']['vbi'] == 1)  {
//			          
//					  if ($lenderOption['ClaimsLender']['term'] != "")  {
//						  $strLender .= "Term > 36 months";
//					  }
//					  
//					  if ($lenderOption['ClaimsLender']['amount'] > 0)  {
//						  if ($strLender != "")  {
//							  $strLender .= ", ";
//						  }
//						  $strLender .= "Amount > $" . number_format($lenderOption['ClaimsLender']['amount'],2);
//					  }
//				   
//				      if ($strLender == "")  {
//						 $strLender = "All";
//					  }
//					  
//				      $strLender = $lenderOption['ClaimsLender']['lender'] . " - " . $strLender;
//				      $lendersVBI[$lenderOption['ClaimsLender']['id']] = $strLender;
//				   }
//				   
//		        }
//				
//				echo "<div>";
//			    echo $this->Form->input('lenderVBI_id', array('label'=>'Select VBI Business rules to exclude from report:', 'type' => 'select', 'div' => '', 'escape' => false, 'options' => $lendersVBI, 'size' => 5, 'style' => 'width:300px'));  
//		        echo "</div>";
		       
//			    // Status 						        	             			   
//				$status = array(''=>'All',  1=>'Actioned', 0=>'Not Actioned');
//				echo "<div>";
//		        echo $this->Form->input('status', array('label'=>'Status', 'type' => 'select', 'div' => '', 'style'=>'width:120px;', 'escape' => false, 'options' => $status));			
//				echo "</div>";
								
				$url = "button_onclick('reportOutput')";  					   				
				echo $this->Html->link('Extract Report', '#', array('onClick'=>$url)); 				                			    
            ?>
</div>
<?php } ?>