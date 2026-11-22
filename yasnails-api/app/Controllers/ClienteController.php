<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Cliente;
final class ClienteController extends BaseController {
 public function __construct() { $this->model=new Cliente(); }
}
