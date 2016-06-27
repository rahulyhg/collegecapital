<div class="rates view">
	<ul id="rates_list" class="content"> 
		<li>
        	<a href='<?php echo Configure::read('Company.menuUrl');?>app/webroot/uploads/rates/<?php echo $rate['Rate']['documentFile'];?>' target='_blank'><?php echo $rate['Rate']['title'];?></a><br />
			<?php if(strlen($rate['Rate']['description'])>0){ echo "<p>".$rate['Rate']['description']."</p>"; } ?>
        </li>
    </ul>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT RATE', true), array('action' => 'edit', $rate['Rate']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE RATE', true), array('action' => 'delete', $rate['Rate']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rate['Rate']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO RATES', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW RATE', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS RATE?', true), array('action' => 'publish', $rate['Rate']['id']), null, sprintf(__('Are you sure you want to publish RATE # %s?', true), $rate['Rate']['id'])); ?>
</div>