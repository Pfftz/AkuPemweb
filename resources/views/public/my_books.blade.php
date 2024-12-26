@extends('layouts.user')
@section('content')
<div class="container">
    <h2 class="mybookstitle">My Borrowed Books</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($bookIssues->isEmpty())
    <p class="bookspara">You have not borrowed any books.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Book Name</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookIssues as $bookIssue)
            <tr>
                <td>{{ $bookIssue->book->name }}</td>
                <td>{{ $bookIssue->issue_date->format('d M, Y') }}</td>
                <td>{{ $bookIssue->return_date->format('d M, Y') }}</td>
                <td>
                    @if($bookIssue->issue_status == 'Y')
                    Returned
                    @else
                    Borrowed
                    @endif
                </td>
                <td>
                    @if($bookIssue->issue_status == 'N')
                    <form action="{{ route('user.return', $bookIssue->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Return</button>
                    </form>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection