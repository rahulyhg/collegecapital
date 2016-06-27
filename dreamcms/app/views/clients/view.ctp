<?php
	if(isset($clientList) && !$clientList){ //display individual clients
?>
    <div class="clients view " style="line-height: 200%;">
        <h2><?php echo $client['Client']['name']." ".$client['Client']['surname']; ?></h2>         
        <div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;">
        	<?php if(strlen($client['Client']['logo'])>0) { ?><img src="<?php echo '/app/webroot/uploads/clients/'.$client['Client']['logo'];?>" width="150" /> <?php } 
			?>
        </div>     
        
        <?php if(strlen($client['Client']['position'])>0){ echo "<strong>Position:</strong> ".$client['Client']['position']."<br />";}?>
		<?php if(strlen($client['Client']['companyName'])>0){ echo "<strong>Company Name:</strong> ".$client['Client']['companyName']."<br />";}?>
        <?php if(strlen($client['Client']['email'])>0){?><strong>Email:</strong> <a href="mailto:<?php echo $client['Client']['email'];?>"><?php echo $client['Client']['email']."<br />"; ?></a><?php } ?>
        <?php if($client['Client']['mobile']>0){ echo "<strong>Mobile:</strong> ".$client['Client']['mobile']."<br />"; } ?>
        <?php if($client['Client']['phone']>0){ echo "<strong>Phone:</strong> ".$client['Client']['phone']."<br />"; } ?>
        <?php if($client['Client']['fax']>0){ echo "<strong>Fax:</strong> ".$client['Client']['fax']."<br />"; } ?>
        <?php if(strlen($client['Client']['streetAddress'])>0){ echo "<strong>Street Address:</strong> ".$client['Client']['streetAddress'].(strlen($streetState['Tblstate']['State'])>0?", ".$streetState['Tblstate']['State']:"")."<br />";} ?>
        <?php if(strlen($client['Client']['postalAddress'])>0){ echo "<strong>Postal Address:</strong> ".$client['Client']['postalAddress'].(strlen($postalState['Tblstate']['State'])>0?", ".$postalState['Tblstate']['State']:"")."<br />";} ?>
    
        <?php if(strlen($client['Client']['googleMap'])>0){?><strong>Map:</strong> <a href="<?php echo $client['Client']['googleMap'];?>" target="_blank"><?php echo $client['Client']['googleMap']."<br />"; ?></a><?php } ?>
        <?php if(strlen($client['Client']['website'])>0){?><strong>Website:</strong> <a href="<?php echo (substr($client['Client']['website'],4)=='http'?$client['Client']['website']:"//".$client['Client']['website']);?>" target="_blank"><?php echo $client['Client']['website']."<br />"; ?></a><?php } ?>
        
        <?php if(strlen($client['Client']['linkedIn'])>0){?><a href="<?php echo $client['Client']['linkedIn'];?>" target="_blank"><?php echo "<strong>LinkedIn:</strong> ".$client['Client']['linkedIn']; ?></a><?php } ?>     
    </div>
<?php
	} else {
		if($client){
			echo $this->Html->css('paginateStyles.css');
			if (isset($javascript)) {
				echo $javascript->link('jquery.paginate.min.js');
				$this->set('page','contacts');
			}
?>
			<script language="javascript" type="text/javascript">
                $(document).ready(function(){
                    $('#paging_container').pajinate({
                        num_page_links_to_display : 4,
                        items_per_page : <?php echo $pageLimit;?>	
                    });
                });
            </script>
            <?php if ($options){ ?>
            <div style="clear: both;display: block;height:30px; width: 500px;  padding: 0px 100px 10px 0px;">
				<?php
                    $jsString = "javascript:location.href='?group='+this.value;";
                    $categoryOptions[0] = 'Select Category';
                    foreach ($options as $option){
                        $categoryOptions[$option['ClientsCategory']['id']] = $option['ClientsCategory']['category'];
                    }
					echo "<div style='float:left; padding-right:10px'>";
                    if (!isset($_GET['group'])) {
                        echo $this->Form->input('select_category', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
                    } else {
                        $groupValue = $_GET['group'];
                        echo $this->Form->input('select_category', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
                    }
					echo "</div>";
										
					
					$jsString = "javascript:location.href='?order='+this.value";											
					if (isset($_REQUEST["group"]))  {
						$jsString .= "+'&group=" . $_REQUEST["group"] . "'";
					} 
					$jsString .= ";";
					
					if (isset($_REQUEST["order"]))  {
						$orderByValue = $_REQUEST["order"];
					} else  {
					   $orderByValue = "name";	
					}
					
		            echo "<b>Order By </b>";
		            $actions = array('name'=>' Name ', 'companyName'=>' Company Name');
		            echo $this->Form->input('select_actions', array('type' => 'radio', 'options' => $actions,'div' => '','onchange'=> $jsString,'default' => $orderByValue), array('label'=> 'Action:'));		           	 
		   
					echo "<div style='float:left; padding-right:10px'>";
					if($_SESSION['Auth']['User']['id']==1) echo $this->CustomDisplayFunctions->displaySearchBoxView(true);
					echo "</div>";
                ?>
            </div>
             <hr>
<?php        
			}
			echo "<div id='paging_container'><div  class='content'>";
			foreach($client as $client_items):		
?>
				<div class="clients view users-single">
                 <?php if(strlen($client_items['Client']['logo'])>0) { ?>
                            <div style="float: right; width: 70px; height: auto; margin: 10px; padding: 0px;"><img src="<?php echo '/app/webroot/uploads/clients/'.$client_items['Client']['logo'];?>" width="70" /></div>
                        <?php } ?>
                    <h4><a href="/clients/view/<?php echo $client_items['Client']['id'];?>"><?php echo $client_items['Client']['name']." ".$client_items['Client']['surname']; ?></a></h4>
                    
					<?php if(strlen($client_items['Client']['position'])>0){ echo "<strong>Position:</strong> ".$client_items['Client']['position']."<br />";}?>
					<?php if(strlen($client_items['Client']['companyName'])>0){ echo "<strong>Company Name:</strong> ".$client_items['Client']['companyName']."<br />";}?>
                    <?php if(strlen($client_items['Client']['phone'])>0 && (int)$client_items['Client']['phone']>0){ echo "<strong>Phone:</strong> ".$client_items['Client']['phone']."<br />";}?>
                    <?php if(strlen($client_items['Client']['mobile'])>0 && (int)$client_items['Client']['mobile']>0){ echo "<strong>Mobile:</strong> ".$client_items['Client']['mobile']."<br />";}?>
        			<?php if(strlen($client_items['Client']['email'])>0){?><strong>Email:</strong> <a href="mailto:<?php echo $client_items['Client']['email'];?>"><?php echo $client_items['Client']['email']; ?></a><?php } ?> <br clear='all' />                   
                </div>
<?php
			endforeach;
			echo "	</div><br clear='all' />
                    <div class='info_text'></div>
                    <div class='page_navigation'></div>
                </div>";
		} else {
			echo "<p>There are currently no contacts listed. Please check back later.</p>";
		}
	}
?>
