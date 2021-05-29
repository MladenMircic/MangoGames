<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $wantToExit = $request->getUri()->getQuery();
        if (empty($wantToExit)) {
            $session = session();
            if ($session->get("type") == 'user')
                return redirect()->to(base_url("User"));
            else if ($session->get("type") == 'mod')
                return redirect()->to(base_url("Moderator"));
            else if ($session->get("type") == 'admin')
                return redirect()->to(base_url("Administrator"));
        }
        else
            return redirect()->to(base_url("Login"));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}