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
            $validate = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if (Auth::attempt($validate)) {
                $user = Auth::user();
                $token = Auth::user()->createToken('auth_token');

                $data = [
                    'message' => 'Login berhasil!',
                    'data' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                        'token' => $token->plainTextToken
                    ]
                ];

                return response()->json($data, 200);
            } else {
                $data = ['message' => 'Username atau password yang anda masukan salah!'];
                return response()->json($data, 401);
            }
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat melakukan login!'], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required',
                'email' => 'email|required|unique:users,email',
                'password' => 'required'
            ]);
            $validate['password'] = Hash::make($validate['password']);

            $user = User::create($validate);

            $data = [
                'message' => 'User berhasil ditambahkan!',
                'data' => $user
            ];
            return response()->json($data, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat melakukan register!'], 500);
        }
    }
}
