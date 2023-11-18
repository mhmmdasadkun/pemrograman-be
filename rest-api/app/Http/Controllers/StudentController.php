<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Filtering by name
        if ($request->has('name')) {
            $query->where('nama', 'like', '%' . $request->input('name') . '%');
        }

        // Filtering by major
        if ($request->has('major')) {
            $query->where('jurusan', $request->input('major'));
        }

        // Sorting
        // use localhost:8080/api/students?sort=name&order=asc
        // use localhost:8080/api/students?sort=jurusan&order=desc 
        if ($request->has('sort') && in_array($request->input('sort'), ['nama', 'jurusan'])) {
            $sortField = $request->input('sort');
            $sortOrder = $request->input('order', 'asc');

            $query->orderBy($sortField, $sortOrder);
        }

        // Fetch the results
        $students = $query->get();

        if ($students->isEmpty()) {
            return response()->json(['message' => 'Murid tidak ditemukan'], 404);
        }

        $data = [
            'message' => 'Menampilkan Murid',
            'data' => $students
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'nama' => 'required',
                'nim' => 'numeric|required|unique:students,nim',
                'email' => 'email|required|unique:students,email',
                'jurusan' => 'required'
            ]);

            $student = Student::create($validateData);

            $data = [
                'message' => 'Murid berhasil ditambahkan!',
                'data' => $student
            ];

            return response()->json($data, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menambahkan murid'], 500);
        }
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
        try {
            $student = Student::find($id);
            if (!$student) {
                return response()->json(['message' => 'Murid tidak ditemukan!'], 404);
            }

            $validateData = request()->validate([
                'nama' => 'required',
                'nim' => [
                    'numeric',
                    'required',
                    Rule::unique('students')->ignore($id),
                ],
                'email' => [
                    'email',
                    'required',
                    Rule::unique('students')->ignore($id),
                ],
                'jurusan' => 'required',
            ]);

            $input = [
                'nama' => $validateData['nama'] ?? $student->nama,
                'nim' => $validateData['nim'] ?? $student->nim,
                'email' => $validateData['email'] ?? $student->email,
                'jurusan' => $validateData['jurusan'] ?? $student->jurusan
            ];

            $student->update($input);

            $data = [
                'message' => 'Murid berhasil diubah!',
                'data' => $student
            ];
            return response()->json($data, 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengubah murid'], 500);
        }
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
