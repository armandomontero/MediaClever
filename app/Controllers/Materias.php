<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MateriasModel;

class Materias extends BaseController
{
    protected $materias;
    protected $reglas;

    public function __construct()
    {
        $this->materias = new MateriasModel();
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'orden' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $materias = $this->materias->where('activo', $activo)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->
        orderBy('nombre', 'asc')->findAll();
        $data = ['titulo' => 'materias', 'datos' => $materias];

        echo view('header');
        echo view('materias/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $materias = $this->materias->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'materias', 'datos' => $materias];

        echo view('header');
        echo view('materias/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {

        $data = ['titulo' => 'Agregar Unidad'];

        echo view('header');
        echo view('materias/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->materias->save([
                'nombre' => $this->request->getPost('nombre'),
                'orden' => $this->request->getPost('orden'),
                'id_tienda' => $this->session->id_tienda
            ]);
            return redirect()->to(base_url() . 'materias');
        } else {
            $data = ['titulo' => 'Agregar Materia', 'validation' => $this->validator];

            echo view('header');
            echo view('materias/nuevo', $data);
            echo view('footer');
        }
    }


    public function editar($id, $valid = null)
    {
        if ($id == 1) {
            echo 'No se puede editar este registro!';
            exit;
        }
        try {
            $materia = $this->materias->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Materia', 'datos' => $materia, 'validation' => $valid];
        } else {


            $data = ['titulo' => 'Editar Materia', 'datos' => $materia];
        }
        echo view('header');
        echo view('materias/editar', $data);
        echo view('footer');
    }



    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->materias->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'orden' => $this->request->getPost('orden')
            ]);
            return redirect()->to(base_url() . 'materias/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        if ($id == 1) {
            echo 'No se puede editar este registro!';
            exit;
        }
        $this->materias->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'materias');
    }

    public function reingresar($id)
    {
        $this->materias->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'materias');
    }

    
}
