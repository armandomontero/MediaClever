<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventosModel;

class Eventos extends BaseController
{
    protected $eventos;
    protected $reglas;

    public function __construct()
    {
        $this->eventos = new EventosModel();
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'nombre_corto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $eventos = $this->eventos->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->
        orderBy('id', 'asc')->findAll();
        $data = ['titulo' => 'Eventos', 'datos' => $eventos];

        echo view('header');
        echo view('eventos/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $eventos = $this->eventos->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'eventos', 'datos' => $eventos];

        echo view('header');
        echo view('eventos/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {

        $data = ['titulo' => 'Agregar Unidad'];

        echo view('header');
        echo view('eventos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->eventos->save([
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto'),
                'id_tienda' => $this->session->id_tienda
            ]);
            return redirect()->to(base_url() . 'eventos');
        } else {
            $data = ['titulo' => 'Agregar Unidad', 'validation' => $this->validator];

            echo view('header');
            echo view('eventos/nuevo', $data);
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
            $unidad = $this->eventos->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad, 'validation' => $valid];
        } else {


            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad];
        }
        echo view('header');
        echo view('eventos/editar', $data);
        echo view('footer');
    }



    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->eventos->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto')
            ]);
            return redirect()->to(base_url() . 'eventos/editar/' . $this->request->getPost('id'));
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
        $this->eventos->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'eventos');
    }

    public function reingresar($id)
    {
        $this->eventos->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'eventos');
    }

    
}
