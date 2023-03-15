<?php

// Namespace
namespace App\Models;

// Load Capsule
use Illuminate\Database\Capsule\Manager as Capsule;

class Base {
    // All
    public static function getAll() {
        return Capsule::table("test")->get();
    }

    // Filtered
    public static function getBy($column, $value) {
        return Capsule::table("test")->where($column, $value)->get();
    }

    // Create
    public static function create($data) {
        Capsule::table("test")->insert([
            "fullName" => $data["fullName"],
            "mail" => $data["mail"]
        ]);
    }

    // Update
    public static function update($id, $data) {
        Capsule::table("test")->where("idTest", $id)->update([
            "fullName" => $data["fullName"],
            "mail" => $data["mail"]
        ]);
    }

    // Delete
    public static function delete($id) {
        Capsule::table("test")->where("idTest", $id)->delete();
    }
}