@extends('layouts.user')
@section('content')
<link rel="stylesheet" href="{{ asset(path: 'css/styleuser.css') }} ">
<div class="container">
    <form method="GET" action="{{ route('user.search') }}">
        <input type="text" name="query" id="searhbarmenu" placeholder="Search by title or category" class="form-control mb-3">
        <h2 class="text-start text-small fw-bold customtext" id="customheader">Available Books</h2>
    </form>
    <div class="row">
        @foreach($books as $book)
        <div class="col-md-3">
            <div class="card mb-4">
                @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="{{ $book->name }}">
                @else
                <img src="{{ asset('images/default-cover.jpg') }}" class="card-img-top" alt="Default Cover">
                @endif
                <div class="card-body " style="width: 15.9rem; height: 15.9rem;">
                    <h5 class="card-title titletext">{{ $book->name }}</h5>
                    <p class="card-text " id="customauthortext">Author: {{ $book->auther->name }}</p>
                    <p class="card-text " id="customcategorytext">Category: {{ $book->category->name }}</p>
                    <form action="{{ route('user.borrow', $book) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-sm btn-primary">Borrow</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection