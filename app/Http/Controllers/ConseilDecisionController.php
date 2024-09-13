<?php

namespace App\Http\Controllers;


use App\Models\ConseilDecision;
use Illuminate\Http\Request;

class ConseilDecisionController extends Controller
{
    public function index()
    {
        $decisions = ConseilDecision::all();
        return response()->json($decisions);
    }

    public function show($id)
    {
        $decision = ConseilDecision::findOrFail($id);
        return response()->json($decision);
    }

    public function store(Request $request)
    {
        $decision = ConseilDecision::create($request->validate(['name' => 'required|string|max:255']));
        return response()->json($decision, 201);
    }

    public function update(Request $request, $id)
    {
        $decision = ConseilDecision::findOrFail($id);
        $decision->update($request->validate(['name' => 'required|string|max:255']));
        return response()->json($decision);
    }

    public function destroy($id)
    {
        $decision = ConseilDecision::findOrFail($id);
        $decision->delete();
        return response()->json(null, 204);
    }
}

