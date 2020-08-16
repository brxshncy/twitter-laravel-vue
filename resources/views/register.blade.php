@extends('layouts.app')
@section('title')
Register
@endsection
@section('content')
<div>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col col-md-8">
                <div class="card mt-5">
                <form action="{{ route('register')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">First Name</label>
                                    <input type="text" name="fname" id="" class="form-control">
                                </div>
                            </div>
                             <div class="col">
                                <div class="form-group">
                                    <label for="">Last Name</label>
                                    <input type="text" name="lname" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <input type="text" name="address" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Birthdate</label>
                                    <input type="date" name="bday" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Contact</label>
                                    <input type="numbert" name="contact" id="" class="form-control">
                                </div>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col text-left">
                            </div>
                            <div class="col col-md-3 text-right">
                                <button class="btn-primary btn btn-block">Register</button>
                            </div>
                        </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection