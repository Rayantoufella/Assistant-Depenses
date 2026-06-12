<?php

namespace App\Http\Controllers;

use App\Enums\StatutRecu;
use App\Http\Requests\StoreRecuRequest;
use App\Models\Recu;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecuController extends Controller
{
    // Affiche les reçus de l'utilisateur connecté, avec leurs dépenses, du plus récent au plus ancien.
    public function index(): View
    {
        $recus = auth()->user()
            ->recus()
            ->with('depenses')
            ->latest()
            ->get();

        return view('recus.index', compact('recus'));
    }

    // Affiche le formulaire de soumission d'un nouveau reçu.
    public function create(): View
    {
        return view('recus.create');
    }

    // Valide le texte et crée le reçu en attente (l'extraction IA sera déclenchée en synchrone ailleurs, sans queue).
    public function store(StoreRecuRequest $request): RedirectResponse
    {
        Recu::create([
            'user_id' => auth()->id(),
            'texte_source' => $request->validated('texte_source'),
            'statut' => StatutRecu::EnAttente,
        ]);

        return redirect()
            ->route('recus.index')
            ->with('status', 'Reçu enregistré.');
    }

    // Affiche le détail d'un reçu : texte source, statut et dépenses extraites.
    public function show(Recu $recu): View
    {
        $recu->load('depenses');

        return view('recus.show', compact('recu'));
    }

    // Supprime le reçu (ses dépenses partent en cascade via la clé étrangère) puis redirige vers la liste.
    public function destroy(Recu $recu): RedirectResponse
    {
        $recu->delete();

        return redirect()->route('recus.index');
    }
}