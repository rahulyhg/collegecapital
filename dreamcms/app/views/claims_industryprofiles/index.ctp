<div class="claimsIndustryprofiles index">
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
            <div style="width:83%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php echo $this->Paginator->sort('industryProfile');?></div>
            </div>
            <div style="width:10%" id="record_header">
                <div class="record_detail_header" id="record_detail"><?php __('Actions');?></div>
            </div>
         </div>
	<?php	
	if($claimsIndustryprofiles){
		$i = 0;
		foreach ($claimsIndustryprofiles as $claimsIndustryprofile):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
        <div id="record_wrap" <?php echo $class;?>>
            <div style="width:20px" id="record_row">
                <div id="record_detail"><?php echo $claimsIndustryprofile['ClaimsIndustryprofile']['id']; ?>&nbsp;</div>
            </div>
            <div style="width:80%" id="record_row">
                <div id="record_detail"><?php echo $claimsIndustryprofile['ClaimsIndustryprofile']['industryProfile']; ?>&nbsp;</div>
            </div>
            <div style="width:50px" id="record_row">
                <div id="record_option" class="imgEdit"><?php echo $this->Html->link($html->image("edit.gif",array('id'=>'edit','alt'=>'edit')), array('action' => 'edit', $claimsIndustryprofile['ClaimsIndustryprofile']['id']), array('escape' => false,'id'=>'record','title'=>'edit')); ?></div>
            </div>
            <div style="width:50px" id="record_row">
			 <?php 	
					foreach ($hasNoClaimIndustryProfileItems as $hasNoIndustryprofiles){
						if($hasNoIndustryprofiles['ClaimsIndustryprofile']['id'] === $claimsIndustryprofile['ClaimsIndustryprofile']['id']){
			?>
                <div id="record_option" class="imgDelete"><?php echo $this->Html->link($html->image("delete.gif",array('id'=>'delete','alt'=>'delete')), array('action' => 'delete', $claimsIndustryprofile['ClaimsIndustryprofile']['id']), array('escape' => false,'id'=>'record','title'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $claimsIndustryprofile['ClaimsIndustryprofile']['id'])); ?></div>
            <?php		}
					}
			?>
            </div>
        </div>
	<?php 
		endforeach;?>
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