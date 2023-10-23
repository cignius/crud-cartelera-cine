@extends('master', ['section' => 'index'])
@section('content')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <a class="btn btn-light-success" href="#" role="button" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Nuevo registro
            </a>
        </div>
    </div>

    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">Titulo</th>
                    <th scope="col" class="text-center">Estatus</th>
                    <th scope="col" class="text-center">Inicio exhibición</th>
                    <th scope="col" class="text-center">Fin exhibición</th>
                    <th scope="col" class="text-center">Fecha registro</th>
                    <th scope="col" class="text-center"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($movies as $movie)
                    <tr>
                        <td class="text-center">{{ $movie->id }}</td>
                        <td class="text-center">{{ $movie->title }}</td>
                        <td class="text-center">{{ $movie->status }}</td>
                        <td class="text-center">{{ $movie->start_exhibition }}</td>
                        <td class="text-center">{{ $movie->finish_exhibition }}</td>
                        <td class="text-center">{{ $movie->created_at }}</td>


                        <td class="text-center">

                            <div class="dropdown">
                                <a class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="#"
                                            data-bs-toggle="modal" data-bs-target="#showModal"
                                            data-url="{{ route('peliculas.show', $movie->id ) }}">
                                            <i class="fa-regular fa-eye"></i>
                                            Ver</a>
                                    </li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-3" href="#"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="{{ $movie->id }}"><i class="fa-solid fa-ban"></i>
                                            Eliminar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $movies->appends([
                'search' => request('search'),
            ])->links() }}
    </div>
    @include('movie.partials.create-modal')
    @include('movie.partials.show-modal')
@endsection
