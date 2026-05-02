<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    // 2️⃣ Google callback
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $fullName = $googleUser->getName(); // "Ahmad Ullah Mukhlis"
            $nameParts = explode(' ', $fullName, 2);
            $raw = $googleUser->user;

            $firstName = $raw['given_name']  ?? $nameParts[0] ?? '';
            $lastName  = $raw['family_name']  ?? ($nameParts[1] ?? '');
            //just the password for the test because the admin must not change the password
            if ($googleUser->getEmail() != "ahmadullahmukhlis2025@gmail.com" || $googleUser->getEmail() != "ahmadullahmukhlis2019@gmail.com") {
                $password = bcrypt('Afghan@123');
            } else {
                $password = bcrypt(Str::random(16));
            }
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'image' => $googleUser->getAvatar(),
                    'is_active' => true,
                    'is_verified' => true,
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'password'   => $password,
                ]
            );

            $token = $user->createToken('flutter')->plainTextToken;

            return redirect()->to(
                'myapp://login?token=' . urlencode($token)
            );
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->to('myapp://login?error=google_failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
