<?php
declare(strict_types=1);
namespace App\Models;
final class Profesional extends BaseModel {
 protected string $table='profesionales';
 protected string $primaryKey='id_profesional';
 protected array $schema=['nombres'=>['string',true,false], 'apellidos'=>['string',true,false], 'email'=>['email',false,true], 'especialidad'=>['string',false,true], 'activo'=>['bool',false,false]];
}
