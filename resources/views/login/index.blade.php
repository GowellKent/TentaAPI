@extends('layout/main')
@section('container')
    <div class="row justify-content-center">
        <div class="col-md-5">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissable fade show" role="alert">
                    {{ session('success') }}
                    {{-- <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="close"></button> --}}
                </div>
            @endif

            @if (session()->has('loginError'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        {{-- <span aria-hidden="true">&times;</span> --}}
                    </button>
                </div>
            @endif
        </div>
    </div>

    <main class="form-signin w-100 m-auto">
        <form action="/login" method="post">
            @csrf
            <h1 class="h3 mb-3 fw-normal"><strong>Login</strong></h1>
            <div class="form-floating">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    id="floatingInput" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                <label for="floatingInput">Email address</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password"
                    required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary green" type="submit">Login <i
                    class="bi bi-box-arrow-in-right"></i></button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022–2023</p>
        </form>
    </main>
@endsection
