<?php

namespace App\Http\Controllers;

use App\Models\student;
use App\Models\User;
use App\Http\Requests\StorestudentRequest;
use App\Http\Requests\UpdatestudentRequest;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.index', [
            'students' => student::Paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    // Store Method
    public function store(StorestudentRequest $request)
    {
        // Extract student-specific fields
        $studentData = $request->only(['name', 'address', 'gender', 'class', 'age', 'phone', 'email', 'username']);
        $student = student::create($studentData);

        // Create corresponding User
        User::create([
            'name' => $student->name,
            'username' => $student->username,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
        ]);

        return redirect()->route('students')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = student::find($id)->first();
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(student $student)
    {
        return view('student.edit', [
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    // Update Method
    public function update(UpdatestudentRequest $request, $id)
    {
        $student = student::findOrFail($id);

        // Extract student-specific fields
        $studentData = $request->only(['name', 'address', 'gender', 'class', 'age', 'phone', 'email']);
        $student->update($studentData);

        // Update User password if provided
        if ($request->filled('password')) {
            $user = User::where('username', $student->username)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        }

        return redirect()->route('students')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        student::find($id)->delete();
        return redirect()->route('students');
    }
}
