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
$routes->get('/', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');
$routes->get('/produk/(:num)', 'Product::detail/$1');
$routes->get('/keranjang', 'Cart::index');
$routes->get('/keranjang/tambah/(:num)', 'Cart::add/$1');
$routes->get('/keranjang/hapus/(:num)', 'Cart::remove/$1'); // opsional
$routes->get('/checkout', 'Cart::checkout');
$routes->get('/pembayaran/(:num)', 'Cart::pembayaran/$1');
$routes->post('/proses-bayar', 'Cart::prosesBayar');

