<div class="pagesCategories view">
<h2><?php  __('Pages Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pagesCategory['PagesCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pagesCategory['PagesCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pages Category', true), array('action' => 'edit', $pagesCategory['PagesCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Pages Category', true), array('action' => 'delete', $pagesCategory['PagesCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pagesCategory['PagesCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pages Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pages Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
