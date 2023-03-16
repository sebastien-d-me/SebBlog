<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Base extends Model {
    // Parameters
    protected $table = "test";
    public $timestamps = false;

    protected $primaryKey = "idTest";
    protected $fillable = ["fullName", "mail"];

    // Getter
    public function getIdTest() {
        return $this->idTest;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getMail() {
        return $this->mail;
    }

    // Setter
    public function setFullName($fullName) {
        $this->fullName = $fullName;
        return $this;
    }

    public function setMail($mail) {
        $this->mail = $mail;
        return $this;
    }
}