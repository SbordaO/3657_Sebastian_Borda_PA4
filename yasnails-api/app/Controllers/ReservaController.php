<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Reserva;
final class ReservaController extends BaseController {
 public function __construct() { $this->model=new Reserva(); }
}
