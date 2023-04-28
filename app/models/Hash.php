<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Hash extends Model {
    // Parameters
    protected $table = "hash";
    public $timestamps = false;

    protected $primaryKey = "idHash";
    protected $fillable = ["idHash", "hash", "isActive", "idMember"];

    // Getter
    public function getIdHash(): int {
        return $this->idHash;
    }

    public function getHash(): string {
        return $this->hash;
    }

    public function getIsActive(): string {
        return $this->isActive;
    }

    public function getIdMember(): string {
        return $this->idMember;
    }

    // Setter
    public function setHash(string $hash): string {
        $this->hash = password_hash($hash, PASSWORD_DEFAULT);
        return $this;
    }

    public function setIsActive(string $isActive): string {
        $this->isActive = $isActive;
        return $this;
    }

    public function setIdMember(string $idMember): string {
        $this->idMember = $idMember;
        return $this;
    }
}