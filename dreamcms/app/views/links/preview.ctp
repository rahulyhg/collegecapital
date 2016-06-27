<div class="links view">
	<h2><?php echo $link['Link']['name']; ?></h2>
    <?php echo $link['Link']['url'].'<br />'; ?>

    	<?php if(strlen($link['Link']['logo'])>0) { ?>
        	<div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;"><img src="<?php echo 'http://mg/dreamcms/app/webroot/uploads/links/'.$link['Link']['logo'];?>" /></div>
        <?php } ?>
		<?php echo $link['Link']['description']; ?>

</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT LINK', true), array('action' => 'edit', $link['Link']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE LINK', true), array('action' => 'delete', $link['Link']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $link['Link']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO LINKS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW LINK', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS ITEM?', true), array('action' => 'publish', $link['Link']['id']), null, sprintf(__('Are you sure you want to publish LINK # %s?', true), $link['Link']['id'])); ?>
</div>
