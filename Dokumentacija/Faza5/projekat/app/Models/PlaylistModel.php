<?php


namespace App\Models;

use CodeIgniter\Model;

class PlaylistModel extends Model
{
    protected $table      = 'playlist';
    protected $primaryKey = 'idP';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['idP','difficulty', 'genre', 'number'];

    public function getIdOfMinNumOfGenre($genre) {

        $playlists = $this->where("genre", $genre)->findAll();
        $idP = $playlists[0]->idP;
        $minNum = $playlists[0]->number;
        foreach($playlists as $playlist) {
            if ($playlist->number < $minNum) {
                $idP = $playlist->idP;
                $minNum = $playlist->number;
            }
        }

        return $idP;
    }
}