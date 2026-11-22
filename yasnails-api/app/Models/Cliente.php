<?php
declare(strict_types=1);
namespace App\Models;
final class Cliente extends BaseModel {
 protected string $table='clientes';
 protected string $primaryKey='id_cliente';
 protected array $schema=['nombres'=>['string',true,false], 'apellidos'=>['string',true,false], 'telefono'=>['string',false,true], 'email'=>['email',false,true], 'activo'=>['bool',false,false]];
}
