<?php
$this->set('page','documents');
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
<div class="documents index">
	<div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = 'Select Category';
			foreach ($options as $option){
				$categoryOptions[$option['DocumentsCategory']['id']] = $option['DocumentsCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_documents_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_documents_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
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
            <div style="width:35%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('title');?></div>
            </div>
            <div style="width:145px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('category_id');?></div>
            </div>
            <div style="width:105px" id="record_header">
            	<div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('documentDate');?></div>
            </div>
            <div style="width:80px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
            <div style="width:80px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
                
        <div id="paging_container" class="container">        
            <ul id="documents" class="content">
		<?php
		if($documents){
			$i = 0;
			foreach ($documents as $document):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			
				foreach ($options as $option){
					if($option['DocumentsCategory']['id']==$document['Document']['category_id']){
						$strCategoryName = $option['DocumentsCategory']['category'];
					}
				}
		?>
		
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:20px" id="record_row">
                <div id="record_detail"><?php echo $document['Document']['id']; ?>&nbsp;</div>
            </div>
            <div style="width:35%" id="record_row">
                <div id="record_detail"><?php echo $this->Html->link(__($document['Document']['title'], true), array('action' => 'edit', $document['Document']['id'])); ?>&nbsp;</div>
            </div>
            <div style="width:150px" id="record_row">
                <div id="record_detail"><?php echo $strCategoryName; ?>&nbsp;</div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail"><?php echo $this->FormatEpochToDate->formatEpochToDate($document['Document']['documentDate']);?></div>
            </div>
            <div style="width:50px" id="record_row">
                <?php if($document['Document']['live'] == 1){ echo '<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $document['Document']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Document # %s?', true), $document['Document']['id'])).'</div>';}else{ echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $document['Document']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish Document # %s?', true), $document['Document']['id'])).'</div>';} ?>&nbsp;
            </div>
            <div style="width:50px" id="record_row">                	
                <?php if($document['Document']['live'] == 0){?><div id="record_option" class="imgPreview"><?php if($document['Document']['live'] == 0){ echo $this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'preview', $document['Document']['id']), array('escape' => false,'id'=>'record','title'=>'preview'));}?></div><?php } ?>  
            </div>              
            <div style="width:50px" id="record_row">
                    <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $document['Document']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
            </div>
            <div style="width:50px" id="record_row">
                    <div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $document['Document']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $document['Document']['id'])); ?></div>
            </div>
        </div> 
        <?php
			endforeach; 
		?>
        
        </ul>
        <br clear="all" />
        <div class="info_text"></div>
        <div class="page_navigation"></div>
        </div>
    <?php
		} else {
			echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
		}
	?>
    </div>
</div></div>