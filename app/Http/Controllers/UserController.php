<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                throw new \ErrorException($validator->errors()->first());
            }

            $validator = $request->all();
            $validator['password'] = Hash::make($validator['password']);

            $data = User::create($validator);
            $token = JWTAuth::fromUser($data);

            $data = [
                'data' => $data,
                'status' => true,
                'message' => 'User created successfully',
                'token' => $token
            ];

            return response()->json($data);

        } catch (\Exception $e) {
            $data = [
                'status' => false,
                'message' => $e->getMessage()
            ];

            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('email', 'password');
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(
                    [
                        'error' => 'Please provide valid credentials...!',
                        'status' => false
                    ], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

    }

    public function blogList()
    {
        try {
            $user = Auth::user();
            $data = Blogs::with(['category', 'user'])->where('user_id', $user->id)->orderBy('id', 'desc')->get();

            $data = [
                'data' => $data,
                'status' => true,
                'message' => 'List fetched successfully',
            ];

            return response()->json($data);
        } catch (\Exception $e) {
        }
    }

    public function getAuthenticatedUser()
    {
        try {
            $user = Auth::user();
            return \response()->json([
                'data' => $user,
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

    public function logout()
    {
        try {
            auth()->logout();
            return \response()->json([
                'message' => "logged out!",
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }

}
