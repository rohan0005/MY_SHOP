<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'index/load_index_page';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['indexmsg'] = 'index/index_message';


$route['show-message'] = 'message/simpleMessage';


$route['my-view'] = 'template/my_views';

$route['home'] = 'index/load_index_page';


$route['place-order'] = 'order/place_order';




$route['view-all-orders'] = 'order/view_order';



$route['view-details/(:num)'] = 'order/view_oder_details/$1'; // single order details


$route['update-order-status/(:num)'] = 'order/update_status/$1';   // UPDATING THE STATUS OF ORDER (completed, cancelled......)


$route['users'] = 'users/get_users'; // USER PAGE

$route['get_users_data'] = 'users/get_users_data';












