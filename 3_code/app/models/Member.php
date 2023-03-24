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
    protected $fillable = ["idMember", "firstname", "lastname", "registrationDate", "updatedDate", "lastLoginDate", "isActive", "idRole", "idLoginCredentials"];

    // Getter
    public function getIdMember() {
        return $this->idMember;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getRegistrationDate() {
        return $this->registrationDate;
    }

    public function getUpdatedDate() {
        return $this->updatedDate;
    }

    public function getLastLoginDate() {
        return $this->lastLoginDate;
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

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    public function setRegistrationDate($registrationDate) {
        $this->registrationDate = $registrationDate;
        return $this;
    }

    public function setUpdatedDate($updatedDate) {
        $this->updatedDate = $updatedDate;
        return $this;
    }

    public function setLastLoginDate($lastLoginDate) {
        $this->lastLoginDate = $lastLoginDate;
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