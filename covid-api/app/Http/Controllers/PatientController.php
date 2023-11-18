<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{

    // Private function mencegah perulangan function
    private function patientValidate(Request $request, $id = null)
    {
        return $request->validate([
            'status_id' => 'required|numeric',
            'name' => 'required',
            'phone' => [
                'required',
                'numeric',
                Rule::unique('patients')->ignore($id),
            ],
            'address' => 'required',
            'in_date_at' => 'required|date_format:Y-m-d',
            'out_date_at' => 'required|date_format:Y-m-d',
        ]);
    }

    private function patientsRes($patient)
    {
        return [
            'id' => $patient->id,
            'name' => $patient->name,
            'phone' => $patient->phone,
            'address' => $patient->address,
            'in_date_at' => $patient->in_date_at,
            'out_date_at' => $patient->out_date_at,
            'status' => [
                'status_id' => $patient->status_id,
                'status_name' => $patient->status->name,
            ],
            'created_at' => $patient->created_at,
            'updated_at' => $patient->updated_at,
        ];
    }

    // Function menampilkan semua pasien
    public function index(Request $request)
    {
        try {
            $patients = Patient::filterAndSort($request)->get();

            if ($patients->isEmpty()) { // Kalau data kosong
                $message = $request->filled('name') || $request->filled('address') || $request->filled('status')
                    ? 'Data pasien yang anda maksud tidak ditemukan!'
                    : 'Mohon maaf saat ini kami tidak memiliki data pasien.';

                return response()->json(['message' => $message], 404);
            }

            $patients = $patients->map(function ($patient) {
                return $this->patientsRes($patient);
            });

            $message = $request->filled('name') || $request->filled('address') || $request->filled('status') || $request->filled('sort')
                ? 'Menampilkan filter pasien'
                : 'Menampilkan semua data pasien';

            $data = [
                'message' => $message,
                'data' => $patients->toArray()
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menampilkan data pasien'], 500);
        }
    }

    // Function tambah pasien
    public function store(Request $request)
    {
        try {
            $validate = $this->patientValidate($request);
            $patient = Patient::with('status')->create($validate);

            $data = [
                'message' => 'Data pasien berhasil ditambahkan!',
                'data' => $this->patientsRes($patient)
            ];

            return response()->json($data, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menambahkan data pasien'], 500);
        }
    }

    // Function detail pasien
    public function show(string $id)
    {
        try {
            $patient = Patient::find($id);
            if (!$patient) {
                return response()->json(['message' => 'Data pasien yang anda maksud tidak ditemukan!'], 404);
            }

            $data = [
                'message' => 'Menampilkan detail data pasien',
                'data' => $this->patientsRes($patient)
            ];

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menampilkan detail data pasien'], 500);
        }
    }

    // Function update pasien
    public function update(Request $request, string $id)
    {
        try {
            $patient = Patient::find($id);
            if (!$patient) {
                return response()->json(['message' => 'Data pasien yang anda maksud tidak ditemukan!'], 404);
            }

            $validate = $this->patientValidate($request, $id);

            $input = [
                'status_id' => $validate['status_id'] ?? $patient->status_id,
                'name' => $validate['name'] ?? $patient->name,
                'phone' => $validate['phone'] ?? $patient->phone,
                'address' => $validate['address'] ?? $patient->address,
                'in_date_at' => $validate['in_date_at'] ?? $patient->in_date_at,
                'out_date_at' => $validate['out_date_at'] ?? $patient->out_date_at
            ];

            $patient->update($input);

            $data = [
                'message' => 'Data pasien berhasil diperbarui!',
                'data' => $this->patientsRes($patient)
            ];

            return response()->json($data, 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengubah data pasien'], 500);
        }
    }

    // Function delete pasien
    public function destroy(string $id)
    {
        try {
            $patient = Patient::find($id);
            if (!$patient) {
                return response()->json(['message' => 'Data pasien yang anda maksud tidak ditemukan!'], 404);
            }

            $patient->delete();

            $data = ['message' => 'Data pasien berhasil dihapus!'];
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data pasien'], 500);
        }
    }
}
