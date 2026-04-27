<?php
defined('BASEPATH') or exit('No direct script access allowed');


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



//product page

$route['product'] = 'product/get_product_page';


//all products
$route['all_product'] = 'product/get_all_product';



//delete orders

$route['delete_order/(:num)'] = 'order/delete_order/$1';



// GET THE LATEST 2 orders of a single user:

$route['latest_order/(:num)'] = 'order/latest_two_orders/$1';



//add new product

$route['add_product'] = 'product/add_new_product';




$route['export'] = 'order/export_orders';


// new product page ss

$route['get_product_ss'] = 'product/all_product_ss';


$route['productSS'] = 'product/new_product_page';

$route['get_all_orders'] = 'order/all_orders_with_details';

$route['all-orders'] = 'order/all_order_page';


// USERS

$route['user-details'] = 'users/users_details_page_ss';

$route['all-users'] = 'users/get_user_details_ss';
