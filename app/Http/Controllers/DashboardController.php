<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   
   
    public function index(Request $request)
    {
        $cheques = Cheque::query()
            ->whereIn('type', ['entrant', 'sortant'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('numero', 'LIKE', "%{$search}%")
                      ->orWhere('montant', 'LIKE', "%{$search}%")
                      ->orWhere('tiers', 'LIKE', "%{$search}%")
                      ->orWhere('banque', 'LIKE', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query()); // ✅ garde les paramètres dans la pagination
    
        $nbNotifsNonLues = Notification::where('is_read', false)->count();
    
        return view('dashboard', compact('cheques', 'nbNotifsNonLues'));
    }
    



}

