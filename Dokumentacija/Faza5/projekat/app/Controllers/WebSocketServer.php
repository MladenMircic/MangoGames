<?php

namespace App\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\GameManager;

class WebSocketServer extends BaseController
{
    public function index()
    {
        if(!is_cli())
            die("Please run the server from the cli.");

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new GameManager()
                )
            ),
            8081
        );

        $server->run();
    }
}
