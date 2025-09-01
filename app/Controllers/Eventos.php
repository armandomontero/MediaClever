<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\ConfiguracionModel;
use App\Models\EventosMaterias;
use App\Models\EventosModel;
use App\Models\HijosModel;
use App\Models\MateriasModel;
use App\Models\ServiciosModel;
use App\Models\TiendasModel;
use App\Models\UsuariosModel;

class Eventos extends BaseController
{
    protected $eventos;
    protected $clientes;
    protected $hijos;
    protected $materias;
    protected $eventos_materias;
    protected $servicios;
    protected $reglas;
    protected $reglas_agendar;
    protected $usuarios;

    public function __construct()
    {
        $this->eventos = new EventosModel();
        $this->clientes = new ClientesModel();
        $this->hijos = new HijosModel();
        $this->servicios = new ServiciosModel();
        $this->eventos_materias = new EventosMaterias();
        $this->materias = new MateriasModel();
        $this->usuarios = new UsuariosModel();
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
        
       
        if ($datos_tienda ) {
            $eventos = $this->eventos->where('reservado', 1)->where('id_tienda', $id_tienda)->findAll();
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
                'direccion' => $this->request->getPost('direccion_solicitante'),
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
                 'direccion' => $this->request->getPost('direccion_solicitado'),
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
                'valor' => $this->request->getPost('valor'),
                'region_evento' => $this->request->getPost('region1h'),
                'comuna_evento' => $this->request->getPost('comuna1h'),
                'causa' => $this->request->getPost('violencia'),
                'state' => 'Agendado',
                'id_tienda' => $this->request->getPost('id_tienda')
            ];
            $this->eventos->insert($dataInsert);
            $id_evento = $this->eventos->getInsertID();


            //materias
            $cuentaMaterias = $this->materias->cuentaMaterias($this->session->id_tienda);
            
            for($i=0; $i<$cuentaMaterias; $i++){
                if($this->request->getPost('materia'.$i)!=null){
                    $this->eventos_materias->save([
                        'id_evento' => $id_evento,
                        'id_materia' => $this->request->getPost('materia'.$i)
                    ]);
                }
            }

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
                    'edad' => $this->request->getPost('edad' . $i),
                    'id_evento' => $id_evento
                ]);
            }

            //llamamos notificados

            $usuarios = new UsuariosModel();
            $notificados = $usuarios->getNotificados($this->session->id_tienda);
            $array_correos = [];
            foreach($notificados AS $notificado){
                array_push($array_correos, $notificado['correo']);
            }
           // print_r($array_correos);
            //exit();
            $email = \Config\Services::email();
            $email->setFrom('notificamediacionchile@gmail.com', 'Sistema Mediación');
            $email->setTo($array_correos);
            $email->setSubject('Agenda Mediación');
            $email->setMessage('Se ha agendado una nueva hora, para ver los detalles visite el siguiente enlace: <a href="' . base_url() . 'eventos/getEvento/'.$id_evento.'">Click Aquí</a>.');
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


    public function getEvento($id, $valid = null, $mensaje = null)
    {

        try {
            //datos del evento
         $this->eventos->select('eventos.id AS id_evento, id_solicitante, id_solicitado, reservado, valor, 
        fecha_inicio, fecha_fin, causa, id_usuario, state, causa, solicitante.direccion AS direccion_solicitante,
         solicitante.rut AS rut_solicitante, solicitante.nombre AS nombre_solicitante, solicitante.correo AS correo_solicitante, 
         solicitante.telefono AS telefono_solicitante, solicitante.comuna AS comuna_solicitante, solicitante.region AS region_solicitante,
         solicitado.rut AS rut_solicitado, solicitado.nombre AS nombre_solicitado, solicitado.correo AS correo_solicitado, solicitado.direccion AS direccion_solicitado,
         solicitado.telefono AS telefono_solicitado, solicitado.comuna AS comuna_solicitado, solicitado.region AS region_solicitado
         ')
            ->join('clientes AS solicitante', 'id_solicitante = solicitante.id')
            ->join('clientes AS solicitado', 'id_solicitado = solicitado.id');
        $this->eventos->where('eventos.id', $id);

        $evento = $this->eventos->get()->getRow();
            //lamamos hijos
            $hijos = $this->hijos->where('id_evento', $id)->findAll();
            //llamamos materias
            $materias = $this->materias->where('activo', 1)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->orderBy('orden', 'asc')->findAll();

            //llamamos materias seleccionadas
            $eventos_materias = $this->eventos_materias->where('id_evento', $id)->findAll();


            //llamamos mediadores disponibles
            $usuarios = $this->usuarios->where('id_tienda', $this->session->id_tienda)->where("atiende = 1 OR id_rol = 3")->orderBy('nombre', 'asc')->findAll();
            
            //enviamos user_activo
            $user_activo = $this->session->id_usuario;
        
        
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Registro', 'datos' => $evento, 'materias' => $materias, 'eventos_materias' => $eventos_materias, 'hijos' => $hijos, 'validation' => $valid, 'usuarios' => $usuarios, 'user_activo' => $user_activo];
        } else {


            $data = ['titulo' => 'Editar Registro', 'datos' => $evento, 'materias' => $materias, 'eventos_materias' => $eventos_materias, 'hijos' => $hijos, 'mensaje' => $mensaje, 'usuarios' => $usuarios, 'user_activo' => $user_activo];
        }
        echo view('header');
        if($evento->state=='Agendado'){
        echo view('eventos/evento', $data);
        }
        if($evento->state=='Revisado'){
        echo view('eventos/revisado', $data);
        }
        echo view('footer');
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
        $this->eventos->select('eventos.id AS id_evento, id_solicitante, id_solicitado,
        fecha_inicio, fecha_fin, causa, id_usuario, state, causa,
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


        public function actualizar()
    {
         $id_evento = $this->request->getPost('id_evento');
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas_agendar)) {

           

            
            //actualizamos Evento
            $fechaInicio = $this->request->getPost('fecha');
            $nuevaTimestamp = strtotime('+1 hours', strtotime($fechaInicio));
            $fechaFin = date('Y-m-d H:i:s', $nuevaTimestamp);


            $this->eventos->update($this->request->getPost('id_evento'), [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,           
                'valor' => $this->request->getPost('valor'),
                'region_evento' => $this->request->getPost('region1h'),
                'comuna_evento' => $this->request->getPost('comuna1h'),
                'causa' => $this->request->getPost('violencia'),
                'reservado' => $this->request->getPost('reservado'),
                'id_usuario' => $this->request->getPost('id_usuario'),
                'state' => 'Revisado'
                
            ]);


            //actualizamos solicitante
            $this->clientes->update($this->request->getPost('id_solicitante'), [
                'rut' => $this->request->getPost('rut_solicitante'),
                'nombre' => $this->request->getPost('nombre_solicitante'),           
                'direccion' => $this->request->getPost('direccion_solicitante'),
                'comuna' => $this->request->getPost('comuna1h'),
                'region' => $this->request->getPost('region1h'),
                'telefono' => $this->request->getPost('telefono_solicitante'),
                'correo' => $this->request->getPost('correo_solicitante')
                
            ]);


            

            //actualizamos solicitado
            $this->clientes->update($this->request->getPost('id_solicitado'), [
                'rut' => $this->request->getPost('rut_solicitado'),
                'nombre' => $this->request->getPost('nombre_solicitado'),           
                'direccion' => $this->request->getPost('direccion_solicitado'),
                'region' => $this->request->getPost('region2h'),
                'comuna' => $this->request->getPost('comuna2h'),
                'telefono' => $this->request->getPost('telefono_solicitado'),
                'correo' => $this->request->getPost('correo_solicitado')
                
            ]);

            //borramos materias anteriores
            $this->eventos_materias->where('id_evento', $id_evento)->delete();

            //insertar materias
            $cuentaMaterias = $this->materias->cuentaMaterias($this->session->id_tienda);
           
            for($i=0; $i<$cuentaMaterias; $i++){
                if($this->request->getPost('materia'.$i)!=null){
                    $this->eventos_materias->save([
                        'id_evento' => $id_evento,
                        'id_materia' => $this->request->getPost('materia'.$i)
                    ]);
                }
            }

            //borramos hijos anteriores
            $this->hijos->where('id_evento', $id_evento)->delete();
            //cuentaHijos
            $cuentaHijos = $this->request->getPost('cuentaHijos');
            for ($i = 1; $i <= $cuentaHijos; $i++) {
                //limpiamos rut
                $rut = str_replace('.', '', $this->request->getPost('rut' . $i));
                $this->hijos->save([

                    'rut' => $rut,
                    'nombre' => $this->request->getPost('nombre' . $i),
                    'fecha_nac' => $this->request->getPost('fecha' . $i),
                    'edad' => $this->request->getPost('edad' . $i),
                    'id_evento' => $id_evento
                ]);
            }

            /*
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

*/

            $mensaje = 'Los datos han sido actualizados con éxito y la agenda ha sido confirmada.';
            $this->getEvento($id_evento, null, $mensaje);
            // return redirect()->to(base_url() . 'eventos');
        } else {
            $this->getEvento($id_evento, $this->validator, null);
        }
    }
}
