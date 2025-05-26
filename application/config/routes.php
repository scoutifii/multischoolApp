<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['school/(:num)'] = 'web/school/$1';
$route['about'] = 'web/about';
$route['news'] = 'web/news';
$route['news-detail/(:num)'] = 'web/news_detail/$1';
$route['notice'] = 'web/notice';
$route['notice-detail/(:num)'] = 'web/notice_detail/$1';
$route['holiday'] = 'web/holiday';
$route['holiday-detail/(:num)'] = 'web/holiday_detail/$1';
$route['events'] = 'web/events';
$route['event-detail/(:num)'] = 'web/event_detail/$1';
$route['galleries'] = 'web/galleries';
$route['gallery-image/(:num)'] = 'web/gallery_image/$1';
$route['teachers'] = 'web/teachers';
$route['staff'] = 'web/staff';
$route['contact'] = 'web/contact';
$route['admission-online'] = 'web/admission_online';
$route['admission-form'] = 'web/admission_form';

$route['page/(:any)'] = 'web/page/$1';

$route['login'] = 'welcome';
$route['forgot'] = 'auth/forgot';
$route['reset/(:any)'] = 'auth/reset/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
