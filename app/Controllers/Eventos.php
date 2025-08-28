<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\ConfiguracionModel;
use App\Models\EventosModel;
use App\Models\HijosModel;
use App\Models\MateriasModel;
use App\Models\TiendasModel;

class Eventos extends BaseController
{
    protected $eventos;
    protected $clientes;
    protected $hijos;
    protected $materias;
    protected $reglas;
    protected $reglas_agendar;

    public function __construct()
    {
        $this->eventos = new EventosModel();
        $this->clientes = new ClientesModel();
        $this->hijos = new HijosModel();
        $this->materias = new MateriasModel();
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

        $this->reglas_agendar = [
            'nombre_solicitante' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'rut_solicitante' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $eventos = $this->eventos->where("id_tienda", $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Eventos', 'eventos' => $eventos];

        echo view('header');
        echo view('eventos/index', $data);
        echo view('footer');
    }

    public function agenda($id_tienda, $pass_tienda, $mensaje = null)
    {
        //primero comprobamos valides de tienda y su pass unica para permitir la agenda
        $tienda = new TiendasModel();

        $datos_tienda = $tienda->where('id', $id_tienda)->where('pass', $pass_tienda)->where('activo', 1)->first();
        if ($datos_tienda) {
            $eventos = $this->eventos->where('state', 'Confirmado')->where('id_tienda', $id_tienda)->findAll();
            $config = new ConfiguracionModel();
            $datos_config = $config->where('id_tienda', $id_tienda)->first();

            //llamamos materias
            $materias = $this->materias->where('activo', 1)->where("id_tienda = " . $id_tienda . " OR id = 1")->orderBy('orden', 'asc')->findAll();

            $data = ['config' => $datos_config, 'materias' => $materias, 'eventos' => $eventos, 'pass_tienda' => $pass_tienda, 'mensaje' => $mensaje];
            echo view('eventos/agenda', $data);
        } else {
            echo 'Calendario no autorizado';
        }
    }

    public function eliminados($activo = 0)
    {
        $eventos = $this->eventos->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'eventos', 'datos' => $eventos];

        echo view('header');
        echo view('eventos/eliminados', $data);
        echo view('footer');
    }

    public function agendar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas_agendar)) {

            //Insertamos solicitante
            //limpiamos rut
            $rut_solicitante = str_replace('.', '', $this->request->getPost('rut_solicitante'));
            $dataInsert = [
                'rut' => $rut_solicitante,
                'nombre' => $this->request->getPost('nombre_solicitante'),
                'region' => $this->request->getPost('region1h'),
                'comuna' => $this->request->getPost('comuna1h'),
                'telefono' => $this->request->getPost('telefono_solicitante'),
                'correo' => $this->request->getPost('correo_solicitante'),
                'activo' => 1,
                'id_tienda' => $this->request->getPost('id_tienda')

            ];
            $this->clientes->insert($dataInsert);
            $id_solicitante = $this->clientes->getInsertID();

            //Insertamos solicitado
            //limpiamos rut
            $rut_solicitado = str_replace('.', '', $this->request->getPost('rut_solicitado'));
            $dataInsert = [
                'rut' => $rut_solicitado,
                'nombre' => $this->request->getPost('nombre_solicitado'),
                'region' => $this->request->getPost('region2h'),
                'comuna' => $this->request->getPost('comuna2h'),
                'telefono' => $this->request->getPost('telefono_solicitado'),
                'correo' => $this->request->getPost('correo_solicitado'),
                'activo' => 1,
                'id_tienda' => $this->request->getPost('id_tienda')

            ];
            $this->clientes->insert($dataInsert);
            $id_solicitado = $this->clientes->getInsertID();


            //Insertamos Evento
            $fechaInicio = date($this->request->getPost('fecha_bd'));
            $nuevaTimestamp = strtotime('+1 hours', strtotime($fechaInicio));
            $fechaFin = date('Y-m-d H:i:s', $nuevaTimestamp);

            $dataInsert = [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'id_solicitante' => $id_solicitante,
                'id_solicitado' => $id_solicitado,
                'region_evento' => $this->request->getPost('region1h'),
                'comuna_evento' => $this->request->getPost('comuna1h'),
                'causa' => $this->request->getPost('violencia'),
                'state' => 'Agendado',
                'id_tienda' => $this->request->getPost('id_tienda')
            ];
            $this->eventos->insert($dataInsert);
            $id_evento = $this->eventos->getInsertID();


            //Insertamos hijos
            //cuentaHijos
            $cuentaHijos = $this->request->getPost('cuentaHijos');
            for ($i = 1; $i <= $cuentaHijos; $i++) {
                //limpiamos rut
                $rut = str_replace('.', '', $this->request->getPost('rut' . $i));
                $this->hijos->save([

                    'rut' => $rut,
                    'nombre' => $this->request->getPost('nombre' . $i),
                    'fecha_nac' => $this->request->getPost('fecha' . $i),
                    'id_evento' => $id_evento
                ]);
            }
            $email = \Config\Services::email();
            $email->setFrom('agendainfoclever@gmail.com', 'MediaClever');
            $email->setTo($this->request->getPost('correo_solicitante'));
            $email->setSubject('Bienvenido/a al sistema MediaClever');
            $email->setMessage('Para acceder debe entrar en este <a href="' . base_url() . '">link</a> e ingresar con los datos que definió al registrarse.');
            $email->setMailType('html');
            if ($email->send()) {
                // Correo enviado correctamente
                $enviado = 'OK';
            } else {
                // Error al enviar el correo
                $enviado =  'Error al enviar el correo: ' . $email->printDebugger();
                print_r($enviado);
                exit();
                // exit;
            }



            $mensaje = 'Su hora ha sido agendada, en unos minutos lo contactaremos para confirmar.';
            $this->agenda($this->request->getPost('id_tienda'), $this->request->getPost('pass_tienda'), $mensaje);
            // return redirect()->to(base_url() . 'eventos');
        } else {
            $data = ['titulo' => 'Agregar Unidad', 'validation' => $this->validator];

            echo view('header');
            echo view('eventos/nuevo', $data);
            echo view('footer');
        }
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


    public function getDatosId($id)
    {
        $this->eventos->select('
        fecha_inicio, fecha_fin, causa, id_usuario, state,
         solicitante.rut AS rut_solicitante, solicitante.nombre AS nombre_solicitante, solicitante.correo AS correo_solicitante, 
         solicitante.telefono AS telefono_solicitante, solicitante.comuna AS comuna_solicitante, solicitante.region AS region_solicitante,
         solicitado.rut AS rut_solicitado, solicitado.nombre AS nombre_solicitado, solicitado.correo AS correo_solicitado, 
         solicitado.telefono AS telefono_solicitado, solicitado.comuna AS comuna_solicitado, solicitado.region AS region_solicitado
         ')
            ->join('clientes AS solicitante', 'id_solicitante = solicitante.id')
            ->join('clientes AS solicitado', 'id_solicitado = solicitado.id');
        $this->eventos->where('eventos.id', $id);

        $this->eventos->where('eventos.id_tienda', $this->session->id_tienda);
        $datos = $this->eventos->get()->getRow();

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
