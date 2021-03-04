<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// login routes
$routes->get('/', 'Auth::login');
$routes->post('/', 'Auth::doLogin');
// register routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::doRegister');
// office routes
$routes->get('/offices', 'Office::index');
$routes->post('/offices/join', 'Office::join');
$routes->get('/offices/create', 'Office::create');
$routes->post('/offices/create', 'Office::save');
$routes->get('/offices/(:segment)', 'Office::detail/$1');
$routes->delete('/offices/(:segment)', 'Office::leave/$1');
$routes->get('/offices/(:segment)/edit', 'Office::edit/$1');
$routes->post('/offices/(:segment)/edit', 'Office::update/$1');
// task routes
$routes->get('/offices/(:segment)/create-task', 'Task::create/$1');
$routes->post('/offices/(:segment)/create-task', 'Task::save/$1');
$routes->get('/offices/(:segment)/(:segment)', 'Task::detail/$1/$2');
$routes->post('/offices/(:segment)/(:segment)/add-comment', 'Task::addComment/$2'); // comment routes
$routes->delete('/offices/(:segment)/(:segment)', 'Task::delete/$1/$2');
$routes->get('/offices/(:segment)/(:segment)/edit', 'Task::edit/$1/$2');
$routes->post('/offices/(:segment)/(:segment)/edit', 'Task::update/$1/$2');
// answer routes
$routes->post('/offices/(:segment)/(:segment)/create-answer', 'Answer::save/$1/$2');
$routes->delete('/offices/(:segment)/(:segment)/(:segment)', 'Answer::delete/$1/$2/$3');
$routes->post('/offices/(:segment)/(:segment)/(:segment)/is-approved', 'Answer::approved/$2/$3');
$routes->delete('/offices/(:segment)/(:segment)/(:segment)/is-approved', 'Answer::notApproved/$2/$3');
// logout routes
$routes->get('/logout', 'Auth::logout');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
