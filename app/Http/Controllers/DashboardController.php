<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   
    public function index()
    {
        // Récupérer tous les chèques entrants et sortants triés par création descendante
        $cheques = Cheque::whereIn('type', ['entrant', 'sortant'])
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard', compact('cheques'));
    }

}

