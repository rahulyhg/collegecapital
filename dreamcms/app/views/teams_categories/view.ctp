<div class="teamsCategories view">
<h2><?php  __('Teams Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $teamsCategory['TeamsCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $teamsCategory['TeamsCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Teams Category', true), array('action' => 'edit', $teamsCategory['TeamsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Teams Category', true), array('action' => 'delete', $teamsCategory['TeamsCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $teamsCategory['TeamsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Teams Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Teams Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
