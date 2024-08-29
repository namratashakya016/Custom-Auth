<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QRCode;
use Illuminate\Validation\ValidationException;

class QRCodeController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id', // Ensure user ID exists in the users table
                'data' => 'required|string|max:255',
            ]);

            // Optional: Check for existing record
            if (QRCode::where('user_id', $validated['user_id'])->where('data', $validated['data'])->first()) {
                return response()->json(['message' => 'QR code with this data already exists for this user.'], 409);
            }

            // Store the data in the database
            QRCode::create([
                'user_id' => $validated['user_id'],
                'data' => $validated['data'],
            ]);

            return response()->json(['message' => 'Data stored successfully'], 201);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
