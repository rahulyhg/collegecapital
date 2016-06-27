<?php
$this->set('page','rates');
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
	$this->set('page','rates');
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
<?php
if($rates){
?>
<!--<div class="rates view">-->
	<?php //if($_SESSION['Auth']['User']['group_id']==1){ ?>
        <div style="clear: both;display: block;height:30px; width: 150px;  padding: 0px 100px 10px 0px;">
            <?php
                $jsString = "javascript:location.href='?group='+this.value;";
                //$bankOptions[0] = '-------select banks---------';
	            $bankOptions[0] = 'Select Bank';
                foreach ($banks as $bank){
                    $bankOptions[$bank['Users']['id']] = $bank['Users']['name'];
                }
                if (!isset($_GET['group'])) {
                    echo $this->Form->input('select_banks', array('label'=> '','type' => 'select','options' => $bankOptions,'onchange'=> $jsString));
                } else {
                    $groupValue = $_GET['group'];
                    echo $this->Form->input('select_banks', array('label'=> '','type' => 'select','options' => $bankOptions,'onchange'=> $jsString,'default' => $groupValue));
                }
            ?>
        </div><hr>
<?php        
			//}
			echo "<div id='paging_container'><div  class='content'>";
            foreach($rates as $rate_items):
        ?>
        <div class="rates view">       
            <table width="100%">
                <tr><td><h4 style="white-space: nowrap;"><a href='<?php echo Configure::read('Company.menuUrl');?>app/webroot/uploads/rates/<?php echo $rate_items['Rate']['documentFile'];?>' target='_blank'><?php echo $rate_items['Rate']['title'];?></a></h4>
                        Date: <?php echo $this->FormatEpochToDate->formatEpochToDate($rate_items['Rate']['documentDate']);?></td>
                    <td align="right"><?php if(strlen($rate_items['UserJoin']['logo'])>0){?>
                	<img src="<?php echo Configure::read('Company.url') . 'app/webroot/uploads/users/'.$rate_items['UserJoin']['logo'];?>" height="60" />
					<?php } ?><td>
                </tr>
                <tr><td colspan="2"><?php  if(strlen($rate_items['Rate']['description'])>0){ echo '<strong>'.$rate_items['Rate']['description'].'</strong>'; } ?><hr style="margin-top: 10px;"></td>
                </tr>
            </table>
            
        </div>
  
<?php
			endforeach;
			echo "	</div><br clear='all' />
                    <div class='info_text'></div>
                    <div class='page_navigation'></div>
                </div>";
		} else {
			echo "<p>There are currently no Interest Rates documents available. Please check back later.</p>";
}
?>