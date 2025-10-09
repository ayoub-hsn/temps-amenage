<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class FileController extends Controller
{
    public function showFile($hashedPath)
    {
        try {
            $decryptedPath = Crypt::decryptString(urldecode($hashedPath));

            // Ensure the file exists in the 'public' folder
            $fullPath = public_path($decryptedPath);
            if (file_exists($fullPath)) {
                return response()->file($fullPath);
            } else {
                abort(404, 'File not found');
            }
        } catch (\Exception $e) {
            abort(400, 'Invalid file request');
        }
    }
}
