<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\ApiVisitController;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class VisitController extends Controller
{
    public function obtenerDatosDeApi()
    {
        $apiController = new ApiVisitController();

        $coleccionDeDatos = $apiController->index();

        return Inertia::render('Home', [
            'datos' => $coleccionDeDatos
        ]);
    }
}
