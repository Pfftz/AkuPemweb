<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book;
use App\Models\book_issue;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function books()
    {
        $books = book::where('status', 'Y')->get();
        return view('user.books', compact('books'));
    }

    public function borrow(Request $request, book $book)
    {
        if ($book->status != 'Y') {
            return redirect()->back()->with('error', 'Book is not available.');
        }

        // Retrieve the associated student
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'Student profile not found.');
        }

        // Create the book issue record
        book_issue::create([
            'student_id' => $student->id,
            'book_id' => $book->id,
            'issue_date' => now(),
            'return_date' => now()->addDays(14),
            'issue_status' => 'N',
        ]);

        // Update the book's status
        $book->update(['status' => 'N']);

        return redirect()->route('user.home')->with('success', 'Book borrowed successfully.');
    }
    
    public function home()
    {
        $books = book::where('status', 'Y')->get();
        return view('public.homepage', compact('books'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = book::where('name', 'LIKE', "%$query%")
        ->orWhereHas('category', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%$query%");
        })
            ->where('status', 'Y')
            ->get();
        return view('public.homepage', compact('books'));
    }

    public function myBooks()
    {
        // Retrieve the associated student
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'Student profile not found.');
        }

        $bookIssues = book_issue::where('student_id', $student->id)
            ->with('book')
            ->get();

        return view('public.my_books', compact('bookIssues'));
    }

    public function returnBook($id)
    {
        $bookIssue = book_issue::findOrFail($id);

        // Retrieve the authenticated user's associated student
        $student = Auth::user()->student;

        // Update the authorization check
        if (!$student || $bookIssue->student_id != $student->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update the book issue status and return day
        $bookIssue->update([
            'issue_status' => 'Y',
            'return_day' => now(),
        ]);

        // Update the book's availability status
        $bookIssue->book->update(['status' => 'Y']);

        return redirect()->route('user.myBooks')->with('success', 'Book returned successfully.');
    }
}
