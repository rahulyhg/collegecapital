<div class="userStatuses view">
<h2><?php  __('User Status');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userStatus['UserStatus']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userStatus['UserStatus']['status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Status', true), array('action' => 'edit', $userStatus['UserStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User Status', true), array('action' => 'delete', $userStatus['UserStatus']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userStatus['UserStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Statuses', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Status', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Users', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Users');?></h3>
	<?php if (!empty($userStatus['users'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Username'); ?></th>
		<th><?php __('Password'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Group'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($userStatus['users'] as $users):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $users['id'];?></td>
			<td><?php echo $users['name'];?></td>
			<td><?php echo $users['username'];?></td>
			<td><?php echo $users['password'];?></td>
			<td><?php echo $users['email'];?></td>
			<td><?php echo $users['group_id'];?></td>
			<td><?php echo $users['status_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'users', 'action' => 'view', $users['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'users', 'action' => 'edit', $users['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'users', 'action' => 'delete', $users['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $users['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Users', true), array('controller' => 'users', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
