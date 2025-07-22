@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title mb-4 h4 text-success">Logowanie</h1>
                    @if(session('status'))
                        <div class="alert alert-info">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Hasło</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 form-check ms-1">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label for="remember_me" class="form-check-label">Zapamiętaj mnie</label>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center mt-2 gap-2 flex-wrap">
                            <div>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-underline small" href="{{ route('password.request') }}">Nie pamiętasz hasła?</a>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">Zarejestruj się</a>
                                <button class="btn btn-success px-4" type="submit">Zaloguj się</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
