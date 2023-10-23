<?php

namespace App\Http\Controllers\api;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::select('title',
        'director',
        'duration',
        'classification',
        'image',
        'start_exhibition',
        'finish_exhibition',
        'token',
        'status')
        ->orderBy('id', 'desc')
        ->paginate(10);
        $movies->getCollection()->map(function ($movie) {
            $movie->image = url('movies/' . $movie->image);
            return $movie;
        });
        return response()->json($movies);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $movie = Movie::where('token', $token)->first();

        if (is_null($movie)) {
            return Response()->json([
                "type" => 'error',
                "message" => "Pelicula no encontrada"
            ], 404);
        } else {
            return response()->json([
                'title' => $movie->title,
                'director' => $movie->director,
                'duration' => $movie->duration,
                'classification' => $movie->classification,
                'image' => url("movies/{$movie->image}"),
                'start_exhibition' => $movie->start_exhibition,
                'finish_exhibition' => $movie->finish_exhibition,
                'status' => $movie->status,
                'token' => $movie->token
            ]);
        }
    }
}
