<?php
declare(strict_types=1);
namespace App\Models;
final class Reserva extends BaseModel {
 protected string $table='reservas';
 protected string $primaryKey='id_reserva';
 protected array $schema=['id_cliente'=>['int',true,false], 'id_profesional'=>['int',true,false], 'id_servicio'=>['int',true,false], 'inicio'=>['datetime',true,false], 'fin'=>['datetime',true,false], 'precio_acordado'=>['decimal',true,false], 'estado'=>['string',true,false], 'observaciones'=>['string',false,true]];
    protected function extraValidation(array $data): array { $e=[]; if (isset($data['inicio'],$data['fin']) && strtotime($data['fin']) <= strtotime($data['inicio'])) $e['fin']='Debe ser posterior al inicio.'; if (isset($data['precio_acordado']) && $data['precio_acordado'] < 0) $e['precio_acordado']='No puede ser negativo.'; if (isset($data['estado']) && !in_array($data['estado'],['pendiente','confirmada','completada','cancelada'],true)) $e['estado']='Estado no válido.'; return $e; }
}
