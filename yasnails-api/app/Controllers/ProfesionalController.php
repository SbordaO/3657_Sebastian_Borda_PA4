<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Profesional;
final class ProfesionalController extends BaseController {
 public function __construct() { $this->model=new Profesional(); }
}
