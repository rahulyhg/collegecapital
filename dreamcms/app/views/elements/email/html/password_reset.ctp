Dear <?php echo ucwords($User['User']['name']); ?>,<br /><br />
Your CMS login details have been changed. Following are your updated access details:<br />
<ul>
	<li>CMS URL: <?php echo str_replace('dreamsite','dreamcms',Configure::read('Company.url'));?></li>
    <li>Username: <?php echo $User['User']['username'];?></li>
	<li>Password: <?php echo $pwd;?></li></li>
</ul>
Thanks,<br />
CMS Administrator	