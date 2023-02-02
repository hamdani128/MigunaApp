<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/auth/login', 'AuthController::index');
$routes->post('/auth/login_check', 'AuthController::login_check');
$routes->get('/auth/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/pasien', 'PasienController::index');
    // admin Pasien
    $routes->post('/pasien/admin/insert', 'PasienController::admin_insert');
    $routes->get('/pasien/admin/getdata', 'PasienController::admin_getdata');
    $routes->post('/pasien/admin/edit_show', 'PasienController::admin_edit_show');
    $routes->post('/pasien/admin/update', 'PasienController::admin_update');
    $routes->post('/pasien/admin/delete', 'PasienController::admin_delete');
    $routes->post('/pasien/admin/antrian_kunjungan', 'PasienController::admin_antrian_kunjungan');
    $routes->get('/pasien/admin/download', 'PasienController::admin_download');
    $routes->post('/pasien/admin/import_data_guru', 'PasienController::import_data_guru');
    // Kunjungan
    $routes->get('/kunjungan', 'RiwayatController::index');
    $routes->get('/kunjungan/admin_getdata', 'RiwayatController::admin_getdata');
    $routes->post('/kunjungan/delete', 'RiwayatController::admin_delete');
    $routes->get('/kunjungan/filter_getdata/(:any)/(:any)', 'RiwayatController::filter_getdata/$1/$2');
    // Product
    $routes->get('/product', 'ProductController::index');
    $routes->get('/product/getdata', 'ProductController::product_getdata');
    $routes->post('/product/insert', 'ProductController::product_insert');
    $routes->post('/product/edit_show', 'ProductController::product_edit_show');
    $routes->post('/product/update', 'ProductController::product_update');
    $routes->post('/product/delete', 'ProductController::product_delete');
    $routes->get('/product/download', 'ProductController::product_download');
    $routes->post('/product/import_data_product', 'ProductController::import_data_product');

    // supplier
    $routes->post('/product/supplier/insert', 'ProductController::supplier_add');
    $routes->get('/product/supplier/getdata', 'ProductController::supplier_getdata');
    $routes->post('/product/supplier/edit_show', 'ProductController::supplier_edit_show');
    $routes->post('/product/supplier/update_data_supplier', 'ProductController::supplier_update_data');
    $routes->post('/product/supplier/delete', 'ProductController::supplier_delete');
    $routes->get('/supplier/download', 'ProductController::download_format_supplier');
    $routes->post('/supplier/import_data_supplier', 'ProductController::import_data_supplier');

    // SDM
    $routes->get('/sdm', 'SDMController::index');
    $routes->get('/sdm/getdata', 'SDMController::getdata');
    $routes->post('/sdm/insert', 'SDMController::insert');
    $routes->post('/sdm/edit_show', 'SDMController::edit_show');
    $routes->post('/sdm/update', 'SDMController::update');
    $routes->post('/sdm/delete', 'SDMController::delete');

    // Treatment
    $routes->get('/treatment', 'TreatmentController::index');
    $routes->post('/treatment/admin/insert', 'TreatmentController::admin_insert');
    $routes->get('/treatment/admin/getdata', 'TreatmentController::admin_get');
    $routes->post('/treatment/admin/edit_show', 'TreatmentController::admin_edit_show');
    $routes->post('/treatment/admin/update', 'TreatmentController::admin_update');
    $routes->post('/treatment/admin/delete', 'TreatmentController::admin_delete');
    $routes->get('/treatment/download_format', 'TreatmentController::download_format');
    $routes->post('/treatment/import_data', 'TreatmentController::import_data');

    // Lokasi cabang 
    $routes->get('/lokasi', 'LokasiController::index');
    $routes->post('/lokasi/insert', 'LokasiController::insert');
    $routes->post('/lokasi/edit_show', 'LokasiController::edit_show');
    $routes->get('/lokasi/getdata', 'LokasiController::getdata');
    $routes->post('/lokasi/update', 'LokasiController::update');
    $routes->post('/lokasi/delete', 'LokasiController::delete');

    // Transaksi Kunjungan
    $routes->get('/transaksi/kunjungan', 'TransaksiKunjungan::index');
    $routes->get('/transaksi/kunjungan/getdata', 'TransaksiKunjungan::getdata');
    $routes->post('/transaksi/kunjungan/add_diagnosa', 'TransaksiKunjungan::add_diagnosa');
    $routes->get('/transaksi/kunjungan/riwayat_tanggal/(:any)', 'TransaksiKunjungan::riwayat_tanggal/$1');
    $routes->post('/transaksi/kunjungan/list_detail_riwayat', 'TransaksiKunjungan::list_detail_riwayat');

    // Transaksi Treatment
    $routes->get('/transaksi/treatment', 'TransaksiTreatment::index');
    $routes->get('/transaksi/treatment/getdata_filter', 'TransaksiTreatment::getdata_filter');
    $routes->post('/transaksi/treatment/value_treat', 'TransaksiTreatment::value_treat');
    $routes->post('/transaksi/treatment/value_prod', 'TransaksiTreatment::value_prod');
    $routes->post('/transaksi/treatment/get_no_antrian', 'TransaksiTreatment::get_no_antrian');
    $routes->post('/transaksi/treatment/pay_transaksi_detail_treat', 'TransaksiTreatment::pay_transaksi_detail_treat');
    $routes->post('/transaksi/treatment/pay_transaksi_detail_prod', 'TransaksiTreatment::pay_transaksi_detail_prod');
    $routes->post('/transaksi/treatment/pay_transaksi', 'TransaksiTreatment::pay_transaksi');
    $routes->post('/transaksi/treatment/pay_transaksi_debit', 'TransaksiTreatment::pay_transaksi_debit');
    $routes->get('/transaksi/treatment/invoice', 'TransaksiTreatment::invoice');
    $routes->post('/transaksi/treatment/list_transaksi', 'TransaksiTreatment::list_transaksi');
    $routes->get('/transaksi/treatment/getdata_visit', 'TransaksiTreatment::getdata_visit');
    $routes->get('/transaksi/treatment/getdata_potsub', 'TransaksiTreatment::getdata_potsub');

    // Transaksi Product
    $routes->get('/transaksi/product', 'TransaksiProduct::index');
    $routes->post('/transaksi/product/list_detail_item', 'TransaksiProduct::list_item');
    $routes->post('/transaksi/product/pay_transaksi_detail', 'TransaksiProduct::pay_transaksi_detail');
    $routes->get('/transaksi/product/getdata_pasien', 'TransaksiProduct::getdata_pasien');
    $routes->post('/transaksi/product/pay_debit', 'TransaksiProduct::pay_debit');
    $routes->post('/transaksi/product/pay_cash', 'TransaksiProduct::pay_cash');
    $routes->post('/transaksi/product/list_transaksi', 'TransaksiProduct::list_transaksi');
    $routes->post('/transaksi/product/delete', 'TransaksiProduct::delete');
    $routes->get('/transaksi/product/invoice', 'TransaksiProduct::invoice');

    // info users
    $routes->get('/infousers', 'InfouserController::index');
    $routes->post('/infousers/insert', 'InfouserController::insert');
    $routes->post('/infousers/show_edit', 'InfouserController::show_edit');
    $routes->post('/infousers/update', 'InfouserController::update');
    $routes->post('/infousers/delete', 'InfouserController::delete');
    $routes->post('/infousers/show_password', 'InfouserController::show_password');

    // Profile
    $routes->get('/profile', 'Profile::index');
    $routes->get('/profile/check', 'Profile::check');
    $routes->post('/profile/insert_profile', 'Profile::insert_profile');
    $routes->post('/profile/change_photo', 'Profile::change_photo');
});

$routes->group('', ['filter' => 'AlreadyLoggedIn'], function ($routes) {
    $routes->get('/register', 'AuthController::register');
    $routes->get('/login', 'AuthController::index');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}