<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Cheque;

class TraiteController extends Controller
{
    public function imprimer(Cheque $cheque)
    {
        if ($cheque->type !== 'sortant') {
            abort(403, 'Seuls les chèques sortants peuvent être imprimés.');
        }

        $pdf = Pdf::loadView('cheques.traite_pdf', compact('cheque'));

        return $pdf->download("traite_cheque_{$cheque->numero}.pdf");
    }
}
