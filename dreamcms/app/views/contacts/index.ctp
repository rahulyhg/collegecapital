<?php //echo $jQValidator->validator(); ?>

<script type="application/javascript" language="javascript">
	$(document).ready(function(){
	  $("#ContactSubject").focus();
	});
</script>
<div class="contact form">
	<!--<div id="record">
        <div id="record_header_wrap">
        	<div id="record_header">
        		<div id="record_detail">Enter details</div>
        	</div>
    	</div>-->
        <h2>Enter details</h2>
		<?php 
			echo $this->Form->create('Contact', array('action' => 'send','class'=>'editForm')); 
			echo $this->Form->input('Contact.name', array('label' => 'Name', 'maxlength' => 100, 'size' => 40, 'value' => $_SESSION['Auth']['User']['name'], 'readonly' => true));
			echo $this->Form->input('Contact.email', array('label' => 'Email', 'maxlength' => 100, 'size' => 40, 'value' => $_SESSION['Auth']['User']['email'], 'readonly' => true));
			echo $this->Form->input('Contact.subject', array('label' => 'Subject', 'maxlength' => 100, 'size' => 40));
			echo $this->Form->input('Contact.message', array('label' => 'Message', 'cols' => 50, 'rows' => 10)); 
		?>
        <!--<div id="record_wrap">
            <div class="record_row_desc" id="record_row">
                <div id="record_detail">&nbsp;</div>
            </div>
            <div class="record_row_data" id="record_row">
                <div id="record_data">-->
		<?php 
				echo "<div style='padding: 0 0 0 190px;'>";
				echo $this->Form->button('Send', array('type'=>'submit'));
				echo "</div>";
				//echo $this->Form->button('Reset', array('type'=>'reset'));				
		?>
        		<!--</div>
            </div>
        </div>-->
	</div>
</div>