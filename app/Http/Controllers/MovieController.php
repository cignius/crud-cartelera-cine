<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovie;
use App\Http\Requests\UpdateMovie;
use App\Models\Movie;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::orderBy('id', 'desc')->paginate(10);
        return view('movie.index', ['movies' => $movies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMovie $request)
    {
        $validated = $request->validated();
        $token = substr(sha1(time()), 0, 40);
        $validated['token'] = $token;
        //Format timestamp 
        $validated['start_exhibition'] = date("Y:m:d H:i:s", strtotime($validated['start_exhibition']));
        //Finish at date 59:59:59
        $validated['finish_exhibition'] = date("Y:m:d H:i:s", strtotime('+23 hours', strtotime('+59 minutes', strtotime('+59 seconds', strtotime($validated['finish_exhibition'])))));
        $validated['status'] = $this->checkStatus($validated['start_exhibition'], $validated['finish_exhibition']);

        /*$info = [
            'start' => $validated['start_exhibition'],
            'finish' => $validated['finish_exhibition'],
            'status' => $validated['status'],
            'now' => new \DateTime()
        ];
        dd($info);
        */
        try {
            $newMovie = Movie::create($validated);
        } catch (\Exception $e) {

            Log::channel('movie')->error('Create', ['data' => $validated, 'Failure' => $e]);
            return response()->json([
                "type" => 'error',
                "message" => 'Por el momento no podemos registrar la pelicula, intenta de nuevo más tarde',
            ], 500);
        }
        return $this->storeImage($request, $newMovie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMovie $request, Movie $movie)
    {
        $validated = $request->validated();
        $disk = Storage::disk('movies');
        //Format timestamp 
        $validated['start_exhibition'] = date("Y:m:d H:i:s", strtotime($validated['start_exhibition']));
        //Finish at date 59:59:59
        $validated['finish_exhibition'] = date("Y:m:d H:i:s", strtotime('+23 hours', strtotime('+59 minutes', strtotime('+59 seconds', strtotime($validated['finish_exhibition'])))));
        $validated['status'] = $this->checkStatus($validated['start_exhibition'], $validated['finish_exhibition']);

        if (isset($validated['image'])) {
            if (isset($movie->image)) {
                $disk->delete($movie->image);
            }
            try {
                //get extension
                $imageExtension = $request->image->extension();
                //random value
                $randomvalue = substr(sha1(time()), 0, 40);
                //rename image
                $image = "{$randomvalue}.{$imageExtension}";
                //storage
                $disk = Storage::disk('movies');
                //use same path disk
                $disk->putFileAs('', $request->image, $image);
                //update value
                $validated['image'] = $image;
            } catch (\Exception $e) {
                // Manejar el error y revertir si es necesario
                return $this->handleErrorAndRollback($e, $movie);
            }
        }
        
        $movie->update($validated);
        //session(['status' => 'Registro creado con éxito']);

        return response()->json([
            "type" => 'success',
            "message" => 'Actualización exitosa',
            "extra" => url("movies/{$movie->image}"),
            "action" => 'update'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {

        $disk = Storage::disk('movies');
        $disk->delete($movie->image);
        $movie->delete();
        return back()->with('status', 'Se ha eliminado la película');
    }

    private function storeImage($request, $movie)
    {
        try {
            //get extension
            $imageExtension = $request->image->extension();
            //random value
            $randomvalue = substr(sha1(time()), 0, 40);
            //rename image
            $image = "{$randomvalue}.{$imageExtension}";
            //storage
            $disk = Storage::disk('movies');
            //use same path disk
            $disk->putFileAs('', $request->image, $image);
            //update value
            $movie->update(['image' => $image]);

            session(['status' => 'Registro creado con éxito']);

            return response()->json([
                "type" => 'success',
                "message" => 'Registro exitoso',
                "extra" => '',
                "action" => 'create'
            ], 200);
        } catch (\Exception $e) {
            // Manejar el error y revertir si es necesario
            return $this->handleErrorAndRollback($e, $movie);
        }
    }

    private function handleErrorAndRollback($error, $movie)
    {
        if ($movie) {
            $movie->delete();
        }

        Log::channel('movie')->error('Create', ['data' => $movie, 'Failure' => $error]);

        return response()->json([
            "type" => 'error',
            "message" => 'Por el momento no podemos registrar la pelicula, intenta de nuevo más tarde',
        ], 500);
    }

    private function checkStatus($start_date, $finish_date)
    {
        $now = new \DateTime();
        $status = "";

        if ($now < $start_date) {
           $status = 'Preestreno';
        } elseif ($now >= $start_date && $now <= $finish_date) {
           $status = 'En cartelera';
        } elseif ($now > $finish_date) {
           $status = 'Fuera de cartelera';
        }

        return $status;
    }
}
