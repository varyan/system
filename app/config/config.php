<?php
defined('SYS_PATH') OR exit('No direct script access allowed');
/*
 *---------------------------------------------------------------
 * set base_url path
 * you cane change this with your templates folder
 *---------------------------------------------------------------
 */
$config['base_url'] = 'http://localhost/system/';
/*
 *---------------------------------------------------------------
 * set default template path
 * you cane change this with your templates folder
 *---------------------------------------------------------------
 */
$config['template'] = 'templates/';
/*
 *---------------------------------------------------------------
 * set style path
 * you cane change this with your styles folder
 *---------------------------------------------------------------
 */
$config['assets'] = $config['base_url'].$config['template'].'assets/';