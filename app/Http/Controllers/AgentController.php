<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Property;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(): View
    {
        $agents = Agent::where('is_active', true)
            ->withCount(['properties' => fn($q) => $q->published()])
            ->orderBy('sort_order')
            ->paginate(12);

        return view('agents.index', compact('agents'));
    }

    public function show(string $slug): View
    {
        $agent = Agent::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $properties = Property::with(['city', 'images', 'propertyType'])
            ->published()
            ->where('agent_id', $agent->id)
            ->latest('published_at')
            ->paginate(9);

        return view('agents.show', compact('agent', 'properties'));
    }
}
