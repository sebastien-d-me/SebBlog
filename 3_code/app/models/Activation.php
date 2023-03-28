<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model {
    // Parameters
    protected $table = "activation";
    public $timestamps = false;

    protected $primaryKey = "idActivation";
    protected $fillable = ["idActivation", "hash", "idMember"];

    // Getter
    public function getIdActivation() {
        return $this->idActivation;
    }

    public function getHash() {
        return $this->hash;
    }

    public function getIdMember() {
        return $this->idMember;
    }

    // Setter
    public function setHash($hash) {
        $this->hash = password_hash($hash, PASSWORD_DEFAULT);
        return $this;
    }

    public function setIdMember($idMember) {
        $this->idMember = $idMember;
        return $this;
    }
}