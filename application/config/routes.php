<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['index'] = 'Controller/index';
$route['logout'] = 'Controller/logout';

$route['dashboard'] = 'Controller/dashboard';

$route['data_karyawan'] = 'Controller/data_karyawan';
$route['tambah_karyawan'] = 'Controller/tambah_karyawan';
$route['edit_karyawan'] = 'Controller/edit_karyawan';

$route['data_nilai'] = 'Controller/data_nilai';
$route['tambah_data_nilai'] = 'Controller/tambah_data_nilai';
$route['edit_data_nilai'] = 'Controller/edit_data_nilai';