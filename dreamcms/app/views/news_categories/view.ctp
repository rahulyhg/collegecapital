<div class="newsCategories view">
<h2><?php  __('News Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newsCategory['NewsCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $newsCategory['NewsCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit News Category', true), array('action' => 'edit', $newsCategory['NewsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete News Category', true), array('action' => 'delete', $newsCategory['NewsCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $newsCategory['NewsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List News Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
