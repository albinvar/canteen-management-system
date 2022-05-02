<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Resources\TokenDetailsResource;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterPostRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Propaganistas\LaravelPhone\PhoneNumber;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function login(LoginPostRequest $data): Response|Application|ResponseFactory
    {
        $credentials = $data->validated();

        // gets the validated data from user.
        $validated = $data->validated();

        if (! auth()->attempt($validated)) {
            return response(['ok' => false, 'message' => 'The provided credentials are incorrect.'], 401);
        }

        $accessToken = auth()->user()->createToken('authToken');

        return response(['ok' => true, 'user' => new UserResource(auth()->user()->load(['profile'])), 'access_token' => $accessToken->plainTextToken, 'token_details' => new TokenDetailsResource($accessToken), 'timestamp' => now()], 201);
    }

    public function register(RegisterPostRequest $data): Response|Application|ResponseFactory
    {
        //get the validated data from the request
        $validatedData = $data->validated();

        //convert the password to hash
        $validatedData['password'] = Hash::make($data->password);

        // convert phone field value to an E164 format before storing to DB.
        $validatedData['phone'] = PhoneNumber::make($validatedData['phone'])->formatE164();

        //create a new profile for the user.
        try {
            $profile = Profile::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'] ?? null,
                'phone' => $validatedData['phone'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'user_type' => $validatedData['user_type'] ?? null,
                'department' => $validatedData['department'] ?? null,
                'semester' => $validatedData['semester'] ?? null,
                'division' => $validatedData['division'] ?? null,
                'job_title' => $validatedData['job_title'] ?? null,
            ]);
        } catch (Exception $e) {
            return response(['ok' => false, 'message' => 'Profile could not be created'], 400);
        }

        //assign the created profile to the user
        $validatedData['profile_id'] = $profile->id;

        //automatically set the role to user
        $validatedData['role_id'] = 1;

        //create a new user with the validated data
        try {
            $user = User::create((collect($validatedData))->only(['email', 'password', 'role_id', 'profile_id'])->toArray());
            $accessToken = $user->createToken('authToken');
        } catch (Exception $e) {
            return response(['ok' => false, 'message' => "Registration failed due to a server error"], 400);
        }

        return response(['ok' => true, 'user' => new UserResource($user), 'access_token' => $accessToken->plainTextToken, 'token_details' => new TokenDetailsResource($accessToken), 'timestamp' => now()], 201);
    }


    public function show(): Response|Application|ResponseFactory
    {
        return response(['ok' => true, 'user' => new UserResource(auth()->user()->load(['profile']))], 200);
    }

    /**
     * Logouts a user by deleting the api token.
     *
     * @param Request $request
     *
     * @return Response|Application|ResponseFactory
     */
    public function logout(Request $request): Response|Application|ResponseFactory
    {
        try {
            $request->user()->currentAccessToken()->delete();
        } catch (Exception $e) {
            return response(['ok' => false, 'message' => 'Log-out failed.', 'timestamp' => now()], 400);
        }

        return response(['ok' => true, 'message' => 'Logged out successfully.', 'timestamp' => now()], 200);
    }
}
