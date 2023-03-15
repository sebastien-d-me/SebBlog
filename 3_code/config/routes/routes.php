<?php 

// Define the routes with the controller
$routes = [
    "/" => "BaseController::index",
    "/all" => "BaseController::getData",
    "/filtered" => "BaseController::getDataFiltered",
    "/create" => "BaseController::createData",
    "/update" => "BaseController::updateData",
    "/delete" => "BaseController::deleteData"
];
