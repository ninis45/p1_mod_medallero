<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$route['medallero/admin/disciplinas/(:num)']			= 'admin_disciplinas/load/$1';
$route['medallero/admin/(:num)']			= 'admin/load/$1';
$route['medallero/admin/disciplinas(/:any)?']			= 'admin_disciplinas$1';
?>