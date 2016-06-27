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
		$('#links').sortable({
			opacity: 0.6,
			cursor: 'move',
			update: function() {
				$.post('<?php echo $this->Html->url(array('controller' => 'links','action' => 'order'));?>', $('#links').sortable("serialize", {key: 'links[]'}))
				.success(function() { $('#order-status').fadeIn() })
			}
		});
		$('#links').disableSelection(function() { $('#order-status').fadeOut() });
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
<div class="links index">
	<?php if($sortable){?><div id="instruction-text" style="display: block;"><?php echo $instructionText; ?></div><?php } ?>
    <div id="order-status" style="display: none;"><?php echo $orderStatus; ?></div>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?group='+this.value;";
			$categoryOptions[0] = 'Select Link Category';
			foreach ($options as $option){
				$categoryOptions[$option['LinksCategory']['id']] = $option['LinksCategory']['category'];
			}
			if (!isset($_GET['group'])) {
				echo $this->Form->input('select_links_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString));
			} else {
				$groupValue = $_GET['group'];
				echo $this->Form->input('select_links_category_id', array('label'=> '','type' => 'select','options' => $categoryOptions,'onchange'=> $jsString,'default' => $groupValue));
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
            <span class="<?php echo (($sortable)?"tab-hi":"tab");?>"><a href="<?php echo $this->Html->url(array('controller' => 'links','?' => array('sort_list' => 'true'))); ?>" title="sort">sort</a></span>			
        </div>
        <div class="menu-tab">
            <span class="tab-hi">display all </span>
        </div>
    </div>
	<div id="clear"></div>
    <div id="records">
        <div id="record_header_wrap">
            <div style="width:40px" id="record_header">
            	<div class="record_detail_header" id="record_detail"><?php echo (!$sortable)?$this->Paginator->sort('Sort', 'position'):"Sort";?></div>
            </div>
            <div style="width:45%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('name');?></div>
            </div>            
            <div style="width:110px" id="record_header">
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
            <ul id="links" class="content">
			<?php
            if($links){
                foreach ($links as $link):
                    foreach ($options as $option){
                        if($option['LinksCategory']['id']==$link['Link']['category_id']){
                            $strCategoryName = $option['LinksCategory']['category'];
                        }
                    } 	
                    
                    echo '<li id="link_' . $link['Link']['id'] . '" class="order-list"><div class="row-style">
                        <div style="width:40px; cursor: '.(($sortable)?'move':'default').'" id="record_row">
                       		<div id="record_detail"><span class="oNum">'.$link['Link']['position'].'</span></div>
						</div>
						<div style="width:41%" id="record_row">
                            <div id="record_detail">' . $this->Html->link(__($link['Link']['name'], true), array('action' => 'edit', $link['Link']['id'])) . '</div>
                        </div>
                        <div style="width:30px; cursor: '.(($sortable)?'move':'default').';" id="record_row">
                            <div id="record_detail">'.(($sortable)?'<img border="0" src="'.Configure::read('Company.url').'dreamcms/app/webroot/img/cursor.gif">':'').'</div>
                        </div>
                        <div style="width:100px" id="record_row">
                            <div id="record_detail">'.$strCategoryName.'</div>
                        </div>
                        <div style="width:65px" id="record_row">
                            '.(($link['Link']['live'] == 1)?'<div id="record_option" class="imgPublish1">'.$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish TEAM MEMBER # %s?', true), $link['Link']['id'])).'</div>':'<div id="record_option" class="imgPublish0">'.$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'publish'), sprintf(__('Are you sure you want to publish TEAM MEMBER # %s?', true), $link['Link']['id'])).'</div>').'
                        </div>
                        <div style="width:50px" id="record_row">'
                            .(($link['Link']['live'] == 0)? '<div id="record_option" class="imgPreview">'.$this->Html->link($html->image("preview.gif",array('id'=>'preview','alt'=>'preview')), array('action' => 'view', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'preview')).'</div>': "").
                        '</div>
                        <div style="width:50px" id="record_row">
                            <div id="record_option" class="imgEdit">'.$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'edit')).'</div>
                        </div>
                        <div style="width:50px" id="record_row">
                            <div id="record_option" class="imgDelete">'.$this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $link['Link']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $link['Link']['id'])).'</div>
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
</div>
</div>