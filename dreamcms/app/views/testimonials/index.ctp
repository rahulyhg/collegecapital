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
		$('#testimonials').sortable({
			opacity: 0.6,
			cursor: 'move',
			update: function() {
				$.post('<?php echo $this->Html->url(array('controller' => 'testimonials','action' => 'order'));?>', $('#testimonials').sortable("serialize", {key: 'testimonials[]'}))
				.success(function() { $('#order-status').fadeIn() })
			}
		});
		$('#testimonials').disableSelection(function() { $('#order-status').fadeOut() });
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
<div class="testimonials index">
	<h1><?php __('testimonials');?></h1>
    <?php if($sortable){?><div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div><?php } ?>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <?php echo $this->CustomDisplayFunctions->displayQuickSearch(true,NULL); ?>
    <div id="wrap-tabs">
		<?php echo $this->CustomDisplayFunctions->displaySearchBox(true); ?>
        <div class="menu-tab">
            <span class="tab"><?php echo $this->Html->link(__('add new', true), array('action' => 'add')); ?></span>			
        </div>
        <div class="menu-tab">
            <span class="<?php echo (($sortable)?"tab-hi":"tab");?>"><a href="<?php echo $this->Html->url(array('controller' => 'testimonials','?' => array('sort_list' => 'true'))); ?>" title="sort">sort</a></span>			
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
            <div style="width:37%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('description');?>...</div>
            </div>
            <div style="width:250px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('person_company');?></div>
            </div>
            <div style="width:110px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
            <div style="width:90px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
        <div id="paging_container" class="container">        
            <ul id="testimonials" class="content">
		<?php
		if($testimonials){
			$i = 0;
			foreach ($testimonials as $testimonial):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
       			echo '<li id="testimonial_' . $testimonial['Testimonial']['id'] . '" class="order-list"><div class="row-style">
					<div style="width:40px; cursor: '.(($sortable)?'move':'default').'" id="record_row">
                       <div id="record_detail"><span class="oNum">'.$testimonial['Testimonial']['position'].'</span></div>
					</div>
					<div style="width:32%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__(substr($testimonial['Testimonial']['description'],0,45), true), array('action' => 'edit', $testimonial['Testimonial']['id'])) . '...</div>
					</div>
					<div style="width:5%; cursor: '.(($sortable)?'move':'default').';" id="record_row">
						<div id="record_detail">'.(($sortable)?'<img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif">':'').'</div>
					</div>
					<div style="width:240px" id="record_row">
						<div id="record_detail">'.$testimonial['Testimonial']['person_company'].'</div>
					</div>
					<div style="width:60px" id="record_row">
						<div id="record_detail">'.(($testimonial['Testimonial']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $testimonial['Testimonial']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish TESTIMONIAL # %s?', true), $testimonial['Testimonial']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $testimonial['Testimonial']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish TESTIMONIAL # %s?', true), $testimonial['Testimonial']['id'])).'</div>').'</div>
					</div>
					<div style="width:50px" id="record_row">'
						.(($testimonial['Testimonial']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $testimonial['Testimonial']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
					'</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $testimonial['Testimonial']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $testimonial['Testimonial']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $testimonial['Testimonial']['id'])).'</div>
					</div>
				  </div></li>';
		endforeach; ?>
				
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