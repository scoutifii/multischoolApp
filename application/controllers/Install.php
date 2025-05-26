<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Install.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Install
 * @description     : This is Install class of the application.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Install extends CI_Controller {
    /*     * **************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : this function redirect to installation process            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */

    public function index() {
       redirect(base_url() . 'installation/setting');             
    }

}
