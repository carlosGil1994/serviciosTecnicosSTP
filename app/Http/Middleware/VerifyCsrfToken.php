<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'Servicios*',
        'Equipos*',
        'Fallas*',
        'Materiales*',
        'Usuarios*',
        'Clientes*',
        'Ordenes*',
        'Actividades*',
        'Especialidades*',
        'Comprobantes*',
        'Acciones*',
        'PagoServicios*'
    ];
}
