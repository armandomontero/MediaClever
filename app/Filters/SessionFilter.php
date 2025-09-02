<?php

namespace App\Filters;

use App\Controllers\Usuarios;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;

class SessionFilter implements FilterInterface 
{



    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        if (!$session->get('id_usuario')) { // Verificar si la sesión del usuario está activa

            $usuarios = new Usuarios();
             $request = service('request');

            $params =$request->getUri();

            if ($params->getSegment(2) === 'getEvento'&&is_numeric($params->getSegment(3))) {
     return $usuarios->login($params); 
}
else{
    return redirect()->to(base_url());
}

         
           
          // Redirigir a la página de inicio de sesión
            
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario realizar ninguna acción después de la ejecución del controlador.
    }
}