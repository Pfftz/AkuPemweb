@extends('layouts.app')
@section('content')
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">Add Book</h2>
            </div>
            <div class="offset-md-7 col-md-2">
                <a class="add-new" href="{{ route('books.index') }}">All Books</a>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <form class="yourform" action="{{ route('books.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label>Book Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Book Name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <select class="form-control @error('author_id') is-invalid @enderror" name="author_id" required>
                            <option value="">Select Author</option>
                            @foreach ($authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                        @error('author_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Publisher</label>
                        <select class="form-control @error('publisher_id') is-invalid @enderror" name="publisher_id" required>
                            <option value="">Select Publisher</option>
                            @foreach ($publishers as $publisher)
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                            @endforeach
                        </select>
                        @error('publisher_id')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Cover Image</label>
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" name="cover_image">
                        @error('cover_image')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" name="save" class="btn btn-danger" value="Save">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection