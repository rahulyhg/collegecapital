<?php 
	if($session->read('Auth.User.group_id')>0){ ?>
	<!-- content -->
	<div id="content">
    	<div id="error-status" style="display: block;"><?php __('Missing Controller'); ?></div>
		<p class="error">
            <strong><?php __('Error'); ?>: </strong>
            <?php printf(__('%s could not be found.', true), '<em>' . $controller . '</em>'); ?>
        </p>
        <p class="error">
            <strong><?php __('Error'); ?>: </strong>
            <?php printf(__('Create the class %s below in file: %s', true), '<em>' . $controller . '</em>', APP_DIR . DS . 'controllers' . DS . Inflector::underscore($controller) . '.php'); ?>
        </p>
        <pre id="program-code">
        &lt;?php
        class <?php echo $controller;?> extends AppController {
        
            var $name = '<?php echo $controllerName;?>';
        }
        ?&gt;
        </pre>
        <p class="error">
        	<strong>What to do next?</strong>
            <ul>
            	<li>Please check the URL and ensure that it is correct.</li>
                <li>Report this error to Echo3: <a href="mailto:support@echo3.com.au?subject=CMS Error Reporting&body=<?php printf(__('%s could not be found.', true), 'Error Description: ' . $controller); ?>">support@echo3.com.au</a></li>
            </ul>
         </p>
	</div>
<?php 
	} else {
		header('location: /dreamcms/index.php');
}
?>    