<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Database;
use PDO;

abstract class BaseModel {
    protected PDO $db;
    protected string $table;
    protected string $primaryKey;
    // field => [type, required-on-create, nullable]
    protected array $schema = [];
    public function __construct() { $this->db = Database::connection(); }
    public function all(): array {
        return $this->db->query("SELECT * FROM `{$this->table}` ORDER BY `{$this->primaryKey}` DESC")->fetchAll();
    }
    public function find(int $id): ?array {
        $q=$this->db->prepare("SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = ?");
        $q->execute([$id]); return $q->fetch() ?: null;
    }
    public function create(array $data): int {
        $fields=array_keys($data); $columns=implode(',', array_map(fn($f)=>"`{$f}`",$fields));
        $marks=implode(',',array_fill(0,count($fields),'?'));
        $q=$this->db->prepare("INSERT INTO `{$this->table}` ({$columns}) VALUES ({$marks})");
        $q->execute(array_values($data)); return (int)$this->db->lastInsertId();
    }
    public function update(int $id, array $data): bool {
        if (!$data) return false;
        $sets=implode(', ',array_map(fn($f)=>"`{$f}` = ?",array_keys($data)));
        $q=$this->db->prepare("UPDATE `{$this->table}` SET {$sets} WHERE `{$this->primaryKey}` = ?");
        $q->execute([...array_values($data),$id]); return $q->rowCount() > 0 || $this->find($id) !== null;
    }
    public function delete(int $id): bool {
        $q=$this->db->prepare("DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = ?");
        $q->execute([$id]); return $q->rowCount() > 0;
    }
    public function validate(array $input, bool $partial=false): array {
        $errors=[]; $clean=[];
        foreach ($input as $field=>$value) {
            if (!array_key_exists($field,$this->schema)) { $errors[$field]='Campo no permitido.'; continue; }
            [$type,$required,$nullable] = $this->schema[$field];
            if ($value === null && $nullable) { $clean[$field]=null; continue; }
            $valid = match($type) {
                'string' => is_string($value) && trim($value) !== '',
                'int' => filter_var($value,FILTER_VALIDATE_INT) !== false,
                'decimal' => is_numeric($value),
                'bool' => in_array($value,[0,1,'0','1',true,false],true),
                'email' => is_string($value) && filter_var($value,FILTER_VALIDATE_EMAIL) !== false,
                'datetime' => is_string($value) && strtotime($value) !== false,
                default => false,
            };
            if (!$valid) { $errors[$field]="Valor inválido para {$field}."; continue; }
            if ($type==='string' || $type==='email' || $type==='datetime') $clean[$field]=trim((string)$value);
            elseif ($type==='int') $clean[$field]=(int)$value;
            elseif ($type==='decimal') $clean[$field]=(float)$value;
            elseif ($type==='bool') $clean[$field]=(int)(bool)$value;
        }
        if (!$partial) foreach ($this->schema as $field=>$rules) {
            if ($rules[1] && !array_key_exists($field,$input)) $errors[$field]='Este campo es obligatorio.';
        }
        $errors=array_merge($errors,$this->extraValidation($clean));
        return ['data'=>$clean,'errors'=>$errors];
    }
    protected function extraValidation(array $data): array { return []; }
}
