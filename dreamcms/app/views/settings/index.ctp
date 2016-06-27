<div class="settings index">
	<h1><?php __('Settings');?></h1>
	<div id="records">
        <div id="record_header_wrap">
            <div style="width:20px" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('id');?></div>
            </div>
            <div style="width:40%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('key');?></div>
            </div>
            <div style="width:43%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('value');?></div>
            </div>
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
         </div>
	<?php
	if($settings) {
		$i = 0;
		foreach ($settings as $setting):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
		<div id="record_wrap" <?php echo $class;?>>
            <div style="width:20px" id="record_row">
                <div id="record_detail"><?php echo $setting['Setting']['id']; ?>&nbsp;&nbsp;&nbsp;</div>
            </div>
            <div style="width:40%" id="record_row">
                <div id="record_detail"><?php echo $setting['Setting']['key']; ?>&nbsp;&nbsp;&nbsp;</div>
            </div>
            <div style="width:40%" id="record_row">
                <div id="record_detail"><?php echo $setting['Setting']['value']; ?>&nbsp;</div>
            </div>
            <div style="width:50px" id="record_row">
                <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $setting['Setting']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
            </div>
            <div style="width:50px" id="record_row">
            	<div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $setting['Setting']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $setting['Setting']['id'])); ?></div>
            </div>
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