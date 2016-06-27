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
<div class="clients index">
	<div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = 'Select Contacts Category';
			foreach ($options as $option){
				$categoryOptions[$option['ClientsCategory']['id']] = $option['ClientsCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
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
            <div style="width:30%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('name');?></div>
            </div>
            <div style="width:20%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('Company Name','companyName');?></div>
            </div>
            <div style="width:20%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('category_id');?></div>
            </div>
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('status_id');?></div>
            </div>
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
		</div>
			<?php
            if($clients){ ?>            
        	<div id="paging_container" class="container">        
            <ul id="clients" class="content">
            <?php
                $i = 0;
                foreach ($clients as $client):
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    
                    foreach ($options as $option){
                        if($option['ClientsCategory']['id']==$client['Client']['category_id']){
                            $strCategoryName = $option['ClientsCategory']['category'];
                        }
                    }
            ?>
                <div id="record_wrap" <?php echo $class;?>>
                    <div style="width:20px" id="record_row">
                        <div id="record_detail"><?php echo $client['Client']['id']; ?>&nbsp;</div>
                    </div>
                    <div style="width:30%" id="record_row">
                        <div id="record_detail" title="<?php echo $client['Client']['name'];?>"><?php echo (strlen($client['Client']['name'])>10?substr($client['Client']['name'],0,10)."...":$client['Client']['name']); ?>&nbsp;</div>
                    </div>
                    <div style="width:20%" id="record_row">
                        <div id="record_detail" title="<?php echo $client['Client']['companyName'];?>"><?php echo (strlen($client['Client']['companyName'])>20?substr($client['Client']['companyName'],0,20)."..":$client['Client']['companyName']); ?>&nbsp;</div>
                    </div>
                    <div style="width:21%" id="record_row">
                        <div id="record_detail"><?php echo $strCategoryName; ?>&nbsp;</div>
                    </div>
                    <div style="width:2%" id="record_row">
                        <div id="record_detail"><?php if($client['Client']['status_id'] == 1){ echo "Active";} else { echo "Inactive";} ?>&nbsp;</div>
                    </div>
                    <div style="width:40px" id="record_row">
                    	<div id="record_option" class=""><?php echo $this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'preview', $client['Client']['id']), array('escape' => false,'id'=>'record','title'=>'preview', 'class'=>'imgPreview'));?></div>
                    </div>
                    <div style="width:40px" id="record_row">
                        <?php	if($client['Client']['status_id'] == 1){ 
									echo '<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $client['Client']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Contact # %s?', true), $client['Client']['id'])).'</div>';
								} else {
									echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $client['Client']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish Contact # %s?', true), $client['Client']['id'])).'</div>';
								} ?>
                    </div>
                    <div style="width:40px" id="record_row">
                        <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $client['Client']['id']), array('escape' => false,'id'=>'record','title'=>'edit', 'class'=>'imgEdit')); ?></div>
                    </div>
                    <div style="width:40px" id="record_row">
                    	<div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $client['Client']['id']), array('escape' => false,'id'=>'record','title'=>'delete', 'class'=>'imgDelete'), sprintf(__('Are you sure you want to delete # %s?', true), $client['Client']['id'])); ?></div>
                    </div>
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