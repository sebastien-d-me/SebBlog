<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class LoginCredentials extends Model {
    // Parameters
    protected $table = "logincredentials";
    public $timestamps = false;

    protected $primaryKey = "idLoginCredentials";
    protected $fillable = ["idLoginCredentials", "username", "email", "password", "idMember"];

    // Getter
    public function getIdLoginCredentials() {
        return $this->idLoginCredentials;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getIdMember() {
        return $this->idMember;
    }

    // Setter
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function setIdMember($idMember) {
        $this->idMember = $idMember;
        return $this;
    }
}