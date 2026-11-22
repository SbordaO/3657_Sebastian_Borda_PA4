<?php
declare(strict_types=1);
namespace App\Core;
final class Request {
    public static function body(): array {
        $raw = file_get_contents('php://input');
        if ($raw === '' || $raw === false) return [];
        $data = json_decode($raw, true);
        if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
            Response::json(['success'=>false, 'message'=>'El cuerpo debe contener JSON válido.'], 400);
        }
        return $data;
    }
}
