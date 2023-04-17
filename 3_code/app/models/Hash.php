<?php

/** Namespace */
namespace App\Models;

/** Load Capsule */
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Hash extends Model {
    /** Parameters */
    protected $table = "hash";
    public $timestamps = false;

    protected $primaryKey = "idHash";
    protected $fillable = ["idHash", "hash", "isActive", "idMember"];

    /** Getter */
    public function getIdHash() {
        return $this->idHash;
    }

    public function getHash() {
        return $this->hash;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getIdMember() {
        return $this->idMember;
    }

    /** Setter */
    public function setHash($hash) {
        $this->hash = password_hash($hash, PASSWORD_DEFAULT);
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setIdMember($idMember) {
        $this->idMember = $idMember;
        return $this;
    }
}