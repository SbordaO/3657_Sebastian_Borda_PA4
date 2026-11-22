<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Servicio;
final class ServicioController extends BaseController {
 public function __construct() { $this->model=new Servicio(); }
}
