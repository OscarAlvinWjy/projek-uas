<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');

$routes->get('/produk/(:num)', 'Product::detail/$1');

$routes->get('/keranjang', 'Cart::index');
$routes->get('/keranjang/tambah/(:num)', 'Cart::add/$1');
$routes->get('/keranjang/hapus/(:num)', 'Cart::remove/$1');
$routes->post('/keranjang/update/(:num)', 'Cart::update/$1');

$routes->get('/keranjang/ajax-tambah/(:num)', 'Cart::ajaxTambah/$1');

$routes->get('/checkout', 'Cart::checkout');
$routes->get('/pembayaran/(:num)', 'Cart::pembayaran/$1');
$routes->get('/beli-sekarang/(:num)', 'Cart::beliSekarang/$1');
$routes->post('/proses-bayar', 'Cart::prosesBayar');

$routes->get('/riwayat', 'Transaksi::index', ['filter' => 'auth']);
$routes->get('/riwayat/detail/(:num)', 'Transaksi::detail/$1', ['filter' => 'auth']);

$routes->get('/produk/(:num)', 'Product::detail/$1');
