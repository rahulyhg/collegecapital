<div class="teams view">
	<h2><?php echo $team['Team']['name']; ?></h2>
	<p>
    	<?php if(strlen($team['Team']['photo'])>0) { ?>
        	<div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;"><img src="<?php echo ROOT.DS.$team['Team']['photo'];?>" /></div>
        <?php } ?>
		<?php echo $team['Team']['shortDescription']; ?>
    </p>
	<?php 
		echo '<br />';
		echo $team['Team']['body'].'<br />'; 
		echo $team['Team']['phone'].'<br />'; 
		echo $team['Team']['mobile'].'<br />'; 
		echo $team['Team']['email'].'<br />'; 
		echo $team['Team']['role'].'<br />'; 
		echo addslashes($team['Team']['qualifications']).'<br />'; 
		echo addslashes($team['Team']['memberships']).'<br />'; 
		echo addslashes($team['Team']['publications']).'<br />'; 
		echo $team['Team']['created'].'<br />'; 
	?>
</div>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT TEAM MEMBER', true), array('action' => 'edit', $team['Team']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE TEAM MEMBER', true), array('action' => 'delete', $team['Team']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $team['Team']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO TEAMS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW TEAM MEMBER', true), array('action' => 'add')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('PUBLISH THIS ITEM?', true), array('action' => 'publish', $team['Team']['id']), null, sprintf(__('Are you sure you want to publish TEAM MEMBER # %s?', true), $team['Team']['id'])); ?>
</div>
