<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreManagerRequest;
use App\Http\Requests\V1\UpdateManagerRequest;
use App\Models\Manager;
use App\Http\Resources\V1\ManagerCollection;
use App\Http\Resources\V1\ManagerResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * store
     *
     * @param  StoreManagerRequest $request
     * @return JsonResource
     */
    public function store(StoreManagerRequest $request): JsonResource
    {
        $data = $request->validated();
        return new ManagerResource(Manager::create($data));
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
    public function update(UpdateManagerRequest $request, Manager $manager) : JsonResource
    {
        $manager->update($request->validated());
        return new ManagerResource($manager);
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
