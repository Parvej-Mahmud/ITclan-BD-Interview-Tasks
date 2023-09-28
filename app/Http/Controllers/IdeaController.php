<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Http\Requests\IdeaRequest;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request)
    {
        $user = auth()->user();

        Idea::create([
            'user_id'      => $user->id,
            'name'         => $request->get('name'),
            'email'        => $request->get('email'),
            'idea'         => $request->get('idea'),
            'participated' => false
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        //
    }
}
