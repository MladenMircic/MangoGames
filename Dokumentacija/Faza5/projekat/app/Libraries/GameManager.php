<?php
namespace App\Libraries;

use App\Models\SongModel;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\UserInfoModel;

class GameManager implements MessageComponentInterface {
    protected $clients;
    protected $users;
    protected $activeGames;

    protected $currentGameId = 0;

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
            $data = $this->pickSongs();
            $conn->send("startGame:" . $this->users[$opponent->resourceId]['username'] . ":" . $this->currentGameId);
            $opponent->send("startGame:" . $this->users[$conn->resourceId]['username'] . ":" . $this->currentGameId);
            $this->activeGames[$this->currentGameId] = ['player1' => $conn, 'player2' => $opponent];
            $this->currentGameId++;
        }
        /*$timesToTry = 0;
        $temp = false;
        while ($timesToTry++ < 10) {

        }
        if ($temp == false) {
            $conn->send("nema drugih igraca");
        }*/
    }

    public function pickSongs() {

        $songModel = new SongModel();
        $this->songs = $songModel->findAll();

        $data = [];
        $used = [];
        $i = 0;
        $songToPlayIndex = rand(0, count($this->songs) - 1);
        $data['songToBePlayed'] = $this->songs[$songToPlayIndex];
        $data['songs'] []= $this->songs[$songToPlayIndex]->name;
        while ($i < 3) {
            $currentSongNumber = rand(0, count($this->songs) - 1);
            if (in_array($currentSongNumber, $used) || $this->songs[$currentSongNumber]->name == $data['songToBePlayed']->name)
                continue;
            $data['songs'] []= $this->songs[$currentSongNumber]->name;
            $used []= $currentSongNumber;
            $i++;
        }
        shuffle($data['songs']);
        return $data;
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
        $info = explode(":", $msg);
        switch ($info[0]) {
            case "answered": {
                $gameId = intval($info[1]);
                if ($this->activeGames[$gameId]['player1'] == $from)
                    $this->activeGames[$gameId]['player2']->send("answered:" . $info[2]);
                else
                    $this->activeGames[$gameId]['player1']->send("answered:" . $info[2]);
                break;
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