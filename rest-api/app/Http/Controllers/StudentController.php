<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        $data = [
            'message' => 'Menampilkan semua murid',
            'data' => $students
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = [
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'jurusan' => $request->jurusan
        ];

        $student = Student::create($input);

        $data = [
            'message' => 'Murid berhasil ditambahkan!',
            'data' => $student
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Murid tidak ditemukan!'], 404);
        }

        $data = [
            'message' => 'Menampilkan detail murid',
            'data' => $student
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Murid tidak ditemukan!'], 404);
        }

        $input = [
            'nama' => $request->nama ?? $student->nama,
            'nim' => $request->nim ?? $student->nim,
            'email' => $request->email ?? $student->email,
            'jurusan' => $request->jurusan ?? $student->jurusan
        ];

        $student->update($input);

        $data = [
            'message' => 'Murid berhasil diubah!',
            'data' => $student
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Murid tidak ditemukan!'], 404);
        }

        $student->delete();
        $students = Student::all();
        $data = [
            'message' => 'Murid berhasil dihapus!',
            'data' => $students
        ];
        return response()->json($data, 200);
    }
}
