<?php

namespace App\Controllers;

use Google\Client;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use App\Controllers\BaseController;
use App\Models\GoogleModel;
use CodeIgniter\RESTful\ResourceController;
use Google\Service\Calendar\Calendar as CalendarCalendar;
use Config\Services;

use Google\Service\Calendar\CalendarList;
use Google_Service;
use Google_Service_Resource;

class Google extends ResourceController
{
    protected $google;
    protected $ruta_redirect;
    const CALENDAR_SCOPE = 'https://www.googleapis.com/auth/calendar.app.created';
    //const CALENDAR_REDIRECT_URI = 'https://localhost/MediaClever/public/google';
    const CALENDAR_CLIENT_ID = '1089877400901-1od8d1ehd5v310p5q3r8pmqm06f9n2nu.apps.googleusercontent.com';
    const CALENDAR_APP_NAME = 'Media Clever';

    public function __construct()
    {
        $this->google = new GoogleModel();
        $this->ruta_redirect = base_url() . 'google';
    }


    public function index()
    {

        //llamamos datos del usuario
        $session = service('session');

        $mail_usuario = $session->mail_usuario;
        $datos = ['mail_usuario' => $mail_usuario];
        echo view('header');
        echo view('google/index', $datos);
        echo view('footer');
    }

    public function generateLink()
    {
        $authLink =  sprintf(
            'https://accounts.google.com/o/oauth2/auth?scope=%s&redirect_uri=%s&response_type=code&client_id=%s&access_type=offline&prompt=consent',
            $this::CALENDAR_SCOPE,
            $this->ruta_redirect,
            $this::CALENDAR_CLIENT_ID
        );
        return $this->respond(['link' => $authLink]);
    }

    public function storeToken()
    {
        // $data = json_decode($request->getBody()->getContents());
        $data = $this->request->getJSON();

        $code = $data->code;

        $client = new Client();
        $client->setApplicationName($this::CALENDAR_APP_NAME);
        $client->setScopes($this::CALENDAR_SCOPE);


        /* if (!file_exists(dirname('credentials.json')) )
            {
            mkdir(dirname('credentials.json'), 0700, true);
        }
        file_put_contents('credentials.json', $this->google->__getCredentials());
       */

        $client->setAuthConfig(json_decode(env('GOOGLE_CREDENTIALS'), true));

        // unlink('credentials.json');
        
        $client->setAccessType('offline');
        $client->setRedirectUri($this->ruta_redirect);
        $client->setApprovalPrompt('consent');

        $token = $client->fetchAccessTokenWithAuthCode($code);
        $refreshToken = $client->getRefreshToken();

        if (array_key_exists('error', $token)) {
            throw new Exception($token['error']);
        }

        // $this->__storeAuthToken(json_encode($token));

        //aca comprobamos si ya se habia conectado a google y ya se habia creado calendario
        $session = service('session');

        $existe = $this->google->where('id_usuario', $session->id_usuario)->countAllResults();
        if ($existe == 0) {
            $service = new Calendar($client);
            $calendar = new CalendarCalendar();
            $calendar->setSummary('MediaClever');
            $calendar->setTimeZone('America/Santiago'); // Set your desired timezone

            $newCalendar = $service->calendars->insert($calendar);
            $calendarID = $newCalendar->getId();
        } else {
            $calendarID = null;
        }



        $this->__storeAuthToken(json_encode($token), $calendarID);



        return $this->respond(['status' => 'true']);
    }




    public function storeEventForm($fecha_inicio, $fecha_fin, $invitados, $nombre, $descripcion, $usuario)
    {


        $client = $this->__getClient($usuario);
        $service = new Calendar($client);
        $session = service('session');

        $calendarId = $this->google->select('calendarId')->where('id_usuario', $session->id_usuario)->first();


        $event = new Event([
            'summary' => $nombre,

            'description' => $descripcion,
            'start' => [
                'dateTime' => $fecha_inicio, // Example: August 25, 2025, 9:00 AM EDT
                'timeZone' => 'America/Santiago',
            ],
            'end' => [
                'dateTime' => $fecha_fin, // Example: August 25, 2025, 10:00 AM EDT
                'timeZone' => 'America/Santiago',
            ],
            'attendees' => [
                $invitados
            ],
            'reminders' => [
                'useDefault' => FALSE,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 30],
                    ['method' => 'popup', 'minutes' => 10],
                ]
            ],
            "conferenceData" => [
                "createRequest" => [
                    "conferenceSolutionKey" => [
                        "type" => "hangoutsMeet"
                    ],
                    "requestId" => uniqid()
                ]
            ],

        ]);


        $evento = $service->events->insert($calendarId['calendarId'], $event, ['conferenceDataVersion' => 1, 'sendUpdates' => 'all']);
        return $evento;
    }

    private function __storeAuthToken($token, $calendarID = null)
    {

        $session = service('session');

        //$existe = $this->google->where('id_usuario', $session->id_usuario)->countAllResults();

        if ($calendarID) {
            //insertamos token y guardamos calendario

            $this->google->save([
                'token' => $token,
                'calendarId' => $calendarID,
                'id_usuario' => $session->id_usuario
            ]);
        } else {

            //solo actualizamos token
            $this->google->set('token', $token)->where('id_usuario', $session->id_usuario)->update();
        }


        // $this->google->set('calendarId', $calendarId)->where('id', 1)->update();




        // setcookie('token', $token, time() + 3600, '/');
        // setcookie('refresh_token', $refreshToken, time() + 3600, '/');
    }

    private function __getClient($usuario)
    {


        $client = new Client();
        $client->setApplicationName($this::CALENDAR_APP_NAME);
        $client->setScopes($this::CALENDAR_SCOPE);

        $client->setAuthConfig(json_decode(env('GOOGLE_CREDENTIALS'), true));



        $client->setAccessType('offline');
        $client->setRedirectUri($this->ruta_redirect);
        $client->setApprovalPrompt('consent');

        $accessToken = json_decode($this->google->__getToken($usuario), true);
        $client->setAccessToken($accessToken);





        if ($client->isAccessTokenExpired()) {
            $refreshToken = $client->getRefreshToken();
            $accessToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);

            $client->setAccessToken($accessToken);

            $this->__storeAuthToken(json_encode($accessToken), $refreshToken);
        }



        return $client;
    }
}
