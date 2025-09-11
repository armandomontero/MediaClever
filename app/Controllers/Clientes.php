<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\CategoriasModel;
use App\Models\ClientesEventosModel;
use App\Models\UnidadesModel;

class Clientes extends BaseController
{
    protected $clientes;
    protected $unidades;
    protected $clientes_eventos;
    protected $categorias;
    protected $reglas;

    public function __construct()
    {
        $this->clientes = new ClientesModel();
        $this->unidades = new UnidadesModel();
        $this->categorias = new CategoriasModel();
        $this->clientes_eventos = new ClientesEventosModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'telefono' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $id_tienda = $this->session->id_tienda;
        $clientes = $this->clientes->where('activo', $activo)->where("id_tienda = " . $id_tienda . " OR id = 1")->orderBy('nombre', 'ASC')->findAll();
        $data = ['titulo' => 'Clientes', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/index', $data);
        echo view('footer');
    }


    public function participantes($id_evento = null, $mensaje = null)
    {

        $clientes = $this->clientes_eventos->select('*, clientes_eventos.id AS id_participa')->join('clientes', 'id_cliente = clientes.id')->where('id_evento', $id_evento)->orderBy('nombre', 'ASC')->findAll();
        $data = ['titulo' => 'Participantes Mediación: ' . $id_evento . '', 'datos' => $clientes, 'id_evento' => $id_evento, 'mensaje' => $mensaje];

        echo view('header');
        echo view('clientes/participantes', $data);
        echo view('footer');
    }


        public function participantesVer($id_evento = null, $mensaje = null)
    {

        $clientes = $this->clientes_eventos->select('*, clientes_eventos.id AS id_participa')->join('clientes', 'id_cliente = clientes.id')->where('id_evento', $id_evento)->orderBy('nombre', 'ASC')->findAll();
        $data = ['titulo' => 'Participantes Mediación: ' . $id_evento . '', 'datos' => $clientes, 'id_evento' => $id_evento, 'mensaje' => $mensaje];

        echo view('header');
        echo view('clientes/participantes_ver', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $clientes = $this->clientes->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'clientes', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {

        if ($valid != null) {
            $data = ['titulo' => 'Agregar Cliente', 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Agregar Cliente'];
        }
        echo view('header');
        echo view('clientes/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->clientes->save([
                'nombre' => $this->request->getPost('nombre'),
                'direccion' => $this->request->getPost('direccion'),
                'region' => $this->request->getPost('region'),
                'comuna' => $this->request->getPost('comuna'),
                'telefono' => $this->request->getPost('telefono'),
                'correo' => $this->request->getPost('correo'),
                'activo' => 1,
                'id_tienda' => $this->session->id_tienda

            ]);
            return redirect()->to(base_url() . 'clientes');
        } else {
            $this->nuevo($this->validator);
        }
    }



    public function addParticipante()
    {
        $id_evento = $this->request->getPost('id_evento');
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {

            //limpiamos rut
            $rut_solicitante = str_replace('.', '', $this->request->getPost('rut'));

            if ($this->request->getPost('id_cliente') && $this->request->getPost('id_participa')) {
                $this->clientes->update($this->request->getPost('id_cliente'), [
                    'nombre' => $this->request->getPost('nombre'),
                    'direccion' => $this->request->getPost('direccion'),
                    'region' => $this->request->getPost('region1h'),
                    'comuna' => $this->request->getPost('comuna1h'),
                    'telefono' => $this->request->getPost('telefono'),
                    'correo' => $this->request->getPost('correo')
                ]);
                $this->clientes_eventos->update($this->request->getPost('id_participa'), [
                    'tipo' => $this->request->getPost('tipo')

                ]);

                 $mensaje = 'Datos actualizados con éxito';
            } else {
                $dataInsert = [
                    'rut' => $rut_solicitante,
                    'nombre' => $this->request->getPost('nombre'),
                    'direccion' => $this->request->getPost('direccion'),
                    'region' => $this->request->getPost('region1h'),
                    'comuna' => $this->request->getPost('comuna1h'),
                    'telefono' => $this->request->getPost('telefono'),
                    'correo' => $this->request->getPost('correo'),
                    'activo' => 1,
                    'id_tienda' => $this->session->id_tienda

                ];

                $this->clientes->insert($dataInsert);
                $id_participante = $this->clientes->getInsertID();

                //relacionamos con evento
                $this->clientes_eventos->save([
                    'id_cliente' => $id_participante,
                    'id_evento' => $id_evento,
                    'tipo' => $this->request->getPost('tipo')

                ]);

                $mensaje = 'Datos almacenados con éxito';
            }
            $this->participantes($id_evento, $mensaje);
        } else {
            $this->nuevo($this->validator);
            $this->participantes($id_evento, $this->validator);
        }
    }

    public function delParticipante($id)
    {
     //obtenermos evento asociado
     $evento = $this->clientes_eventos->select('id_evento')->where('id', $id)->first();
     //echo $evento['id_evento'];
   
        $this->clientes_eventos->delete($id);


        $this->participantes($evento['id_evento']);
    }


    public function editar($id, $valid = null)
    {
        if ($id == 1) {
            echo 'No se puede editar este registro!';
            exit;
        }
        try {
            $cliente = $this->clientes->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Cliente', 'datos' => $cliente, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Editar Cliente', 'datos' => $cliente];
        }


        echo view('header');
        echo view('clientes/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->clientes->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'direccion' => $this->request->getPost('direccion'),
                'region' => $this->request->getPost('region'),
                'comuna' => $this->request->getPost('comuna'),
                'telefono' => $this->request->getPost('telefono'),
                'correo' => $this->request->getPost('correo')
            ]);
            return redirect()->to(base_url() . 'clientes/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        if ($id == 1) {
            echo 'No se puede eliminar este registro!';
            exit;
        }
        $this->clientes->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'clientes');
    }

    public function reingresar($id)
    {
        $this->clientes->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'clientes');
    }


    public function autoCompleteData()
    {
        $returnData = array();
        $valor = $this->request->getGet('term');
        $clientes = $this->clientes->like('nombre', $valor)->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->findAll();
        if (!empty($clientes)) {
            foreach ($clientes as $row) {
                $data['id'] = $row['id'];
                $data['value'] = $row['nombre'];
                array_push($returnData, $data);
            }
        }
        echo json_encode($returnData);
    }


    public function getParticipanteByID($id)
    {
        $this->clientes->select('*');

        $this->clientes->join('clientes_eventos', 'clientes.id = id_cliente');
        $this->clientes->where('clientes_eventos.id', $id);
        $datos = $this->clientes->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';

        if ($datos) {
            $res['datos'] = $datos;
            $res['existe'] = true;
        } else {
            $res['error'] = "No existe el producto";
            $res['existe'] = false;
        }

        echo json_encode($res);
    }
}
