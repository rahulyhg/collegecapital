<?php
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	if($sortable){
		echo $javascript->link('jquery-ui-1.8.21.custom.min.js');
		echo $javascript->link('jquery.ui.sortable.js');
	} else {
		echo $javascript->link('jquery.paginate.min.js');
	}
}
?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		<?php if($sortable) { ?>
		$('#faqs').sortable({
			opacity: 0.6,
			cursor: 'move',
			update: function() {
				$.post('<?php echo $this->Html->url(array('controller' => 'faqs','action' => 'order'));?>', $('#faqs').sortable("serialize", {key: 'faqs[]'}))
				.success(function() { $('#order-status').fadeIn() })
			}
		});
		$('#faqs').disableSelection(function() { $('#order-status').fadeOut() });
		<?php } else {?>
		$('#paging_container').pajinate({
			num_page_links_to_display : 4,
			items_per_page : <?php echo $pageLimit;?>	
		});
		<?php } ?>
	});
</script>
<style type="text/css">
	.oNum { cursor:default; }
</style>
<div class="faqs index">
	<h1><?php __('faqs');?></h1>
    <?php if($sortable){?><div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div><?php } ?>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = '-------select group---------';
			foreach ($options as $option){
				$categoryOptions[$option['FaqsCategory']['id']] = $option['FaqsCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_faqs_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_faqs_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString,'default' => $groupValue));
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
            <span class="<?php echo (($sortable)?"tab-hi":"tab");?>"><a href="<?php echo $this->Html->url(array('controller' => 'faqs','?' => array('sort_list' => 'true'))); ?>" title="sort">sort</a></span>			
        </div>
        <div class="menu-tab">
            <span class="<?php echo (($sortable)?"tab":"tab-hi");?>"><?php echo (($sortable)?$this->Html->link(__('display all', true), array('action' => 'index')):"display all"); ?> </span>
        </div>
    </div>
	<div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:40px" id="record_header">
            	<div class="record_detail_header" id="record_detail"><?php echo (!$sortable)?$this->Paginator->sort('Sort', 'position'):"Sort";?></div>
            </div>
            <div style="width:52%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('title');?></div>
            </div>            
            <div style="width:130px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('category_id');?></div>
            </div>
            <div style="width:100px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
            <div style="width:100px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
        <div id="paging_container" class="container">        
            <ul id="faqs" class="content">
        <?php 
		if($faqs){
			foreach ($faqs as $row):
				foreach ($options as $option){
					if($option['FaqsCategory']['id']==$row['Faq']['category_id']){
						$strCategoryName = $option['FaqsCategory']['category'];
					}
				} 		
				echo '<li id="faq_' . $row['Faq']['id'] . '" class="order-list"><div class="row-style">
					<div style="width:40px; cursor: '.(($sortable)?'move':'default').'" id="record_row">
                       <div id="record_detail"><span class="oNum">'.$row['Faq']['position'].'</span></div>
					</div>
					<div style="width:48%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($row['Faq']['title'], true), array('action' => 'edit', $row['Faq']['id'])) . '</div>
					</div>					
					<div style="width:5%; cursor: move;" id="record_row">
						<div id="record_detail">'.(($sortable)?'<img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif">':'').'</div>
					</div>
					<div style="width:115px" id="record_row">
						<div id="record_detail">'.$strCategoryName.'</div>
					</div>
					<div style="width:65px" id="record_row">
						<div id="record_detail">'.(($row['Faq']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish FAQ # %s?', true), $row['Faq']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish FAQ # %s?', true), $row['Faq']['id'])).'</div>').'</div>
					</div>
					<div style="width:50px" id="record_row">'
						.(($row['Faq']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
					'</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $row['Faq']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $row['Faq']['id'])).'</div>
					</div>
				  </div></li>'; 
			endforeach; 
		?>		
            </ul>
            <br clear="all" />
            <div class="info_text"></div><br clear="all" />
            <div class="page_navigation"></div>
        </div>
		<?php
        } else {
            echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
        }
        ?>
    </div>
</div></div>