@extends('layouts.authLayout.index')

@section('content')
    <div class="row">
        <div class="col">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                </div>
                <form class="user" action="/register" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name"
                            class="form-control form-control-user @error('name') is-invalid @enderror" id="exampleName"
                            placeholder="Name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror"
                            id="exampleInputEmail" placeholder="Email Address" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" name="password"
                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                id="exampleInputPassword" placeholder="Password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                        <div class="col-sm-6">
                            <input type="password" name="password_confirmation"
                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                id="exampleRepeatPassword" placeholder="Repeat Password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Register Account
                    </button>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="/login">Already have an account? Login!</a>
                </div>
            </div>
        </div>
    </div>
@endsection
