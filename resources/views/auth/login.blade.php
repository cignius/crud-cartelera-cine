@extends('layouts.app')

@section('content')
    <section class="body">
        <div class="container-fluid g-0">
            <div class="login-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="logo">
                            Inicio de sesión
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <br>
                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" placeholder="Correo electrónico"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" placeholder="Contraseña" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="password" value="{{ old('password') }}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {!! Captcha::img() !!}
                                <input type="text" id="captcha" class="form-control mt-2 @error('captcha') is-invalid @enderror" name="captcha"
                                    placeholder="Escriba el captcha" required>
                                @error('captcha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group text-end">
                                <button class="btn btn-primary btn-block" type="submit">Iniciar sesión</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6 hide-on-mobile">
                        <div id="demo" class="carousel slide" data-bs-ride="carousel">
                            <!-- Indicators -->
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"
                                    aria-current="true"></button>
                                <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            </div>
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="slider-feature-card">
                                        <img src="https://i.imgur.com/YMn8Xo1.png" alt="">
                                        <h3 class="slider-title">Title Here</h3>
                                        <p class="slider-description">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Iure, odio!</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="slider-feature-card">
                                        <img src="https://i.imgur.com/Yi5KXKM.png" alt="">
                                        <h3 class="slider-title">Title Here</h3>
                                        <p class="slider-description">Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Ratione, debitis?</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Left and right controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#demo"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#demo"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
