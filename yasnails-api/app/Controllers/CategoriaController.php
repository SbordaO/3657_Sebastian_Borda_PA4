<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Categoria;
final class CategoriaController extends BaseController {
 public function __construct() { $this->model=new Categoria(); }
}
