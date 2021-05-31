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
            if ($this->users[$client->resourceId]['status'] == 'inQueue' &&
                $conn != $client &&
                $this->users[$conn->resourceId]['chosenGenre'] == $this->users[$client->resourceId]['chosenGenre'])
            {
                $opponent = $client;
                break;
            }
        }
        if ($opponent != null) {
            $this->users[$conn->resourceId]['status'] = 'playing';
            $this->users[$opponent->resourceId]['status'] = 'playing';
            $songModel = new SongModel();
            $this->activeGames[$this->currentGameId]['songs'] = $songModel->findAll();
            $pickedSongs = $this->pickSongs($this->activeGames[$this->currentGameId]['songs']);
            $conn->send("startGame|" . $this->users[$opponent->resourceId]['username'] . "|" . $this->currentGameId . "|" . json_encode($pickedSongs));
            $opponent->send("startGame|" . $this->users[$conn->resourceId]['username'] . "|" . $this->currentGameId . "|" . json_encode($pickedSongs));
            $this->activeGames[$this->currentGameId]['player1'] = $conn;
            $this->activeGames[$this->currentGameId]['player2'] = $opponent;
            $this->activeGames[$this->currentGameId]['currentRound'] = 0;
            $this->activeGames[$this->currentGameId]['endOfRound'] = 0;
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

    public function pickSongs($songs) {
        $data = [];
        $used = [];
        $i = 0;
        $songToPlayIndex = rand(0, count($songs) - 1);
        $data['songToBePlayed'] = $songs[$songToPlayIndex];
        $data['songs'] []= $songs[$songToPlayIndex]->name;
        while ($i < 3) {
            $currentSongNumber = rand(0, count($songs) - 1);
            if (in_array($currentSongNumber, $used) || $songs[$currentSongNumber]->name == $data['songToBePlayed']->name)
                continue;
            $data['songs'] []= $songs[$currentSongNumber]->name;
            $used []= $currentSongNumber;
            $i++;
        }
        shuffle($data['songs']);
        $data['randomTime'] = (double)rand(0, 100) / 100;
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
        $info = explode("|", $msg);
        $gameId = intval($info[1]);
        switch ($info[0]) {
            case "answered": {
                if ($this->activeGames[$gameId]['player1'] == $from) {
                    $this->activeGames[$gameId]['answer1'] = [$info[4], $info[2]];
                    $this->activeGames[$gameId]['player2']->send("answered|" . $info[2] . "|" . $info[3]);
                }
                else {
                    $this->activeGames[$gameId]['answer2'] = [$info[4], $info[2]];
                    $this->activeGames[$gameId]['player1']->send("answered|" . $info[2] . "|" . $info[3]);
                }
                break;
            }
            case "endOfRound": {
                $this->activeGames[$gameId]['endOfRound']++;
                if ($this->activeGames[$gameId]['endOfRound'] == 2) {
                    $this->activeGames[$gameId]['endOfRound'] = 0;
                    $this->activeGames[$gameId]['currentRound']++;
                    $pickedSongs = $this->pickSongs($this->activeGames[$gameId]['songs']);
                    $points1 = $points2 = 0;
                    if (isset($this->activeGames[$gameId]['answer1']) && isset($this->activeGames[$gameId]['answer2'])) {
                        if ($this->activeGames[$gameId]['answer1'][0] == 1 && $this->activeGames[$gameId]['answer2'][0] == 1)
                        {
                            if ($this->activeGames[$gameId]['answer1'][1] == $this->activeGames[$gameId]['answer2'][1]) {
                                $points1 = 4;
                                $points2 = 4;
                            }
                            else if ($this->activeGames[$gameId]['answer1'][1] < $this->activeGames[$gameId]['answer2'][1]) {
                                $points1 = 4;
                                $points2 = 2;
                            }
                            else {
                                $points1 = 2;
                                $points2 = 4;
                            }
                        }
                        else if ($this->activeGames[$gameId]['answer1'][0] == 1 && $this->activeGames[$gameId]['answer2'][0] == 0) {
                            $points1 = 4;
                            $points2 = -1;
                        }
                        else if ($this->activeGames[$gameId]['answer1'][0] == 0 && $this->activeGames[$gameId]['answer2'][0] == 1) {
                            $points1 = -1;
                            $points2 = 4;
                        }
                    }
                    else if (isset($this->activeGames[$gameId]['answer1'])) {
                        if ($this->activeGames[$gameId]['answer1'][0] == 1)
                            $points1 = 4;
                        else
                            $points1 = -1;
                    }
                    else if (isset($this->activeGames[$gameId]['answer2'])) {
                        if ($this->activeGames[$gameId]['answer2'][0] == 1)
                            $points2 = 4;
                        else
                            $points2 = -1;
                    }

                    $this->activeGames[$gameId]['player1']->send("newRound|" . json_encode($pickedSongs) . "|" . $points1 . "|" . $points2);
                    $this->activeGames[$gameId]['player2']->send("newRound|" . json_encode($pickedSongs) . "|" . $points2 . "|" . $points1);
                    unset($this->activeGames[$gameId]['answer1']);
                    unset($this->activeGames[$gameId]['answer2']);
                }
                break;
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        foreach ($this->activeGames as $activeGame) {
            if (($activeGame['player1'] == $conn || $activeGame['player2'] == $conn) &&
                $activeGame['currentRound'] >= 9) {
                $gameToDelete = &$activeGame;
                break;
            }
            if ($activeGame['player1'] == $conn) {
                $activeGame['player2']->send("playerLeft");
                $gameToDelete = &$activeGame;
                break;
            }
            else if ($activeGame['player2'] == $conn) {
                $activeGame['player1']->send("playerLeft");
                $gameToDelete = &$activeGame;
                break;
            }
        }

        if (isset($gameToDelete))
            unset($gameToDelete);

        unset($this->users[$conn->resourceId]);

        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}