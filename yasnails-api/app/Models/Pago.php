<?php
declare(strict_types=1);
namespace App\Models;
final class Pago extends BaseModel {
 protected string $table='pagos';
 protected string $primaryKey='id_pago';
 protected array $schema=['id_reserva'=>['int',true,false], 'monto'=>['decimal',true,false], 'metodo'=>['string',true,false], 'referencia'=>['string',false,true], 'fecha_pago'=>['datetime',true,false]];
    protected function extraValidation(array $data): array { return isset($data['monto']) && $data['monto'] <= 0 ? ['monto'=>'Debe ser mayor que cero.'] : []; }
}
