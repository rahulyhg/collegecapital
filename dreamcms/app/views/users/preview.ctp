<div class="users view">
    <h2><?php echo $user['User']['name'].$user['User']['surname']; ?></h2>
    <p>
        <?php if(strlen($user['User']['logo'])>0) { ?>
            <div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;"><img src="<?php echo '/app/webroot/uploads/users/'.$user['User']['logo'];?>" width="150" /></div>
        <?php } ?>
        <?php echo $user['User']['description']; ?>
    </p>
    <p><?php if(strlen($user['User']['position'])>0){ echo "<strong>Position:</strong> ".$user['User']['position'];}?><br /><?php if(strlen($user['User']['companyName'])>0){ echo "<strong>Company Name:</strong> ".$user['User']['companyName'];}?></p>
    <p><?php if(strlen($user['User']['email'])>0){?><a href="mailto:<?php echo $user['User']['email'];?>"><?php echo "<strong>Email:</strong> ".$user['User']['email']; ?></a><?php } ?></p>
    <p><?php if(strlen($user['User']['mobile'])>0){ echo "<strong>Mobile:</strong> ".$user['User']['mobile']; } ?></p>
    <p><?php if(strlen($user['User']['phone'])>0){ echo "<strong>Phone:</strong> ".$user['User']['phone']; } ?></p>
    <p><?php if(strlen($user['User']['fax'])>0){ echo "<strong>Fax:</strong> ".$user['User']['fax']; } ?></p>
    <p><?php if(strlen($user['User']['streetAddress'])>0){ echo "<strong>Street Address:</strong> ".$user['User']['streetAddress'].($user['User']['street_state_id']>0?" ,".$user['User']['street_state_id']:"");} ?></p>
    <p><?php if(strlen($user['User']['googleMap'])>0){ echo "<strong>Map:</strong> ".$user['User']['googleMap'];} ?></p>
    <p><?php if(strlen($user['User']['website'])>0){?><a href="<?php echo $user['User']['website'];?>" target="_blank"><?php echo "<strong>Website:</strong> ".$user['User']['website']; ?></a><?php } ?></p>
    <?php if($_SESSION['Auth']['User']['id']==$user['User']['id']){?><p><?php if(strlen($user['User']['websiteLogin'])>0){?><a href="mailto:<?php echo $user['User']['websiteLogin'];?>"><?php echo "<strong>Website Login:</strong> ".$user['User']['websiteLogin']; ?></a><?php } ?></p><?php } ?>
    <p><?php if(strlen($user['User']['linkedIn'])>0){ echo "<strong>Linked In:</strong> ".$user['User']['linkedIn'];} ?></p></div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
	</ul>
</div>