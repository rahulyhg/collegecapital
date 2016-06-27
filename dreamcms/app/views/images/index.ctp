<?php
echo $html->css('pf.view');
echo $html->css(array('jquery.fancybox-1.3.4'), 'stylesheet', array('media' => 'screen'));
echo $this->Html->script('jquery.fancybox-1.3.4.pack');
echo $this->Html->script('jquery.easing-1.3.pack');
echo $this->Html->script('jquery.mousewheel-3.0.4.pack');
echo $this->Html->script('fancybox.impl');
?>
<div class="images index">
	<h1><?php __('image gallery');?></h1>
    <div style="clear:both;display:block;height:30px">
    	<?php
			$jsString = "javascript:location.href='?cat='+this.value;";
			$categoryOptions[0] = '-------select category---------';
			foreach ($options as $option){
				$categoryOptions[$option['Category']['id']] = $option['Category']['name'];
			}
			if (!isset($_GET['cat'])) {
				echo $this->Form->input('select_image_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString));
			} else {
				$groupValue = $_GET['cat'];
				echo $this->Form->input('select_image_category_id', array('type' => 'select','options' => $categoryOptions,'between' => ': ','onchange'=> $jsString,'default' => $groupValue));
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
            <div style="width:100%" id="record_header">
                <div class="record_detail_header" id="record_detail">Image Gallery</div>
            </div>
        </div>
    </div>
	<?php
	if($images){
		$i = 0;
		foreach ($images as $image):
			foreach ($options as $option){
				if($option['Category']['id']==$image['Image']['categorie_id']){
					$strCategoryName = $option['Category']['name'];
				}
			} 
	?>
            <div class="thumb_img">
                <?php 
					//change the absolute path when rolling out to any other environment
					$url = Configure::read('Company.url');
					(($image['Image']['live'] == 1)?$borderColor='green':$borderColor='red');
					echo $this->Html->link($this->Html->image('thumbnails/' . $image['Image']['location'], array('alt' => $image['Image']['name'], 'border' => 0, 'style' => 'margin:0px;padding:5px;border: 1px solid '.$borderColor.';')), $url.'dreamcms/app/webroot/img/original/' . $image['Image']['location'],array('class' => 'grouped', 'rel' => 'group', 'title' => $image['Image']['description'],'escape' => false));
					echo "<br /><br />";
                    echo (($image['Image']['live'] == 1)?$this->Html->link($html->image("publish1.gif",array('id'=>'unpublish','alt'=>'unpublish')), array('action' => 'unpublish', $image['Image']['id']), array('escape' => false,'id'=>'record','class' => 'thumb_img_action','title'=>'unpublish'), sprintf(__('Are you sure you want to unpublish Image # %s?', true), $image['Image']['id'])):$this->Html->link($html->image("publish0.gif",array('id'=>'publish','alt'=>'publish')), array('action' => 'publish', $image['Image']['id']), array('escape' => false,'id'=>'record','class' => 'thumb_img_action','title'=>'publish'), sprintf(__('Are you sure you want to publish Image # %s?', true), $image['Image']['id'])))."&nbsp;&nbsp;".$this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit', 'border' => 0)), array('action' => 'edit', $image['Image']['id']), array('escape' => false,'id'=>'record','class' => 'thumb_img_action','title'=>'edit'))."&nbsp;&nbsp;".$this->Html->link($html->image("delete.gif",array('id'=>'deletefile','alt'=>'delete file', 'border' => 0)), array('action' => 'delete', $image['Image']['id']),array('escape' => false,'id'=>'record','class' => 'thumb_img_action','title'=>'delete file'), sprintf(__('Are you sure you want to delete this image?', true)));
				?>
            </div>
	<?php 
		endforeach; ?>
            <div id="clear"></div><br />
            <div class="paging">
                <?php
                 echo $this->Paginator->counter(array(
                    'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
                 ));
                ?>
                <div id="clear"></div>	
                <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
                | <?php echo $this->Paginator->numbers();?> |
                <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
            </div>
	<?php 
	} else {
			echo $this->CustomDisplayFunctions->displayNoRecordDetails(true);
	}
	?>
	</div>  
</div>