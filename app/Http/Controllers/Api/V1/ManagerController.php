<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Http\Resources\V1\ManagerCollection;
use App\Http\Resources\V1\ManagerResource;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managers = Manager::all();
        return new ManagerCollection($managers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Manager $manager)
    {
        return new ManagerResource($manager);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $manager)
    {
        $message = "Manager supprimé aves succès";
        $type = "success";

        //laravel permet de supprimer un objet directement de la bdd
        try {
            $manager = Manager::findOrFail($manager);
            $manager->delete();
        } catch (\Throwable $th) {
            $message = "Ce manager n'existe pas";
            $type = "danger";
        }

        // toast : système de notification vue.js
        return response()->json([
            'toast' => [
                'message' => $message,
                'type' => $type
            ]
        ]);
    }
}
