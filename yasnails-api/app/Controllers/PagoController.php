<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Pago;
final class PagoController extends BaseController {
 public function __construct() { $this->model=new Pago(); }
}
