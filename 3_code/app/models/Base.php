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
    protected $fillable = ["username", "mail", "password"];

    // Getter
    public function getIdTest() {
        return $this->idTest;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getPassword() {
        return $this->password;
    }

    // Setter
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setMail($mail) {
        $this->mail = $mail;
        return $this;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }
}