<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ServiciosModel;

class Servicios extends BaseController
{
    protected $servicios;
    protected $reglas;

    public function __construct()
    {
        $this->servicios = new ServiciosModel();
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'valor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $servicios = $this->servicios->where('activo', $activo)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->
        orderBy('nombre', 'asc')->findAll();
        $data = ['titulo' => 'Servicios', 'datos' => $servicios];

        echo view('header');
        echo view('servicios/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $servicios = $this->servicios->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'servicios', 'datos' => $servicios];

        echo view('header');
        echo view('servicios/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {

        $data = ['titulo' => 'Agregar Servicio'];

        echo view('header');
        echo view('servicios/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->servicios->save([
                'nombre' => $this->request->getPost('nombre'),
                'valor' => $this->request->getPost('valor'),
                'activo' => 1,
                'id_tienda' => $this->session->id_tienda
            ]);
            return redirect()->to(base_url() . 'servicios');
        } else {
            $data = ['titulo' => 'Agregar Servicio', 'validation' => $this->validator];

            echo view('header');
            echo view('servicios/nuevo', $data);
            echo view('footer');
        }
    }


    public function editar($id, $valid = null)
    {
       
        try {
            $servicio = $this->servicios->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Servicio', 'datos' => $servicio, 'validation' => $valid];
        } else {


            $data = ['titulo' => 'Editar Servicio', 'datos' => $servicio];
        }
        echo view('header');
        echo view('servicios/editar', $data);
        echo view('footer');
    }



    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->servicios->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'valor' => $this->request->getPost('valor')
            ]);
            return redirect()->to(base_url() . 'servicios/editar/' . $this->request->getPost('id'));
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
        $this->servicios->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'servicios');
    }

    public function reingresar($id)
    {
        $this->servicios->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'servicios');
    }

    
}
