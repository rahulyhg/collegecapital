<?php
$this->set('page','network');
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
		$('#teams').sortable({
			opacity: 0.6,
			cursor: 'move',
			update: function() {
				$.post('<?php echo $this->Html->url(array('controller' => 'teams','action' => 'order'));?>', $('#teams').sortable("serialize", {key: 'teams[]'}))
				.success(function() { $('#order-status').fadeIn() })
			}
		});
		$('#teams').disableSelection(function() { $('#order-status').fadeOut() });
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
<div class="teams index">
	<h2><?php __('Network');?></h2>
    <?php if($sortable){?><div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div><?php } ?>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = '-------select group---------';
			foreach ($options as $option){
				$categoryOptions[$option['TeamsCategory']['id']] = $option['TeamsCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_memebers_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_memebers_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString,'default' => $groupValue));
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
            <span class="<?php echo (($sortable)?"tab-hi":"tab");?>"><a href="<?php echo $this->Html->url(array('controller' => 'teams','?' => array('sort_list' => 'true'))); ?>" title="sort">sort</a></span>			
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
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('name');?></div>
            </div>            
            <div style="width:120px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('category_id');?></div>
            </div>
            <div style="width:110px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('live');?></div>
            </div>
            <div style="width:110px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
        </div>        
        <div id="paging_container" class="container">        
            <ul id="teams" class="content">
		<?php
		if($teams){
			foreach ($teams as $team):
				foreach ($options as $option){
					if($option['TeamsCategory']['id']==$team['Team']['category_id']){
						$strCategoryName = $option['TeamsCategory']['category'];
					}
				} 	
				
				echo '<li id="team_' . $team['Team']['id'] . '" class="order-list"><div class="row-style">
					<div style="width:20px" id="record_row">
						<div id="record_detail">' .$team['Team']['id'] .'</div>
					</div>
					<div style="width:50%" id="record_row">
						<div id="record_detail">' . $this->Html->link(__($team['Team']['name'], true), array('action' => 'edit', $team['Team']['id'])) . '</div>
					</div>
					<div style="width:5%; cursor: move;" id="record_row">
						<div id="record_detail">'.(($sortable)?'<img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif">':'').'</div>
					</div>
					<div style="width:115px" id="record_row">
						<div id="record_detail">'.$strCategoryName.'</div>
					</div>
					<div style="width:65px" id="record_row">
						<div id="record_detail">'.(($team['Team']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $team['Team']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish TEAM MEMBER # %s?', true), $team['Team']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $team['Team']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish TEAM MEMBER # %s?', true), $team['Team']['id'])).'</div>').'</div>
					</div>
					<div style="width:50px" id="record_row">'
						.(($team['Team']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $team['Team']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
					'</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $team['Team']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
					</div>
					<div style="width:50px" id="record_row">
						<div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $team['Team']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $team['Team']['id'])).'</div>
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