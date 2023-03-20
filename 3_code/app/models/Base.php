<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Base extends Model {
    // Parameters
    protected $table = "";
    public $timestamps = false;

    protected $primaryKey = "";
    protected $fillable = [""];

    // Getter
    public function getAbc() {
        return $this->abc;
    }

    public function getDef() {
        return $this->def;
    }

    // Setter
    public function setDef($def) {
        $this->def = $def;
        return $this;
    }
}