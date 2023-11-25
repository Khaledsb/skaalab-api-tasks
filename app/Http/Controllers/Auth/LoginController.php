<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function __handle(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new Exception('user not found');
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new Exception('Wrong credentials');
        }

        return $user->createToken('customer')->plainTextToken;
    }

    public function __invoke(LoginRequest $request)
    {
        $data = $request->validated();

        try {
           $response = $this->__handle($data);

           return response()->json([
                'token' => $response,
                'code' => Response::HTTP_OK
           ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        }
    }
}
