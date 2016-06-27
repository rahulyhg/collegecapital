<div class="ratesCategories view">
<h2><?php  __('Rates Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ratesCategory['RatesCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ratesCategory['RatesCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Rates Category', true), array('action' => 'edit', $ratesCategory['RatesCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Rates Category', true), array('action' => 'delete', $ratesCategory['RatesCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ratesCategory['RatesCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Rates Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Rates Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
