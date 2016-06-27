<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/* Custom changes for global variables. These variables can be used anywhere in the app */
	Configure::write('Company.name', 'College Capital');
	if ($_SERVER["SERVER_NAME"]=="echo00"){
		Configure::write('Company.url','http://echo00/ccap.collegecapital/');
		Configure::write('Company.menuUrl','http://echo00/ccap.collegecapital/index.php/');
		Configure::write('Company.ssl_url','http://echo00/ccap.collegecapital/');
		Configure::write('Company.wysiwyg', 'http://echo00/ccap.collegecapital/');
		Configure::write('Company.corporateUrl', 'http://echo00/collegecapital/');
		Configure::write('Company.corporateEmail', 'leanne@collegecapital.com.au');
	} 
        else if (strpos($_SERVER['SERVER_NAME'], 'localhost') !== FALSE){
		Configure::write('Company.url','http://localhost/dreamcms/');
		Configure::write('Company.menuUrl','http://localhost/dreamcms/');
		Configure::write('Company.ssl_url','http://localhost/dreamcms/');
		Configure::write('Company.wysiwyg', 'http://localhost/dreamcms/');
		Configure::write('Company.corporateUrl', 'http://localhost/');
		Configure::write('Company.corporateEmail', 'leanne@collegecapital.com.au');             
	}
        else {
		Configure::write('Company.url', 'http://ccap.collegecapital.com.au/');
		Configure::write('Company.menuUrl','http://ccap.collegecapital.com.au/');
		Configure::write('Company.ssl_url','https://ccap.collegecapital.com.au/');
		Configure::write('Company.wysiwyg', 'http://ccap.collegecapital.com.au/');
		Configure::write('Company.corporateUrl', 'http://www.collegecapital.com.au/');
		Configure::write('Company.corporateEmail', 'leanne@collegecapital.com.au');
	}
	Configure::write('Company.description', 'College Capital Finance Solutions.');
	
	//media plugin
	require APP . 'plugins' . DS . 'media' . DS . 'config' . DS . 'core.php';
	//images sizes
	$small = array('fitCrop' => array(75, 50));
	$medium = array('fitCrop' => array(220, 140));
	$large = array('fitCrop' => array(700, 335));
	 
	Configure::write('Media.filter', array(
		'audio' =>  array(),
		'document' =>  array(),
		'generic' => array(),
		'image' => compact('small', 'medium', 'large'),
		'video' => compact('medium', 'large')
	));