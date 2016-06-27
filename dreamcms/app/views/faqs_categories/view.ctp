<div class="faqsCategories view">
<h2><?php  __('Faqs Category');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqsCategory['FaqsCategory']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqsCategory['FaqsCategory']['category']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Faqs Category', true), array('action' => 'edit', $faqsCategory['FaqsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Faqs Category', true), array('action' => 'delete', $faqsCategory['FaqsCategory']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faqsCategory['FaqsCategory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Faqs Categories', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Faqs Category', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
