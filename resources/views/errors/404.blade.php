@extends('layouts.app')
@section('title', 'Page Not Found')

@section('content')
    <div class="text-center mt-5">
        <h1>404</h1>
        <p>The page you are looking for could not be found.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
    </div>
@endsection
