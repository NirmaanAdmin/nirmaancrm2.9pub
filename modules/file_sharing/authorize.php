<?php 


/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
	$system_path = '../../system';

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory than the default one you can set its name here. The directory
 * can also be renamed or relocated anywhere on your server. If you do,
 * use an absolute (full) server path.
 * For more info please see the user guide:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
	$application_folder = '../../application';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
 */
	$view_folder = '';


/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($system_path)) !== FALSE)
	{
		$system_path = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
		// Ensure there's a trailing slash
		$system_path = strtr(
			rtrim($system_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		).DIRECTORY_SEPARATOR;
	}
	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
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

	// Path to the system directory
	define('BASEPATH', $system_path);

	// Path to the front controller (this file) directory
	define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

	// Name of the "system" directory
	define('SYSDIR', basename(BASEPATH));

	// The path to the "application" directory
	if (is_dir($application_folder))
	{
		if (($_temp = realpath($application_folder)) !== FALSE)
		{
			$application_folder = $_temp;
		}
		else
		{
			$application_folder = strtr(
				rtrim($application_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
	{
		$application_folder = BASEPATH.strtr(
			trim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

	// The path to the "views" directory
	if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.'views';
	}
	elseif (is_dir($view_folder))
	{
		if (($_temp = realpath($view_folder)) !== FALSE)
		{
			$view_folder = $_temp;
		}
		else
		{
			$view_folder = strtr(
				rtrim($view_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.strtr(
			trim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

/**
 * Admin URL
 */
define('ADMIN_URL', 'admin');
/**
 * Admin URI
 * CUSTOM_ADMIN_URL is not yet tested well, don't define it
 */
define('ADMIN_URI', DEFINED('CUSTOM_ADMIN_URL') ? CUSTOM_ADMIN_URL : ADMIN_URL);
/**
 * Modules Path
 */
define('APP_MODULES_PATH', FCPATH . 'modules/');
/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
	require_once(BASEPATH.'core/Common.php');


/*
 * ------------------------------------------------------
 *  Set the subclass_prefix
 * ------------------------------------------------------
 *
 * Normally the "subclass_prefix" is set in the config file.
 * The subclass prefix allows CI to know if a core class is
 * being extended via a library in the local application
 * "libraries" folder. Since CI allows config items to be
 * overridden via data set in the main index.php file,
 * before proceeding we need to know if a subclass_prefix
 * override exists. If so, we will set this value now,
 * before any classes are loaded
 * Note: Since the config file data is cached it doesn't
 * hurt to load it here.
 */
	if ( ! empty($assign_to_config['subclass_prefix']))
	{
		get_config(array('subclass_prefix' => $assign_to_config['subclass_prefix']));
	}

/*
 * ------------------------------------------------------
 *  Should we use a Composer autoloader?
 * ------------------------------------------------------
 */
	if ($composer_autoload = config_item('composer_autoload'))
	{
		if ($composer_autoload === TRUE)
		{
			file_exists(APPPATH.'vendor/autoload.php')
				? require_once(APPPATH.'vendor/autoload.php')
				: log_message('error', '$config[\'composer_autoload\'] is set to TRUE but '.APPPATH.'vendor/autoload.php was not found.');
		}
		elseif (file_exists($composer_autoload))
		{
			require_once($composer_autoload);
		}
		else
		{
			log_message('error', 'Could not find the specified $config[\'composer_autoload\'] path: '.$composer_autoload);
		}
	}


/*
 * ------------------------------------------------------
 *  Instantiate the hooks class
 * ------------------------------------------------------
 */
	$EXT =& load_class('Hooks', 'core');

/*
 * ------------------------------------------------------
 *  Is there a "pre_system" hook?
 * ------------------------------------------------------
 */
	$EXT->call_hook('pre_system');

/*
 * ------------------------------------------------------
 *  Instantiate the config class
 * ------------------------------------------------------
 *
 * Note: It is important that Config is loaded first as
 * most other classes depend on it either directly or by
 * depending on another class that uses it.
 *
 */
	$CFG =& load_class('Config', 'core');

	// Do we have any manually set config items in the index.php file?
	if (isset($assign_to_config) && is_array($assign_to_config))
	{
		foreach ($assign_to_config as $key => $value)
		{
			$CFG->set_item($key, $value);
		}
	}

/*
 * ------------------------------------------------------
 * Important charset-related stuff
 * ------------------------------------------------------
 *
 * Configure mbstring and/or iconv if they are enabled
 * and set MB_ENABLED and ICONV_ENABLED constants, so
 * that we don't repeatedly do extension_loaded() or
 * function_exists() calls.
 *
 * Note: UTF-8 class depends on this. It used to be done
 * in it's constructor, but it's _not_ class-specific.
 *
 */
	$charset = strtoupper(config_item('charset'));
	ini_set('default_charset', $charset);

	if (extension_loaded('mbstring'))
	{
		define('MB_ENABLED', TRUE);
		// mbstring.internal_encoding is deprecated starting with PHP 5.6
		// and it's usage triggers E_DEPRECATED messages.
		@ini_set('mbstring.internal_encoding', $charset);
		// This is required for mb_convert_encoding() to strip invalid characters.
		// That's utilized by CI_Utf8, but it's also done for consistency with iconv.
		mb_substitute_character('none');
	}
	else
	{
		define('MB_ENABLED', FALSE);
	}

	// There's an ICONV_IMPL constant, but the PHP manual says that using
	// iconv's predefined constants is "strongly discouraged".
	if (extension_loaded('iconv'))
	{
		define('ICONV_ENABLED', TRUE);
		// iconv.internal_encoding is deprecated starting with PHP 5.6
		// and it's usage triggers E_DEPRECATED messages.
		@ini_set('iconv.internal_encoding', $charset);
	}
	else
	{
		define('ICONV_ENABLED', FALSE);
	}

	if (is_php('5.6'))
	{
		ini_set('php.internal_encoding', $charset);
	}


/*
 * ------------------------------------------------------
 *  Instantiate the URI class
 * ------------------------------------------------------
 */
	$URI =& load_class('URI', 'core');

/*
 * ------------------------------------------------------
 *  Instantiate the routing class and set the routing
 * ------------------------------------------------------
 */
	$RTR =& load_class('Router', 'core', isset($routing) ? $routing : NULL);

/*
 * ------------------------------------------------------
 *  Instantiate the output class
 * ------------------------------------------------------
 */
	$OUT =& load_class('Output', 'core');

/*
 * ------------------------------------------------------
 *	Is there a valid cache file? If so, we're done...
 * ------------------------------------------------------
 */
	if ($EXT->call_hook('cache_override') === FALSE && $OUT->_display_cache($CFG, $URI) === TRUE)
	{
		exit;
	}

/*
 * -----------------------------------------------------
 * Load the security class for xss and csrf support
 * -----------------------------------------------------
 */
	$SEC =& load_class('Security', 'core');

/*
 * ------------------------------------------------------
 *  Load the Input class and sanitize globals
 * ------------------------------------------------------
 */
	$IN	=& load_class('Input', 'core');

/*
 * ------------------------------------------------------
 *  Load the Language class
 * ------------------------------------------------------
 */
	$LANG =& load_class('Lang', 'core');

/*
 * ------------------------------------------------------
 *  Load the app controller and local controller
 * ------------------------------------------------------
 *
 */
	// Load the base controller class
	require_once BASEPATH.'core/Controller.php';

	/**
	 * Reference to the CI_Controller method.
	 *
	 * Returns current CI instance object
	 *
	 * @return CI_Controller
	 */
	function &get_instance()
	{
		return CI_Controller::get_instance();
	}

	class Check_permission extends CI_Controller
	{
	    public function check($path)
	    {	
	    	$file_path = realpath('uploads/'.$_REQUEST['file']);
    		$mime_type = mime_content_type($file_path);
    		if($mime_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $mime_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $mime_type =="application/vnd.openxmlformats-officedocument.presentationml.presentation" || $mime_type == 'application/vnd.ms-excel' || $mime_type == 'application/msword' || $mime_type == 'application/vnd.ms-powerpoint'){
    			return true;
    		}
    		
	    	$path = trim($path, '/');

	    	$path_split = explode('/', $path);

	    	if (is_client_logged_in()) {

	    		if(!(strpos($path, '/'.str_pad(get_client_user_id(), 5, '0', STR_PAD_LEFT).'/') === false)){
	    			return true;
	    		}
	    		
	    		$client_id = get_client_user_id();
	    		$new_path = '';
	    		foreach ($path_split as $p) {
	    			$new_path .= '/'.$p;
		    		$this->db->where('(type = "fs_client" and url LIKE \'%' . $new_path . '\')');
				    $sharings = $this->db->get(db_prefix().'fs_sharings')->result_array();

				    if($sharings){
				    	foreach ($sharings as $share) {
				    		$this->db->where('share_id', $share['id']);
					        $this->db->where('(type = "customer_group" or type = "customer")');
					        $sharing_relationship = $this->db->get(db_prefix().'fs_sharing_relationship')->result_array();

					        $where = '';
					        $customers = [];
					        $customer_groups = [];
					        foreach ($sharing_relationship as $key => $value) {
					            if($value['type'] == 'customer'){
					                $customers[] = $value['value'];
					            }else{
					                $customer_groups[] = $value['value'];
					            }
					        }

					        if(implode(',', $customers) != ''){
					            $where .= '1=1 AND find_in_set('.db_prefix().'clients.userid,"'.implode(',', $customers).'")';
					        }

					        if(count($customer_groups) > 0){
					            $where_group = '';
					            foreach ($customer_groups as $key => $value) {
					                if($where_group == ''){
					                    $where_group = db_prefix().'clients.userid IN (select customer_id from '.db_prefix().'customer_groups where groupid = '.$value.')';
					                }else{
					                    $where_group .= ' OR '.db_prefix().'clients.userid IN (select customer_id from '.db_prefix().'customer_groups where groupid = '.$value.')';
					                }
					            }
					            if($where == ''){
					                $where = '('.$where_group.')';
					            }else{
					                $where .= ' AND ('.$where_group.')';
					            }
					        }

					        if($where != ''){
					            $this->db->where($where);
					        }

					        $this->db->join(db_prefix().'contacts', db_prefix().'clients.userid = '.db_prefix().'contacts.userid', 'left');
					        $list_client = $this->db->get(db_prefix().'clients')->result_array();

					        foreach ($list_client as $val) {
					        	if($val['userid'] == $client_id){
			    					return true;
					        	}
					        }
				    	}
				    }
	    		}
	        }elseif (is_staff_logged_in()) {

			    $staff_id = get_staff_user_id();
	        	$this->db->where('staffid', $staff_id);
	    		$staff = $this->db->get(db_prefix().'staff')->row();
	    		
	    		if (!(strpos($path, '/Public/') === false)) {
	    			return true;
	    		}

	    		if($staff){
	    			$_path = explode('/', $path);
	    			foreach ($_path as $val) {
	    				if($val == $staff->media_path_slug){
	    					return true;
	    				}
	    			}
	    		}

	    		$new_path = '';
	    		foreach ($path_split as $p) {
	    			$new_path .= '/'.$p;

		        	$this->db->where('type = "fs_staff" and url LIKE \'%' . $new_path . '\'');
				    $sharings = $this->db->get(db_prefix().'fs_sharings')->result_array();
				    if($sharings){
				    	foreach ($sharings as $share) {
				    		if($share['created_at'] == $staff_id){
				    			return true;
				    		}else{
				    			$this->db->where('share_id', $share['id']);
						        $this->db->where('(type = "role" or type = "staff")');
						        $sharing_relationship = $this->db->get(db_prefix().'fs_sharing_relationship')->result_array();

						        $where = '';
						        $staffs = [];
						        $roles = [];
						        foreach ($sharing_relationship as $key => $value) {
						            if($value['type'] == 'staff'){
						                $staffs[] = $value['value'];
						            }else{
						                $roles[] = $value['value'];
						            }
						        }

						        if(implode(',', $staffs) != ''){
						            $where .= '1=1 AND find_in_set(staffid,"'.implode(',', $staffs).'")';
						        }

						        if(implode(',', $roles) != ''){
						            if($where == ''){
						                $where .= 'find_in_set(role,"'.implode(',', $roles).'")';
						            }else{
						                $where .= ' AND find_in_set(role,"'.implode(',', $roles).'")';
						            }
						        }

						        if($where != ''){
						            $this->db->where($where);
						        }

						        $list_staff = $this->db->get(db_prefix().'staff')->result_array();

						        foreach ($list_staff as $val) {
						        	if($val['staffid'] == $staff_id){
				    					return true;
						        	}
						        }
				    		}
				    	}
				    }
				}
	        }else{
			    $this->db->where('type = "fs_public" and url LIKE \'%' . $path . '\'');
			    $sharings = $this->db->get(db_prefix().'fs_sharings')->result_array();
			    if($sharings){
					foreach ($sharings as $share) {
						if($share['expiration_date_apply'] == 1 && strtotime($share['expiration_date_apply']) > strtotime(date('Y-m-d'))){
							return false;
						}elseif ($share['download_limits_apply'] == 1 && $share['download_limits'] <= $share['downloads']) {
							return false;
						}elseif ($share['is_download'] == 0) {
							return false;
						}

						return true;
					}			    	
			    }
	        }

	    	return false;
	    }
	}

$testObject = new Check_permission();

if($testObject->check($_REQUEST['file'])){
    $file_path = realpath('uploads/'.$_REQUEST['file']);
    $mime_type = mime_content_type($file_path);
    header('Content-type: '.$mime_type);
    echo readfile(realpath('uploads/'.$_REQUEST['file']));
} else {
   echo 'Access is forbidden.';
}
?>