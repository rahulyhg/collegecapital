<div class="teamsCategories view">
<h2><?php  __('Documents Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $teamsCategory['DocumentsCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $teamsCategory['DocumentsCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Documents Category', true), array('action' => 'edit', $teamsCategory['DocumentsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Documents Category', true), array('action' => 'delete', $teamsCategory['DocumentsCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $teamsCategory['DocumentsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Documents Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documents Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
