<?php
$this->set('page','pages');
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
		$('#webpages').sortable({
			opacity: 0.6,
			cursor: 'move',
			update: function() {
				$.post('<?php echo $this->Html->url(array('controller' => 'webpages','action' => 'order'));?>', $('#webpages').sortable("serialize", {key: 'webpages[]'}))
				.success(function() { $('#order-status').fadeIn() })
			}
		});
		$('#webpages').disableSelection(function() { $('#order-status').fadeOut() });
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
<div class="webpages index">
	<?php if($sortable){?><div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div><?php } ?>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = 'Select Group';
			foreach ($options as $option){
				$categoryOptions[$option['PagesCategory']['id']] = $option['PagesCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_pages_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_pages_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
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
            <span class="<?php echo (($sortable)?"tab-hi":"tab");?>"><a href="<?php echo $this->Html->url(array('controller' => 'webpages','?' => array('sort_list' => 'true'))); ?>" title="sort">sort</a></span>			
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
            <div style="width:225px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('title');?></div>
            </div>            
            <div style="width:100px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('category_id');?></div>
            </div>
            <div style="width:150px" id="record_header">
                <div class="record_detail_header" id="record_detail">Parent Page</div>
            </div>            
            <div style="width:80px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
            <div style="width:100px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>
        <div id="paging_container" class="container">        
            <ul id="webpages" class="content">
		<?php
		if($pages){
			$i = 0;
			foreach ($pages as $webpage):
				foreach ($options as $option){
					if($option['PagesCategory']['id']==$webpage['Webpage']['category_id']){
						$strCategoryName = $option['PagesCategory']['category'];
					}
				}
				$strPageName = "";
				foreach($pageNames as $pageName){
					if($pageName['Webpage']['id']==$webpage['Webpage']['parent_page_id']){
						$strPageName = $pageName['Webpage']['title'];	
					}
				}
				//var_dump($pageNames);
				
				$strCategoryNameShort = (strlen($strCategoryName)>23)?substr($strCategoryName,0,20)."...":$strCategoryName;
				echo '<li id="webpage_' . $webpage['Webpage']['id'] . '" class="order-list" title="Last Modified On: '.date('d-M-Y H:i:s',strtotime($webpage['Webpage']['modified'])).'"><div class="webpage-style">
					<div style="width:40px; cursor: '.(($sortable)?'move':'default').'" id="record_row">
                       <div id="record_detail"><span class="oNum">'.$webpage['Webpage']['position'].'</span></div>
					</div>
					<div style="width:195px" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($webpage['Webpage']['title'], true), array('action' => 'edit', $webpage['Webpage']['id'])) . '</div>
					</div>					
					<div style="width:30px; cursor: '.(($sortable)?'move':'default').';" id="record_row">
						<div id="record_detail">'.(($sortable)?'<img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif">':'').'</div>
					</div>
					<div style="width:100px" id="record_row">
						<div id="record_detail" title="'.$strCategoryName.'">'.$strCategoryNameShort.'</div>
					</div>
					<div style="width:140px" id="record_row">
						<div id="record_detail">' .$strPageName.'</div>
					</div>					
					<div style="width:55px" id="record_row">
						'.(($webpage['Webpage']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $webpage['Webpage']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Webpage # %s?', true), $webpage['Webpage']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $webpage['Webpage']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish Webpage # %s?', true), $webpage['Webpage']['id'])).'</div>').'
					</div>
					<div style="width:50px" id="record_row">'
						.(($webpage['Webpage']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $webpage['Webpage']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
					'</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $webpage['Webpage']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $webpage['Webpage']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $webpage['Webpage']['id'])).'</div>
					</div>
				  </div></li>'; 
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