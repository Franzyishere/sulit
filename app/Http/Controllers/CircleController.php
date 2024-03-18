<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Circle;
use Tymon\JWTAuth\Facades\JWTAuth;

class CircleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

        public function create_circle(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'circle_name' => 'required',
        ]);

        // Jika validasi gagal, kirim respons 400 Bad Request
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Verifikasi token JWT
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid token',
            ], 402);
        }

        // Jika token JWT tidak valid atau pengguna tidak ditemukan, kirim respons 401 Unauthorized
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: User not found',
            ], 401);
        }

        // Buat circle baru
        $circle = Circle::create([
            'circle_name' => $request->circle_name,
            'creator_circle' => $user->id,
        ]);

        // Jika circle berhasil dibuat, kirim respons 200 OK
        if ($circle) {
            return response()->json([
                'success' => true,
                'message' => 'Circle created successfully',
                'data' => $circle,
            ], 200);
        } else {
            // Jika terjadi kesalahan internal server, kirim respons 500 Internal Server Error
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }
        public function get_circle(Request $request)
    {
        $circles = Circle::all();

        // Jika berhasil mendapatkan daftar circle, kirim respons 200 OK
        if ($circles) {
            return response()->json([
                'success' => true,
                'message' => 'Circle retrieved successfully',
                'data' => $circles,
            ], 200);
        } else {
            // Jika terjadi kesalahan internal server, kirim respons 500 Internal Server Error
            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }
}
