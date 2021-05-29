<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $requestTo = $request->getUri()->getSegment(1);
        if ($session->get("type") == 'user' && $requestTo != 'User')
            return redirect()->to(base_url("User"));
        if ($session->get("type") == 'mod' && $requestTo != 'Moderator')
            return redirect()->to(base_url("Moderator"));
        else if ($session->get("type") == 'admin' && $requestTo != 'Administrator')
            return redirect()->to(base_url("Administrator"));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}