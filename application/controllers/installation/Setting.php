<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    private $error = '';

    function __construct() {
        parent::__construct();
    }

    
    public function index() {
        
        if ($this->config->item('installed') == TRUE) { 
            redirect();
        }
        
        $config_path = APPPATH . 'config/config.php';
        $debug_msg = '';
        $form = 1;
        $instructions = true;
        $requirements = false;
        $purchase = false;
        $database = false;
        $superadmin = false;
        $installation = false;
        $purchase_code = '';
        

        if ($this->input->post()) {
                      
            if ($this->input->post('instructions')) {
                $form = 2;
                $requirements = true;
                
            }else if ($this->input->post('requirements')) {
                
                $form = 3;               
                $requirements = true;
                $purchase = true;
           
            }else if ($this->input->post('database')) {
               
                $form = 3;  
                $requirements = true;
                $purchase = true;
                    
                if ($this->input->post('purchase_code') == '') {
                    $this->error = 'Purchase Code should not be empty';
                }else{
                   
                    $status = $this->__verify_purchase_code($this->input->post('purchase_code'));
                    
                    if(!$status){                        
                        $this->error = 'You should enter valid Purchase Code';
                    }else{
                                                
                        // flag
                        $form = 4; 
                        $database = true;
                        $purchase_code = $this->input->post('purchase_code');
                    }                    
                }
                
            }else if ($this->input->post('superadmin')) {
                
                if ($this->input->post('hostname') == '') {
                    $this->error .= 'MySql database Host name is required.<br/>';
                }
                if ($this->input->post('dbname') == '') {
                    $this->error .= 'MySql database name is required.<br/>';
                } 
                if ($this->input->post('username') == '') {
                    $this->error .= 'MySql database username is required.<br/>';
                }
                if ($this->input->post('password') == '' && strpos(site_url(), 'localhost') === false && strpos(site_url(), '[::1]') === false) {
                    $this->error .= 'MySql database password is required.';
                }
                              
                $form = 4;                   
                $requirements = true;
                $purchase = true;
                $database = true;
                $purchase_code = $this->input->post('purchase_code');
                
                if ($this->error === '') {
                  
                    $conn = @mysqli_connect($this->input->post('hostname'), $this->input->post('username'), $this->input->post('password'), $this->input->post('dbname'));
                    if (!$conn) {                       
                         $this->error .= "Unable to connect to MySQL Database. Provided database connection information is incorrect";
                    } else {
                        $debug_msg .= "Connection to <b>" . $this->input->post('dbname') . "</b> database successfully. Now your are almost done. Go ahead!";
                        if ($this->__update_database_connection()) {
                            $form = 5;  
                            $superadmin = true;
                        }
                        mysqli_close($conn);
                    }
                }                
                
            } else if ($this->input->post('installation')) {
                
                if ($this->input->post('name') == '') {
                    $this->error .= 'Please enter super admin name.<br/>';
                } else if (filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL) === false) {
                    $this->error .= 'Please enter valid email address.<br/>';
                } else if ($this->input->post('phone') == '') {
                    $this->error .= 'Please enter super admin phone.<br/>';
                } else if ($this->input->post('username') == '') {
                    $this->error .= 'Please enter super admin username.<br/>';
                } else if ($this->input->post('password') == '') {
                    $this->error .= 'Please enter super admin password.<br/>';
                } else if ($this->input->post('conf_password') == '') {
                    $this->error .= 'Please enter super admin confirm password.<br/>';
                } else if ($this->input->post('password') != $this->input->post('conf_password')) {
                    $this->error .= 'Your confirm password does not match with password.';
                } 
                
                $form = 5;                   
                $requirements = true;
                $purchase = true;
                $database = true;
                $superadmin = true;
                $purchase_code = $this->input->post('purchase_code');
            }
            
            if ($this->error === '' && $this->input->post('installation')) {
                           
                            
                if ($this->db->table_exists('system_admin')) {
                     
                    // create super admin user
                    $data = array();
                    $data['school_id']  = 0;
                    $data['role_id']    = 1;
                    $data['password']   = md5($this->input->post('password'));
                    $data['temp_password'] = base64_encode($this->input->post('password'));
                    $data['username']   = $this->input->post('username');
                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = 1;      
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = 1;
                    $data['status'] = 1;
                    $this->db->empty_table('users'); 
                    $this->db->insert('users', $data);
                    $user_id = $this->db->insert_id();
               
                    // now creating super admin user profile 
                    $data = array();
                    $data['user_id']  = $user_id;
                    $data['is_default']    = 1;
                    $data['name']   = $this->input->post('name');
                    $data['email'] = $this->input->post('email');
                    $data['phone']   = $this->input->post('phone');
                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = 1;      
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = 1;
                    $data['status'] = 1;
                    $this->db->empty_table('system_admin');       
                    $this->db->insert('system_admin', $data);
                    
                    // now nsert purchase code
                    $data = array();
                    $data['id']  = 1;
                    $data['purchase_code']   = $this->input->post('purchase_code');                   
                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = 1;      
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = 1;
                    $data['status'] = 1;
                    $this->db->empty_table('purchase');       
                    $this->db->insert('purchase', $data);
                    
                    if (!is_really_writable($config_path)) {
                        show_error($config_path . ' should be writable. Database imported successfully. And admin user added successfully. You can set manually in application/config at bottom $config["installed"]  = "true"');
                    }
                    $this->__update_config();
                   
                   $form = 6;                   
                    $requirements = true;
                    $purchase = true;
                    $database = true;
                    $superadmin = true;
                    $installation = true; 
                }else{
                   $this->error = '<b>Database not imported yet. Please import database.sql file from documentation/database</b>'; 
                }
                
            } 
            
            $error_msg = $this->error;
           
        }

        include_once(APPPATH . 'controllers/installation/layout.php');
    }
    
    private function __update_config() {
        
        $config_path = APPPATH . 'config/config.php';
        $this->load->helper('file');
        @chmod($config_path, 0666);
        $config_file = read_file($config_path);
        $config_file = trim($config_file);
        $config_file = str_replace("\$config['installed'] = FALSE;", "\$config['installed'] = TRUE;", $config_file);
        //$config_file = str_replace("\$config['base_url'] = '';", "\$config['base_url'] = '" . site_url() . "';", $config_file);
        if (!$fp = fopen($config_path, 'wb')) {
            return FALSE;
        }
        flock($fp, LOCK_EX);
        fwrite($fp, $config_file, strlen($config_file));
        flock($fp, LOCK_UN);
        fclose($fp);
        @chmod($config_path, 0644);
        return TRUE;
    }

    private function __update_database_connection() {
        
        $hostname = $this->input->post('hostname');
        $database = $this->input->post('dbname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
             
        $database_file = '<?php defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

            /*
            | -------------------------------------------------------------------
            | DATABASE CONNECTIVITY SETTINGS
            | -------------------------------------------------------------------
            | This file will contain the settings needed to access your database.
            |
            | For complete instructions please consult the \'Database Connection\'
            | page of the User Guide.
            |
            | -------------------------------------------------------------------
            | EXPLANATION OF VARIABLES
            | -------------------------------------------------------------------
            |
            |	[\'dsn\']      The full DSN string describe a connection to the database.
            |	[\'hostname\'] The hostname of your database server.
            |	[\'username\'] The username used to connect to the database
            |	[\'password\'] The password used to connect to the database
            |	[\'database\'] The name of the database you want to connect to
            |	[\'dbdriver\'] The database driver. e.g.: mysqli.
            |			Currently supported:
            |				 cubrid, ibase, mssql, mysql, mysqli, oci8,
            |				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
            |	[\'dbprefix\'] You can add an optional prefix, which will be added
                                            |				 to the table name when using the  Query Builder class
            |	[\'pconnect\'] TRUE/FALSE - Whether to use a persistent connection
            |	[\'db_debug\'] TRUE/FALSE - Whether database errors should be displayed.
            |	[\'cache_on\'] TRUE/FALSE - Enables/disables query caching
            |	[\'cachedir\'] The path to the folder where cache files should be stored
            |	[\'char_set\'] The character set used in communicating with the database
            |	[\'dbcollat\'] The character collation used in communicating with the database
            |				 NOTE: For MySQL and MySQLi databases, this setting is only used
            | 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
            |				 (and in table creation queries made with DB Forge).
            | 				 There is an incompatibility in PHP with mysql_real_escape_string() which
            | 				 can make your site vulnerable to SQL injection if you are using a
            | 				 multi-byte character set and are running versions lower than these.
            | 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
            |	[\'swap_pre\'] A default table prefix that should be swapped with the dbprefix
            |	[\'encrypt\']  Whether or not to use an encrypted connection.
            |
            |			\'mysql\' (deprecated), \'sqlsrv\' and \'pdo/sqlsrv\' drivers accept TRUE/FALSE
            |			\'mysqli\' and \'pdo/mysql\' drivers accept an array with the following options:
            |
            |				\'ssl_key\'    - Path to the private key file
            |				\'ssl_cert\'   - Path to the public key certificate file
            |				\'ssl_ca\'     - Path to the certificate authority file
            |				\'ssl_capath\' - Path to a directory containing trusted CA certificats in PEM format
            |				\'ssl_cipher\' - List of *allowed* ciphers to be used for the encryption, separated by colons (\':\')
            |				\'ssl_verify\' - TRUE/FALSE; Whether verify the server certificate or not (\'mysqli\' only)
            |
            |	[\'compress\'] Whether or not to use client compression (MySQL only)
            |	[\'stricton\'] TRUE/FALSE - forces \'Strict Mode\' connections
            |							- good for ensuring strict SQL while developing
            |	[\'ssl_options\']	Used to set various SSL options that can be used when making SSL connections.
            |	[\'failover\'] array - A array with 0 or more data for connections if the main should fail.
            |	[\'save_queries\'] TRUE/FALSE - Whether to "save" all executed queries.
            | 				NOTE: Disabling this will also effectively disable both
            | 				$this->db->last_query() and profiling of DB queries.
            | 				When you run a query, with this setting set to TRUE (default),
            | 				CodeIgniter will store the SQL statement for debugging purposes.
            | 				However, this may cause high memory usage, especially if you run
            | 				a lot of SQL queries ... disable this to avoid that problem.
            |
            | The $active_group variable lets you choose which connection group to
            | make active.  By default there is only one group (the \'default\' group).
                                            |
            | The $query_builder variables lets you determine whether or not to load
            | the query builder class.
                                                            */
            $active_group = \'default\';
            $query_builder = TRUE;

            $db[\'default\'] = array(
                    \'dsn\'	=> \'\',
                    \'hostname\' => \'localhost\',                        
                    \'dbdriver\' => \'mysqli\',
                    \'dbprefix\' => \'\',
                    \'pconnect\' => FALSE,
                    \'db_debug\' => (ENVIRONMENT !== \'production\'),
                    \'cache_on\' => FALSE,
                    \'cachedir\' => \'\',
                    \'char_set\' => \'utf8\',
                    \'dbcollat\' => \'utf8_general_ci\',
                    \'swap_pre\' => \'\',
                    \'encrypt\' => FALSE,
                    \'compress\' => FALSE,
                    \'stricton\' => FALSE,
                    \'failover\' => array(),
                    \'save_queries\' => TRUE
            );
            $db[\'default\'][\'hostname\'] = \'' . $hostname . '\';
            $db[\'default\'][\'username\'] = \'' . $username . '\';
            $db[\'default\'][\'password\'] = \'' . $password . '\';
            $db[\'default\'][\'database\'] = \'' . $database . '\';
            ';
        
        $file_open = fopen(APPPATH . 'config/database.php', 'w+');
      
        if ($file_open) {
            if (fwrite($file_open, $database_file)) {
                return true;
            }
            fclose($file_open);
        }
      
        return false;
    }
    
    private function __verify_purchase_code($purchase_code){
              
        $domain  = $_SERVER['SERVER_NAME']; 
        $full_url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];    
        $post = array();
        $post['purchase_code'] = $purchase_code;     
        $post['domain'] = $domain;
        $post['full_url'] = $full_url;
        $url = 'https://www.codetroopers-team.com/api/verify'; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);       
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);        
        $response = curl_exec($ch);        
        curl_close($ch);        
        if($response == 1){ return true; }else{ return false;}
    }
}
