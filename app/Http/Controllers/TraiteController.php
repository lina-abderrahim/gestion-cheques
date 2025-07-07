<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Cheque;
use App\Models\Traite;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TraiteController extends Controller
{
public function imprimer(Cheque $cheque)
{
    if ($cheque->type !== 'sortant') {
        abort(403, 'Seuls les chèques sortants peuvent être imprimés.');
    }

    // 1. Générer le PDF
    $pdf = Pdf::loadView('cheques.traite_pdf', compact('cheque'));

    // 2. Nom + chemin
    $nomFichier = 'traite_cheque_' . $cheque->numero . '_' . now()->format('Ymd_His') . '.pdf';
    $chemin = 'traites/' . $nomFichier;

    // 3. Sauvegarde du PDF
    Storage::put($chemin, $pdf->output());

    // 4. Mise à jour ou création de la traite
    Traite::updateOrCreate(
        ['cheque_id' => $cheque->id],
        [
            'date_impression' => Carbon::now(),
            'fichier_pdf' => $chemin,
        ]
    );

    // 5. Télécharger le PDF
    return $pdf->download($nomFichier);
}

}
