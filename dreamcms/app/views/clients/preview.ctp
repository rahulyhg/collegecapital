<div class="clients view">
    <h2><?php echo $client['Client']['name'].$client['Client']['surname']; ?></h2>
    <p>
        <?php if(strlen($client['Client']['logo'])>0) { ?>
            <div style="float: right; width: auto; height: auto; margin: 10px; padding: 0px;"><img src="<?php echo '/app/webroot/uploads/clients/'.$client['Client']['logo'];?>" width="150" /></div>
        <?php } ?>
    </p>
    <p><?php if(strlen($client['Client']['position'])>0){ echo "<strong>Position:</strong> ".$client['Client']['position'];}?><br /><?php if(strlen($client['Client']['companyName'])>0){ echo "<strong>Company Name:</strong> ".$client['Client']['companyName'];}?></p>
    <p><?php if(strlen($client['Client']['email'])>0){?><a href="mailto:<?php echo $client['Client']['email'];?>"><?php echo "<strong>Email:</strong> ".$client['Client']['email']; ?></a><?php } ?></p>
    <p><?php if(strlen($client['Client']['mobile'])>0){ echo "<strong>Mobile:</strong> ".$client['Client']['mobile']; } ?></p>
    <p><?php if(strlen($client['Client']['phone'])>0){ echo "<strong>Phone:</strong> ".$client['Client']['phone']; } ?></p>
    <p><?php if(strlen($client['Client']['fax'])>0){ echo "<strong>Fax:</strong> ".$client['Client']['fax']; } ?></p>
    <p><?php if(strlen($client['Client']['streetAddress'])>0){ echo "<strong>Street Address:</strong> ".$client['Client']['streetAddress'].(strlen($streetState['Tblstate']['State'])>0?", ".$streetState['Tblstate']['State']:"")."<br />";} ?></p>
    <p><?php if(strlen($client['Client']['postalAddress'])>0){ echo "<strong>Postal Address:</strong> ".$client['Client']['postalAddress'].(strlen($postalState['Tblstate']['State'])>0?", ".$postalState['Tblstate']['State']:"")."<br />";} ?></p>
    <p><?php if(strlen($client['Client']['googleMap'])>0){ echo "<strong>Map:</strong> ".$client['Client']['googleMap'];} ?></p>
    <p><?php if(strlen($client['Client']['website'])>0){?><?php echo "<strong>Website:</strong> ";?><a href="<?php echo $client['Client']['website'];?>" target="_blank"><?php echo $client['Client']['website']; ?></a><?php } ?></p>
    <p><?php if(strlen($client['Client']['linkedIn'])>0){ echo "<strong>Linked In:</strong> ".$client['Client']['linkedIn'];} ?></p></div>
<?php 
if($_SESSION['Auth']['User']['group_id']==1){ ?>
<div id="top-cms-text">
    <?php echo $this->Html->link(__('EDIT CONTACT', true), array('action' => 'edit', $client['Client']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('DELETE CONTACT', true), array('action' => 'delete', $client['Client']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $client['Client']['id'])); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('RETURN TO CONTACTS', true), array('action' => 'index')); ?>
    &nbsp; | &nbsp;<?php echo $this->Html->link(__('ADD NEW CONTACT', true), array('action' => 'add')); ?>
    <?php if ($client['Client']['status_id']==0){?>
    	&nbsp; | &nbsp;<?php echo $this->Html->link(__('ACTIVATE?', true), array('action' => 'publish', $client['Client']['id']), null, sprintf(__('Are you sure you want to activate CONTACT # %s?', true), $client['Client']['id'])); ?>
    <?php } ?>
</div>
<?php } ?>