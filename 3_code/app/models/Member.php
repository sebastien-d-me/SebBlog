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
    public function getIdMember(): string {
        return $this->idMember;
    }

    public function getRegistrationDate(): string {
        return $this->registrationDate;
    }

    public function getIsActive(): int {
        return $this->isActive;
    }

    public function getIdRole(): int {
        return $this->idRole;
    }

    public function getIdLoginCredentials(): string {
        return $this->idLoginCredentials;
    }

    // Setter
    public function setIdMember(string $idMember): string {
        $this->idMember = $idMember;
        return $this;
    }

    public function setRegistrationDate(string $registrationDate): string {
        $this->registrationDate = $registrationDate;
        return $this;
    }

    public function setIsActive(string $isActive): string {
        $this->isActive = $isActive;
        return $this;
    }

    public function setIdRole(string $idRole): string {
        $this->idRole = $idRole;
        return $this;
    }

    public function setIdLoginCredentials(string $idLoginCredentials): string {
        $this->idLoginCredentials = $idLoginCredentials;
        return $this;
    }
}