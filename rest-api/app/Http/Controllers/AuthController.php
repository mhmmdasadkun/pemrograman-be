<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validateData = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if (Auth::attempt($validateData)) {
                $token = Auth::user()->createToken('auth_token');

                $data = [
                    'message' => 'Login berhasil',
                    'token' => $token->plainTextToken
                ];

                return response()->json($data, 200);
            } else {
                $data = ['message' => 'Username atau password salah!'];
                return response()->json($data, 401);
            }
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menambahkan murid'], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required',
                'email' => 'email|required|unique:users,email',
                'password' => 'required'
            ]);
            $validateData['password'] = Hash::make($validateData['password']);

            $user = User::create($validateData);

            $data = [
                'message' => 'User berhasil ditambahkan!',
                'data' => $user
            ];

            return response()->json($data, 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menambahkan murid'], 500);
        }
    }
}
