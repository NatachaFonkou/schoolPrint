<?php

namespace App\Http\Controllers;


use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::all();
        return response()->json($options);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);
        $option = Option::create($data);
        return response()->json($option, 201);
    }

    public function show($id)
    {
        $option = Option::findOrFail($id);
        return response()->json($option);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);
        $option = Option::findOrFail($id);
        $option->update($data);
        return response()->json($option);
    }

    public function destroy($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
        return response()->json(null, 204);
    }
}

