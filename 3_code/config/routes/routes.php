<?php 

// Define the routes with the controller
$routes = [
    "/" => "BaseController::index",
    "/all" => "BaseController::getData",
    "/filtered/{id}" => "BaseController::getDataFiltered",
    "/create" => "BaseController::createData",
    "/update/{id}" => "BaseController::updateData",
    "/delete/{id}" => "BaseController::deleteData"
];
