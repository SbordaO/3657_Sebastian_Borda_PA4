<?php
declare(strict_types=1);
namespace App\Models;
final class Servicio extends BaseModel {
 protected string $table='servicios';
 protected string $primaryKey='id_servicios';
 protected array $schema=['id_categoria'=>['int',true,false], 'nombre'=>['string',true,false], 'descripcion'=>['string',false,true], 'precio'=>['decimal',false,true], 'duracion_minutos'=>['int',true,false], 'activo'=>['bool',false,false]];
    protected function extraValidation(array $data): array { $e=[]; if (isset($data['duracion_minutos']) && $data['duracion_minutos'] <= 0) $e['duracion_minutos']='Debe ser mayor que cero.'; if (isset($data['precio']) && $data['precio'] < 0) $e['precio']='No puede ser negativo.'; return $e; }
}
