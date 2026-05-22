<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function usuariosPDF()
    {
        // 🔥 CAMBIO: cliente -> usuarios
        $usuarios = DB::table('usuarios')->get();

        // 🔥 GENERAR PDF
        $pdf = Pdf::loadView('cpanel.reportes.pdf', compact('usuarios'));

        // 🔥 MOSTRAR PDF EN NAVEGADOR
        return $pdf->stream('usuarios.pdf');
    }
}
