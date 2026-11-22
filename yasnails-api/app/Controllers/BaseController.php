<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Request;
use App\Core\Response;
use App\Models\BaseModel;

abstract class BaseController {
    protected BaseModel $model;
    protected string $resource;
    public function index(): never { Response::json(['success'=>true,'data'=>$this->model->all()]); }
    public function show(int $id): never {
        $item=$this->model->find($id);
        if (!$item) Response::json(['success'=>false,'message'=>'Registro no encontrado.'],404);
        Response::json(['success'=>true,'data'=>$item]);
    }
    public function store(): never {
        $v=$this->model->validate(Request::body());
        if ($v['errors']) Response::json(['success'=>false,'message'=>'Datos inválidos.','errors'=>$v['errors']],400);
        $id=$this->model->create($v['data']);
        Response::json(['success'=>true,'message'=>'Registro creado.','data'=>$this->model->find($id)],201);
    }
    public function update(int $id, bool $partial=false): never {
        if (!$this->model->find($id)) Response::json(['success'=>false,'message'=>'Registro no encontrado.'],404);
        $v=$this->model->validate(Request::body(),$partial);
        if ($v['errors']) Response::json(['success'=>false,'message'=>'Datos inválidos.','errors'=>$v['errors']],400);
        if (!$v['data']) Response::json(['success'=>false,'message'=>'Debe enviar al menos un campo.'],400);
        $this->model->update($id,$v['data']);
        Response::json(['success'=>true,'message'=>'Registro actualizado.','data'=>$this->model->find($id)]);
    }
    public function destroy(int $id): never {
        if (!$this->model->find($id)) Response::json(['success'=>false,'message'=>'Registro no encontrado.'],404);
        $this->model->delete($id);
        Response::json(['success'=>true,'message'=>'Registro eliminado.']);
    }
}
