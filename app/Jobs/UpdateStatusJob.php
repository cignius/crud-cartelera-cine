<?php

namespace App\Jobs;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all movies 
        $movies = Movie::whereNotNull('start_exhibition')->whereNotNull('finish_exhibition')->get();

        // Iterates over the movies and updates the "status" field based on the dates.
        foreach ($movies as $movie) {
            $now = new \DateTime();
            if ($now < $movie->start_exhibition) {
                $movie->update(['status' => 'Preestreno']);
            } elseif ($now >= $movie->start_exhibition && $now <= $movie->finish_exhibition) {
                $movie->update(['status' => 'En cartelera']);
            } elseif ($now > $movie->finish_exhibition) {
                $movie->update(['status' => 'Fuera de cartelera']);
            }
        }
    }
}
