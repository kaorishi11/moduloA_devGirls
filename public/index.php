<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Auth.php';
require_once __DIR__ . '/../app/core/Csrf.php';

if (APP_ENV === 'development') { ini_set('display_errors', 1); error_reporting(E_ALL); }
Csrf::check();

$r = new Router();

$r->get('/login', fn() => (new AuthController())->loginForm());
$r->post('/login', fn() => (new AuthController())->login());
$r->get('/register', fn() => (new AuthController())->registerForm());
$r->post('/register', fn() => (new AuthController())->register());
$r->get('/logout', fn() => (new AuthController())->logout());

$r->get('/', fn() => (new DashboardController())->index());
$r->get('/dashboard', fn() => (new DashboardController())->index());

$r->get('/deliveries', fn() => (new DeliveryController())->index());
$r->post('/deliveries/store', fn() => (new DeliveryController())->store());
$r->post('/deliveries/update', fn() => (new DeliveryController())->update());
$r->post('/deliveries/delete', fn() => (new DeliveryController())->delete());
$r->get('/deliveries/api', fn() => (new DeliveryController())->apiList());

$r->get('/vehicles', fn() => (new VehicleController())->index());
$r->post('/vehicles/store', fn() => (new VehicleController())->store());
$r->post('/vehicles/update', fn() => (new VehicleController())->update());
$r->post('/vehicles/delete', fn() => (new VehicleController())->delete());

$r->get('/drivers', fn() => (new DriverController())->index());
$r->post('/drivers/store', fn() => (new DriverController())->store());
$r->post('/drivers/update', fn() => (new DriverController())->update());
$r->post('/drivers/delete', fn() => (new DriverController())->delete());

$r->get('/map', fn() => (new MapController())->index());
$r->get('/map/api', fn() => (new MapController())->apiData());

$r->get('/ai', fn() => (new AiController())->index());
$r->post('/ai/ask', fn() => (new AiController())->ask());

$r->get('/users', fn() => (new UserController())->index());
$r->post('/users/store', fn() => (new UserController())->store());

$r->get('/reports', fn() => (new ReportController())->index());
$r->get('/reports/export', fn() => (new ReportController())->export());

$r->get('/alerts', fn() => (new AlertController())->index());
$r->post('/alerts/mark', fn() => (new AlertController())->markRead());

$r->get('/proofs', fn() => (new ProofController())->index());
$r->post('/proofs/store', fn() => (new ProofController())->store());

$r->get('/import', fn() => (new ImportController())->index());
$r->post('/import/validate', fn() => (new ImportController())->validate());
$r->post('/import/confirm', fn() => (new ImportController())->confirm());

$r->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);