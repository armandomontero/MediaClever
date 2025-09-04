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
use App\Controllers\Google;

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
        if (!$this->session->id_usuario) {
            exit();
        }
        $eventos = $this->eventos->where("id_tienda", $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Eventos', 'eventos' => $eventos];

        echo view('header');
        echo view('eventos/index', $data);
        echo view('footer');
    }


        public function miAgenda($activo = 1)
    {
        if (!$this->session->id_usuario) {
            exit();
        }
        $eventos = $this->eventos->where("id_tienda", $this->session->id_tienda)->where("id_usuario", $this->session->id_usuario)->findAll();
        $data = ['titulo' => 'Eventos', 'eventos' => $eventos];

        echo view('header');
        echo view('eventos/mi_agenda', $data);
        echo view('footer');
    }

    public function agenda($id_tienda, $pass_tienda, $mensaje = null)
    {
        //primero comprobamos valides de tienda y su pass unica para permitir la agenda
        $tienda = new TiendasModel();

        $datos_tienda = $tienda->where('id', $id_tienda)->where('pass', $pass_tienda)->where('activo', 1)->first();


        if ($datos_tienda) {
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



    public function nuevo($fecha_inicio, $fecha_fin, $desde = null, $mensaje = null)
    {




        $config = new ConfiguracionModel();

        $id_tienda = $this->session->id_tienda;

        $datos_config = $config->where('id_tienda', $id_tienda)->first();

        //llamamos materias
        $materias = $this->materias->where('activo', 1)->where("id_tienda = " . $id_tienda . " OR id = 1")->orderBy('orden', 'asc')->findAll();
        //llamamos mediadores disponibles
        $usuarios = $this->usuarios->where('id_tienda', $this->session->id_tienda)->where("atiende = 1 OR id_rol = 3")->orderBy('nombre', 'asc')->findAll();

        $data = ['config' => $datos_config, 'materias' => $materias, 'desde' => $desde, 'usuarios' => $usuarios, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin,  'mensaje' => $mensaje];
        echo view('header');
        echo view('eventos/nuevo', $data);
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

    public function agendar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas_agendar)) {
            $id_tienda = $this->request->getPost('id_tienda');
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
                'id_tienda' => $id_tienda

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
                'id_tienda' => $id_tienda

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
                'id_tienda' => $id_tienda
            ];
            $this->eventos->insert($dataInsert);
            $id_evento = $this->eventos->getInsertID();


            //materias
            $cuentaMaterias = $this->materias->cuentaMaterias($this->request->getPost('id_tienda'));

            for ($i = 0; $i < $cuentaMaterias; $i++) {
                if ($this->request->getPost('materia' . $i) != null) {
                    $this->eventos_materias->save([
                        'id_evento' => $id_evento,
                        'id_materia' => $this->request->getPost('materia' . $i)
                    ]);
                }
            }

            //Insertamos hijos
            //cuentaHijos

            $cuentaHijos = $this->request->getPost('cuentaHijos');

            for ($i = 0; $i <= $cuentaHijos; $i++) {
                if ($this->request->getPost('nombre' . $i) != '') {
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
            }

            //llamamos notificados

            $usuarios = new UsuariosModel();
            $notificados = $usuarios->getNotificados($this->request->getPost('id_tienda'));
            $array_correos = [];
            foreach ($notificados as $notificado) {
                array_push($array_correos, $notificado['correo']);
            }
            // print_r($array_correos);
            //exit();

            $email = \Config\Services::email();
            $email->setFrom('notificamediacionchile@gmail.com', 'Sistema Mediación');
            $email->setTo($array_correos);
            $email->setSubject('Agenda Mediación ' . $fechaInicio);
            $email->setMessage('Se ha agendado una nueva hora, para ver los detalles visite el siguiente enlace: <a href="' . base_url() . 'eventos/getEvento/' . $id_evento . '">Click Aquí</a>.');
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
        if (!$this->session->id_usuario) {
            exit();
        }
        try {
            //datos del evento
            $this->eventos->select('eventos.id AS id_evento, id_solicitante, id_solicitado, reservado, valor, enlace,
        fecha_inicio, fecha_fin, causa, id_usuario, state, causa, solicitante.direccion AS direccion_solicitante,
         solicitante.rut AS rut_solicitante, solicitante.nombre AS nombre_solicitante, solicitante.correo AS correo_solicitante, 
         solicitante.telefono AS telefono_solicitante, solicitante.comuna AS comuna_solicitante, solicitante.region AS region_solicitante,
         solicitado.rut AS rut_solicitado, solicitado.nombre AS nombre_solicitado, solicitado.correo AS correo_solicitado, solicitado.direccion AS direccion_solicitado,
         solicitado.telefono AS telefono_solicitado, solicitado.comuna AS comuna_solicitado, solicitado.region AS region_solicitado,
         mediador.correo AS correo_mediador, mediador.nombre AS nombre_mediador
         ')
                ->join('clientes AS solicitante', 'id_solicitante = solicitante.id')
                ->join('clientes AS solicitado', 'id_solicitado = solicitado.id')
                ->join('usuarios AS mediador', 'mediador.id = id_usuario', 'left');
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
        if ($evento->state == 'Agendado') {
            echo view('eventos/evento', $data);
        }
        if ($evento->state == 'Revisado') {
            echo view('eventos/revisado', $data);
        }


        if ($evento->state == 'Notificado') {
            echo view('eventos/sesion', $data);
        }
        echo view('footer');
    }





    public function updEstado($id, $estado)
    {

        $this->eventos->update($id, [
            'state' => $estado
        ]);
        return redirect()->to(base_url() . 'eventos/getEvento/' . $id);
    }


    public function anula($id)
    {

        $this->eventos->update($id, [
            'state' => 'Anulado'
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



    public function notificar()
    {
        if ($this->request->getMethod() == "POST") {
            $id_evento = $this->request->getPost('id_evento');
            $Timestamp = strtotime($this->request->getPost('fecha_inicio'));
            $nuevaTimestamp = strtotime('+1 hours', $Timestamp);
            $fecha_fin = date('Y-m-d  H:i:s', $nuevaTimestamp);
            //$fecha_inicio = date('Y-m-d H:i:s', strtotime($this->request->getPost('fecha')));

            $fecha_i = date('Y-m-d', $Timestamp);
            $fecha_f = date('Y-m-d', $nuevaTimestamp);
            $fecha_iES = date('d-m-Y', $nuevaTimestamp);
            $hora_i = date('H:i:s', $Timestamp);
            $hora_f = date('H:i:s', $nuevaTimestamp);

            $fecha_inicio = $fecha_i . 'T' . $hora_i;
            $fecha_fin = $fecha_f . 'T' . $hora_f;



            $invitados['email'] = [$this->request->getPost('correo_solicitante'), $this->request->getPost('correo_solicitado'), $this->request->getPost('correo_mediador')];
            $nombre = 'Sesión de Mediación';
            $array_correos = [$this->request->getPost('correo_solicitante'), $this->request->getPost('correo_solicitado'), $this->request->getPost('correo_mediador')];
            $descripcion = "Reunión virtual Mediación Familiar";

            $google = new Google();
            $agenda = $google->storeEventForm($fecha_inicio, $fecha_fin, $invitados, $nombre, $descripcion);

            if ($agenda->hangoutLink) {

                $this->eventos->update($this->request->getPost('id_evento'), [
                    'enlace' => $agenda->hangoutLink,
                    'state' => 'Notificado'
                ]);

                $meet = 1;
            } else {
                $meet = 0;
            }

            //ahora notificados por mail

            //definimos variable a usar
            //$nombre_mediador = $this->request->getPost('nombre_mediador');
            $nombre_solicitante = $this->request->getPost('nombre_solicitante');
            $nombre_solicitado = $this->request->getPost('nombre_solicitado');


            //llamamos datos de configuracion
            $config = new ConfiguracionModel();
            $datos_config = $config->where('id_tienda', $this->session->id_tienda)->first();
            $atte = $datos_config['nombre'];

            //llamamos materias y creamos html con ellas
            $materias = $this->materias->select("*")->join('eventos_materias', 'id_materia = materias.id')->where('id_evento', $id_evento)->orderBy('orden', 'asc')->findAll();

            $lista_materias = '';
            $i = 0;
            foreach ($materias as $materia) {
                $i++;
                $lista_materias = $lista_materias . $i . '- ' . $materia['nombre'] . '<br>';
            };

            $cuerpo = 'Por la presente me dirijo a ustedes, en atención que se ha acercado a mi don o doña ' . $nombre_solicitante . ', a fin de solicitar un proceso de Mediación Familiar sobre: 
 <br><br>

' . $lista_materias . '
<br>

A fin de llevar a cabo el proceso de Mediación Familiar, cito en mi calidad de mediador/a a Don/ña ' . $nombre_solicitante . ' y a Don/ña ' . $nombre_solicitado . ', para que comparezcan a Mediación Familiar vía telemática por plataforma meet, para el día ' . $fecha_iES . ' a las ' . $hora_i . ' horas.
<br><br>
Solicito confirmar asistencia a la brevedad 
<br><br>

El link de acceso a la reunión virtual es el siguiente:
<br>
<a href="' . $agenda->hangoutLink . '">' . $agenda->hangoutLink . '</a>
<br>
Al cual podrán acceder en la fecha y hora señalada en la presente notificación.
<br><br><br>

La mediación familiar es un proceso pacifico de resolución de conflictos, a través del cual un tercero imparcial, llamado mediador, ayuda a las partes a solucionar sus conflictos y arribar a un acuerdo. Es un proceso voluntario y confidencial, es decir, el mediador debe guardar reserva respecto a lo tratado en la sesión de mediación, salvo en aquellos casos en que tome conocimiento de la existencia de situaciones de maltrato o abuso en contra de niños, niñas, adolescentes o discapacitados.
<br>
Los resultados del proceso de mediación pueden ser dos: 
<br>
1. las partes lleguen a un acuerdo, lo que se plasma a través de un acta de acuerdo que debe ser leída y firmada por los mediados y enviada al tribunal de familia competente para su aprobación. Una vez aprobada el acta de acuerdo por parte del tribunal, tendrá el valor de una sentencia firme o ejecutoriada, es decir, el cumplimiento de lo acordado puede solicitarse ante el tribunal competente, de igual modo que una sentencia judicial.
<br>

2. Las partes no logren acuerdos, por lo que en ese caso la mediación resulta frustrada, caso en el que el mediador emitirá un acta de mediación frustrada, lo que permite al interesado continuar el proceso judicial pendiente o iniciarlo en caso que la mediación sea anterior al proceso judicial.
<br><br>
 Atentamente, '.$atte.' <br><br>
 
 <br>
 <br>
 El contenido de este correo electrónico es confidencial y está destinado únicamente para los destinatarios especificados en el mensaje. Está estrictamente prohibido compartir cualquier parte de este mensaje con terceros sin el consentimiento del remitente. Si recibió este mensaje por error, por favor responda a este mensaje y proceda a su eliminación, para que podamos asegurarnos de que dicho error no ocurra en el futuro.';

            $email = \Config\Services::email();
            $email->setFrom('notificamediacionchile@gmail.com', 'Sistema Mediación');
            $email->setTo($array_correos);
            $email->setSubject('Notificación Mediación ' . $fecha_inicio);

            $email->setMessage($cuerpo);
            $email->setMailType('html');
            $email->setReplyTo($this->request->getPost('correo_mediador'));
            if ($email->send()) {
                // Correo enviado correctamente
                $enviado = 'OK';
                $envio = 1;
            } else {
                // Error al enviar el correo
                $enviado =  'Error al enviar el correo: ' . $email->printDebugger();
                $envio = 0;
                print_r($enviado);
                exit();
                // exit;
            }

            $mensaje = 'La notificación ha sido enviada con éxtito y la reunión virtual ha sido generada, podrá acceder mediante el enlace indicado en la fecha programada.';
            $this->getEvento($id_evento, null, $mensaje);
        }
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

            for ($i = 0; $i < $cuentaMaterias; $i++) {
                if ($this->request->getPost('materia' . $i) != null) {
                    $this->eventos_materias->save([
                        'id_evento' => $id_evento,
                        'id_materia' => $this->request->getPost('materia' . $i)
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



    public function agendarPrivado()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas_agendar)) {

            $id_tienda = $this->session->id_tienda;

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
                'id_tienda' => $id_tienda

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
                'id_tienda' => $id_tienda

            ];
            $this->clientes->insert($dataInsert);
            $id_solicitado = $this->clientes->getInsertID();


            //Insertamos Evento
            $fechaInicio = $this->request->getPost('fecha');
            
            $fechaFin = $this->request->getPost('fecha_fin');

            $dataInsert = [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'id_solicitante' => $id_solicitante,
                'id_solicitado' => $id_solicitado,
                'valor' => $this->request->getPost('valor'),
                'region_evento' => $this->request->getPost('region1h'),
                'comuna_evento' => $this->request->getPost('comuna1h'),
                'causa' => $this->request->getPost('violencia'),
                'state' => 'Revisado',
                'id_tienda' => $id_tienda
            ];
            $this->eventos->insert($dataInsert);
            $id_evento = $this->eventos->getInsertID();


            //materias
            $cuentaMaterias = $this->materias->cuentaMaterias($id_tienda);

            for ($i = 0; $i < $cuentaMaterias; $i++) {
                if ($this->request->getPost('materia' . $i) != null) {
                    $this->eventos_materias->save([
                        'id_evento' => $id_evento,
                        'id_materia' => $this->request->getPost('materia' . $i)
                    ]);
                }
            }

            //Insertamos hijos
            //cuentaHijos

            $cuentaHijos = $this->request->getPost('cuentaHijos');

            for ($i = 0; $i <= $cuentaHijos; $i++) {
                //limpiamos rut
                if ($this->request->getPost('nombre' . $i) != '') {
                    $rut = str_replace('.', '', $this->request->getPost('rut' . $i));
                    $this->hijos->save([

                        'rut' => $rut,
                        'nombre' => $this->request->getPost('nombre' . $i),
                        'fecha_nac' => $this->request->getPost('fecha' . $i),
                        'edad' => $this->request->getPost('edad' . $i),
                        'id_evento' => $id_evento
                    ]);
                }
            }
            /*No seria necesario notificar por mail a los crreadores
            //llamamos notificados

            $usuarios = new UsuariosModel();
            $notificados = $usuarios->getNotificados($this->request->getPost('id_tienda'));
            $array_correos = [];
            foreach($notificados AS $notificado){
                array_push($array_correos, $notificado['correo']);
            }
           // print_r($array_correos);
            //exit();

            $email = \Config\Services::email();
            $email->setFrom('notificamediacionchile@gmail.com', 'Sistema Mediación');
            $email->setTo($array_correos);
            $email->setSubject('Agenda Mediación '.$fechaInicio);
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

*/


            $mensaje = 'Los datos han sido almacenados con éxito y la agenda ha sido confirmada.';
            $this->getEvento($id_evento, null, $mensaje);
            // return redirect()->to(base_url() . 'eventos');
        } else {
            $data = ['titulo' => 'Agregar Unidad', 'validation' => $this->validator];

            echo view('header');
            echo view('eventos/nuevo', $data);
            echo view('footer');
        }
    }
}
