@extends('layouts.app')
@section('title')
Home / Twitter
@endsection
@section('content')
<div id="app">
    <main-component user_id="{{Auth::guard('twitterUser')->user()->id}}" user="{{ Auth::guard('twitterUser')->user()->fname." ".Auth::guard('twitterUser')->user()->lname }}"></main-component>
</div>
<script src="{{mix('js/app.js')}}"></script>
@endsection