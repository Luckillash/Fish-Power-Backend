<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

use App\Models\User;

class UserController extends Controller
{

    public function register(Request $request): JsonResponse
    {

        try {

            $request -> validate([

                'name' => 'required|string',

                'email' => 'required|email|unique:users,email',

                'password' => 'required|string|min:6',

            ]);

            $user = User::create([

                'name' => $request -> name,

                'email' => $request -> email,

                'password' => Hash::make($request -> password),

            ]);

            return response() -> json(['message' => 'User registered successfully', 'user' => $user], 201);
        
        } catch (ValidationException $e) {

            return response() -> json(['error' => $e -> validator -> errors()], 422);

        } catch (\Exception $e) {

            return response() -> json(['error' => 'Registration failed. Please try again.'], 500);
        
        }

    }

    public function authenticate(Request $request): JsonResponse
    {

        $credentials = $request -> validate([
            
            'email' => ['required', 'email'], 
            
            'password' => ['required']
        
        ]);

        if (Auth::attempt($credentials)) {

            $request -> session() -> regenerate();

            /** @var \App\Models\User $user **/
            $user = Auth::user();

            $token = $user -> createToken('AuthToken') -> plainTextToken;

            return response() -> json(['token' => $token], 200);

        } else {

            return response() -> json(['error' => 'Invalid credentials'], 401);

        }

    }

    public function isAuthenticated(Request $request): JsonResponse
    {

        if (Auth::check()) {

            $request -> session() -> regenerate();

            /** @var \App\Models\User $user **/
            $user = Auth::user();

            $token = $user -> createToken('AuthToken') -> plainTextToken;

            return response() -> json(['token' => $token], 200);

        } else {

            return response() -> json(['error' => 'Invalid credentials'], 401);

        }

    }

    public function logout(Request $request): JsonResponse
    {

        Auth::logout();
    
        $request->session()->invalidate();

        $request->session()->regenerateToken();
    
        // // Eliminar cookies de sesión
        $request->session()->flush();

        $request->session()->regenerate();
    
        return response() -> json(['status' => 'logout'], 200);

    }

    public function user() {

        $user = Auth::user();

        if(!is_null($user)){

            return response() -> json(['user' => $user], 200);
        
        } else {

            return response() -> json(['error' => 'Invalid credentials'], 401);

        }

    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        try {

            $dbconnect = DB::connection()->getPDO();

            $dbname = DB::connection()->getDatabaseName();

            return response($dbname, 200);

        } catch(\Exception $e) {

            return response($e, 500);

        }

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
    public function store(Request $request): JsonResponse
    {

        try {

            $request->validate([

                'name' => 'required|string',

                'email' => 'required|email|unique:users,email',

                'password' => 'required|string|min:6',

            ]);

            $user = User::create([

                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),

            ]);

            return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
        
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->validator->errors()], 422);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Registration failed. Please try again.'], 500);
        
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, User $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $product)
    {
        //
    }

}
