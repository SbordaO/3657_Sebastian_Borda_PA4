<?php
declare(strict_types=1);
namespace App\Models;
final class Categoria extends BaseModel {
 protected string $table='categorias';
 protected string $primaryKey='id_categoria';
 protected array $schema=['nombre'=>['string',true,false], 'descripcion'=>['string',false,true]];
}
