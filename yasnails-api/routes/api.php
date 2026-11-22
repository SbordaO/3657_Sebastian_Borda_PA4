<?php
declare(strict_types=1);
use App\Core\Response;
use App\Controllers\CategoriaController;
use App\Controllers\ServicioController;
use App\Controllers\ClienteController;
use App\Controllers\ProfesionalController;
use App\Controllers\ReservaController;
use App\Controllers\PagoController;

$method=$_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri=parse_url($_SERVER['REQUEST_URI'] ?? '/',PHP_URL_PATH) ?: '/';
$base=rtrim(str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
if ($base !== '' && $base !== '/' && str_starts_with($uri,$base)) $uri=substr($uri,strlen($base));
$uri='/'.trim($uri,'/');
if ($uri==='/' && $method==='GET') Response::json(['success'=>true,'message'=>'Yas Nails API MVC funcionando.','version'=>'1.0']);
$routes=[
    'categorias'=>CategoriaController::class,
    'servicios'=>ServicioController::class,
    'clientes'=>ClienteController::class,
    'profesionales'=>ProfesionalController::class,
    'reservas'=>ReservaController::class,
    'pagos'=>PagoController::class,
];
if (!preg_match('#^/api/([a-z]+)/?(?:/(\d+))?$#',$uri,$m) || !isset($routes[$m[1]])) {
    Response::json(['success'=>false,'message'=>'Endpoint no encontrado.'],404);
}
$controller=new $routes[$m[1]]();
$id=isset($m[2])?(int)$m[2]:null;
if ($id===null && $method==='GET') $controller->index();
if ($id!==null && $method==='GET') $controller->show($id);
if ($id===null && $method==='POST') $controller->store();
if ($id!==null && $method==='PUT') $controller->update($id,false);
if ($id!==null && $method==='PATCH') $controller->update($id,true);
if ($id!==null && $method==='DELETE') $controller->destroy($id);
Response::json(['success'=>false,'message'=>'Método no permitido para este endpoint.'],405);
