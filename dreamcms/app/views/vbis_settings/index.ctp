<?php
$this->set('page','vbis');
echo $this->Html->css('thickbox.css'); 
echo $this->Html->css('paginateStyles.css');
if (isset($javascript)) {
	echo $javascript->link('jquery.paginate.min.js');
	echo $this->Html->script('thickbox.js'); 
}
?>
<div class="settings index">
    <div id="wrap-tabs">
        <?php 
			if($_SESSION['Auth']['User']['group_id']<4) {?>
            <div class="menu-tab">
                <span class="tab">
				<?php 
				$jsString = "select_onchange('add')";
				echo $this->Html->link('add new', 'add', array('onClick'=>$jsString)); 
				?>	
            </div>
        <?php
		 	} ?>
        <div class="menu-tab">
            <span class="tab-hi"><?php echo $this->Html->link(__('display all', true), array('action' => 'index'));?></span>
        </div>
    </div>
    	
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
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
		<div id="record_wrap" <?php echo $class;?>>
            <div style="width:20px" id="record_row">
                <div id="record_detail"><?php echo $setting['VbisSetting']['id']; ?>&nbsp;&nbsp;&nbsp;</div>
            </div>
            <div style="width:40%" id="record_row">
                <div id="record_detail"><?php echo $setting['VbisSetting']['key']; ?>&nbsp;&nbsp;&nbsp;</div>
            </div>
            <div style="width:40%" id="record_row">
                <div id="record_detail"><?php echo $setting['VbisSetting']['value']; ?>&nbsp;</div>
            </div>
            <div style="width:50px" id="record_row">
                <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $setting['VbisSetting']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
            </div>
            <div style="width:50px" id="record_row">
            	<div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $setting['VbisSetting']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $setting['VbisSetting']['id'])); ?></div>
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