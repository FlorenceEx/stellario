<?php

namespace App\Observers;

use App\Models\Manager;
use App\Http\Services\FileService;

class ManagerObserver
{

    /**
     * seeders
     *
     * @var array
     */
    public array $seeders = [
        'public/star.png',
        'public/face-1.png',
        'public/face-2.png',
        'public/face-3.png',
        'public/face-4.png',
        'public/face-5.png',
    ];

    /**
     * Handle the Manager "created" event.
     */
    public function created(Manager $manager): void
    {
        $face = json_decode($manager->face);
        if (!$face || !in_array($face->origin, $this->seeders)) {
            $path = 'public/star.png';
            $manager->update(['face' => json_decode(FileService::jsonMetadata($path))]);
        }
    }

    /**
     * Handle the Manager before "updated" event.
     */
    public function updating(Manager $manager): void
    {
        $_manager = Manager::find($manager->id);
        $face = json_decode($_manager->face);

        $face && $this->deleteSafelyFace($face->origin);
    }

    /**
     * Handle the Manager "deleted" event.
     */
    public function deleted(Manager $manager): void
    {
        $face = json_decode($manager->face);
        $face && $this->deleteSafelyFace($face->origin);
    }

    /**
     * deleteSafelyFace
     *
     * @param  mixed $face
     * @return void
     */
    public function deleteSafelyFace(string $face): void
    {
        // Delete old image if it's not the defaults seeders data
        if (!in_array($face, $this->seeders)) {
            FileService::delete($face);
        }
    }
}
