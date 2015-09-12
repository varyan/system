<?php

define("ROOT",__DIR__.'/');
define("EXT",'.php');

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same directory
 * as this file.
 */
$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APP FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "app"
 * folder than the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
$app_folder = 'app';

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp.'/';
}
else {
    // Ensure there's a trailing slash
    $system_path = rtrim($system_path, '/').'/';
}

// Is the system path correct?
if ( ! is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('SYS_PATH', str_replace('\\', '/', $system_path));
define('SYS_DIR', trim(strrchr(trim(SYS_PATH, '/'), '/'), '/'));

// The path to the "application" folder
if (is_dir($app_folder)) {
    if (($_temp = realpath($app_folder)) !== FALSE) {
        $app_folder = $_temp;
    }

    define('APP_PATH', $app_folder.DIRECTORY_SEPARATOR);
}
else
{
    if ( ! is_dir(SYS_PATH.$app_folder.DIRECTORY_SEPARATOR)) {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3); // EXIT_CONFIG
    }

    define('APP_PATH', SYS_PATH.$app_folder.DIRECTORY_SEPARATOR);
}

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once SYS_PATH.'start'.EXT;
