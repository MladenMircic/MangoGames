<?php
namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\UserInfoModel;

class GameManager implements MessageComponentInterface {
    protected $clients;
    protected $users;
    protected $inGame;

    protected $search;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    /*public function run() {
        while (true) {
            $queueKeys = array_keys($this->queue);
            $this->clients->rewind();
            $matchFound = false;
            for ($i = 0; $i < count($queueKeys) - 1; $i++) {
                for ($j = $i + 1; $j < count($queueKeys); $j++) {
                    if ($this->queue[$queueKeys[$i]]['chosenGenre'] == $this->queue[$queueKeys[$j]]['chosenGenre']) {
                        $player1 = null;
                        $player2 = null;
                        foreach($this->clients as $client) {
                            if ($client->resourceId == $queueKeys[$i])
                                $player1 = $client;
                            if ($client->resourceId == $queueKeys[$j])
                                $player2 = $client;
                            if ($player1 != null && $player2 != null) {
                                $matchFound = true;
                                break;
                            }
                        }
                        $player1->send("pali");
                        $player2->send("pali");
                    }
                    if ($matchFound == true)
                        break;
                }
                if ($matchFound == true)
                    break;
            }
        }
    }*/

    public function match(ConnectionInterface $conn) {
        $opponent = null;
        foreach($this->clients as $client) {
            if ($this->users[$client->resourceId]['status'] == 'inQueue' && $conn != $client) {
                $opponent = $client;
                break;
            }
        }
        if ($opponent != null) {
            $this->users[$conn->resourceId]['status'] = 'playing';
            $this->users[$opponent->resourceId]['status'] = 'playing';
            $conn->send("pali");
            $opponent->send("pali");
        }
        /*$timesToTry = 0;
        $temp = false;
        while ($timesToTry++ < 10) {

        }
        if ($temp == false) {
            $conn->send("nema drugih igraca");
        }*/
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring,$queryarray);
        $userInfoModel = new UserInfoModel();
        $userInfo = $userInfoModel->where('username', $queryarray['username'])->where('genre', $queryarray['chosenGenre'])->findAll();
        $this->users[$conn->resourceId] = ['username' => $queryarray['username'], 'chosenGenre' => $queryarray['chosenGenre'], 'points' => $userInfo[0]->points, 'status' => 'inQueue'];
        $this->match($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}