<?php
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
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
<div class="users index">
	<!--<h1><?php __('users');?></h1>-->
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = 'Select Network Group';
			foreach ($options as $option){
				$categoryOptions[$option['Groups']['id']] = $option['Groups']['group'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_group_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_group_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
			}
		?>
    </div>    
    <?php echo $this->CustomDisplayFunctions->displayQuickSearch(true,NULL); ?>
    <div id="wrap-tabs">
		<?php echo $this->CustomDisplayFunctions->displaySearchBox(true); ?>
        <div class="menu-tab">
            <span class="tab"><?php echo $this->Html->link(__('add new', true), array('action' => 'add')); ?></span>			
        </div>
        <div class="menu-tab">
            <span class="tab-hi">display all </span>
        </div>
    </div>
	<div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:20px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>
            <div style="width:13%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('name');?></div>
            </div>
            <div style="width:22%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('username');?></div>
            </div>
            <div style="width:22%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('companyName');?></div>
            </div>
            <div style="width:12%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('group_id');?></div>
            </div>
            <div style="width:7%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('status_id');?></div>
            </div>
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
		</div>
			<?php
            if($users){ ?>            
        <div id="paging_container" class="container">        
            <ul id="users" class="content">
            <?php
                $i = 0;
                foreach ($users as $user):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    
                    foreach ($options as $option){
                        if($option['Groups']['id']==$user['User']['group_id']){
                            $strCategoryName = $option['Groups']['group'];
                        }
                    }
            ?>
                <div id="record_wrap" <?php echo $class;?>>
                    <div style="width:20px" id="record_row">
                        <div id="record_detail"><?php echo $user['User']['id']; ?>&nbsp;</div>
                    </div>
                    <div style="width:13%" id="record_row">
                        <div id="record_detail" title="<?php echo $user['User']['name'];?>"><?php echo (strlen($user['User']['name'])>10?substr($user['User']['name'],0,10)."...":$user['User']['name']); ?>&nbsp;</div>
                    </div>
                    <div style="width:22%" id="record_row">
                        <div id="record_detail" title="<?php echo $user['User']['username'];?>"><?php echo (strlen($user['User']['username'])>20 ? substr($user['User']['username'],0,20)."..":$user['User']['username']); ?>&nbsp;</div>
                    </div>
                    <div style="width:22%" id="record_row">
                        <div id="record_detail" title="<?php echo $user['User']['companyName'];?>"><?php echo (strlen($user['User']['companyName'])>20?substr($user['User']['companyName'],0,20)."..":$user['User']['companyName']); ?>&nbsp;</div>
                    </div>
                    <div style="width:13%" id="record_row">
                        <div id="record_detail"><?php echo $strCategoryName; ?>&nbsp;</div>
                    </div>
                    <div style="width:5%" id="record_row">
                        <div id="record_detail"><?php if($user['User']['status_id'] == 1){ echo "Active";} else { echo "Inactive";} ?>&nbsp;</div>
                    </div>
                    <div style="width:40px" id="record_row">
                        <?php	if($user['User']['status_id'] == 1){ 
									echo '<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $user['User']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Network # %s?', true), $user['User']['id'])).'</div>';
								} else {
									echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $user['User']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish Network # %s?', true), $user['User']['id'])).'</div>';
								} ?>
                    </div>
                    <div style="width:50px" id="record_row">
                        <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $user['User']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
                    </div>
                    <!--<div style="width:50px" id="record_row">
                        <?php //if ($user['User']['group_id']!=1){?><div id="record_option" class="imgDelete"><?php //echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $user['User']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?></div><?php //} ?>
                    </div>-->
                </div>
        	<?php endforeach;?> 
            
                </ul>
                <br clear="all" />
                <div class="info_text"></div><br clear="all" />
                <div class="page_navigation"></div>
            </div>
	<?php	} else {
                echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
            }
        	?>
	</div>  
</div>