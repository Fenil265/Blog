<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $data = Blogs::with(['category', 'user'])->orderBy('id', 'desc')->get();
        return response($data, 200);
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
     * @return JsonResponse|string
     */
    public function store(Request $request): JsonResponse|string
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:blogs|max:255',
            'category_id' => 'required|numeric|min:0|not_in:0',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => false,
                'message' => $validator->errors()->first(),
            ];
            return response()->json($data);
        }

        $validated = $request->all();
        $validated['user_id'] = Auth::user()->id;

        $data = Blogs::create($validated);

        $data = [
            'data' => $data,
            'status' => true,
            'message' => 'List fetched successfully',
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $data = Blogs::with('category')->where('id', $id)->first();
        return \response($data, 200);
    }

    /**
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request): Response
    {
        $data = Blogs::where('id', $id)->update($request->all());
        return \response($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Blogs $blogs
     * @return Response
     */
    public function update(Request $request, Blogs $blogs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $data = Blogs::find($id)->delete();
            return \response()->json([
                'data' => $data,
                'message' => "logged out!",
                'status' => true
            ], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
