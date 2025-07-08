<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Parametre;
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function index()
{
    $parametres = Parametre::all();
    return view('parametres.index', compact('parametres'));
}

public function edit(Parametre $parametre)
{
    return view('parametres.edit', compact('parametre'));
}

public function update(Request $request, Parametre $parametre)
{
    $parametre->update($request->validate([
        'valeur' => 'required|string|max:255',
    ]));

    Log::enregistrer(auth()->id(), 'Mise à jour paramètre', 'parametre', [
        'cle' => $parametre->cle,
        'valeur' => $parametre->valeur
    ]);

    return redirect()->route('parametres.index')->with('success', 'Paramètre mis à jour.');
}

}
