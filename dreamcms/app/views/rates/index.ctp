<?php
$this->set('page','rates');
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
}
?>
<script language="javascript" type="text/javascript">
	$(rate).ready(function(){
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : <?php echo $pageLimit;?>	
		});
	});
</script>
<div class="rates index">
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
            <div style="width:40%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('title');?></div>
            </div>
            <div style="width:100px" id="record_header">
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
            <ul id="rates" class="content">
		<?php
		if($rates){
			$i = 0;
			foreach ($rates as $rate):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			
				foreach ($options as $option){
					if($option['RatesCategory']['id']==$rate['Rate']['category_id']){
						$strCategoryName = $option['RatesCategory']['category'];
					}
				}
		?>
		
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:20px" id="record_row">
                <div id="record_detail"><?php echo $rate['Rate']['id']; ?>&nbsp;</div>
            </div>
            <div style="width:40%" id="record_row">
                <div id="record_detail"><?php echo $this->Html->link(__($rate['Rate']['title'], true), array('action' => 'edit', $rate['Rate']['id'])); ?>&nbsp;</div>
            </div>
            <div style="width:100px" id="record_row">
                <div id="record_detail"><?php echo $strCategoryName; ?>&nbsp;</div>
            </div>
            <div style="width:90px" id="record_row">
            	<div id="record_detail"><?php echo $this->FormatEpochToDate->formatEpochToDate($rate['Rate']['documentDate']);?></div>
            </div>
            <div style="width:50px" id="record_row">
                <?php if($rate['Rate']['live'] == 1){ echo '<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $rate['Rate']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Rate # %s?', true), $rate['Rate']['id'])).'</div>';}else{ echo '<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $rate['Rate']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish Rate # %s?', true), $rate['Rate']['id'])).'</div>';} ?>&nbsp;
            </div>
            <div style="width:50px" id="record_row">                	
                <?php if($rate['Rate']['live'] == 0){?><div id="record_option" class="imgPreview"><?php if($rate['Rate']['live'] == 0){ echo $this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'preview', $rate['Rate']['id']), array('escape' => false,'id'=>'record','title'=>'preview'));}?></div><?php } ?>  
            </div>              
            <div style="width:50px" id="record_row">
                    <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $rate['Rate']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
            </div>
            <div style="width:50px" id="record_row">
                    <div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $rate['Rate']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $rate['Rate']['id'])); ?></div>
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