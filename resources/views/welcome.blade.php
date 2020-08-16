@extends('layouts.app')
@section('title')
Twitter Log in
@endsection
@section('content')
<div>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col col-md-8">
                <form action="{{ route('user-login') }}" method="post">
                    @csrf
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" name="username" id="" class="form-control">
                                    </div>
                                </div>
                                 <div class="col">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" name="password" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            @if(session('flash'))
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-info text-center">
                                            <small>{{ session('flash') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(session('red'))
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-danger text-center">
                                        <small>{{ session('red') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="row">
                                <div class="col text-left">
                                    <small>Not yet signed up? <a href="/register">Signup Here</a></small>
                                </div>
                                <div class="col col-md-3 text-right">
                                    <button class="btn-primary btn btn-block">Log in</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection