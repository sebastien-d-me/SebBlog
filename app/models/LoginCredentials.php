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
    public function getIdLoginCredentials(): int {
        return $this->idLoginCredentials;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getIdMember(): string {
        return $this->idMember;
    }

    // Setter
    public function setUsername(string $username): string {
        $this->username = $username;
        return $this;
    }

    public function setEmail(string $email): string {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): string {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    public function setIdMember(string $idMember): string {
        $this->idMember = $idMember;
        return $this;
    }
}