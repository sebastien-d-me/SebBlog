<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    // Parameters
    protected $table = "member";
    public $timestamps = false;

    protected $primaryKey = "idMember";
    protected $fillable = ["idMember", "registrationDate", "isActive", "idRole", "idLoginCredentials"];

    // Getter
    public function getIdMember() {
        return $this->idMember;
    }

    public function getRegistrationDate() {
        return $this->registrationDate;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getIdRole() {
        return $this->idRole;
    }

    public function getIdLoginCredentials() {
        return $this->idLoginCredentials;
    }

    // Setter
    public function setIdMember($idMember) {
        $this->idMember = $idMember;
        return $this;
    }

    public function setRegistrationDate($registrationDate) {
        $this->registrationDate = $registrationDate;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setIdRole($idRole) {
        $this->idRole = $idRole;
        return $this;
    }

    public function setIdLoginCredentials($idLoginCredentials) {
        $this->idLoginCredentials = $idLoginCredentials;
        return $this;
    }
}