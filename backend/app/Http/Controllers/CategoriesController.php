<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\CategoriesResource;
use App\Http\Resources\Product\CategoryConllection;
use App\Model\Categories;
use App\Model\Role_id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'store','update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Return CategoryConllection::collection(Categories::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $user = Auth::user();
        $role = $request->role_id;
        if($role === 1) {
        $category = new Categories;
        $category->title = $request->title;
        $category->save();
        return response([
            'data' => new CategoriesResource($category)
        ],Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => 'Không có quyền này!'], Response::HTTP_UNAUTHORIZED);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = Categories::where('slug', $slug)->first();
        if($data) {
            return new CategoriesResource($data);
        }
        else {
            return response()->json(['error' => 'Không có dữ liệu'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
//        $user = Auth::user();
        $role_id = $request->role_id;
        if($role_id === 1) {
        $data = Categories::where('slug', $slug)->first();
        $data->update($request->all());
        return response([
            'data' => new CategoriesResource($data)
        ],Response::HTTP_CREATED);
        } else {
            return response()->json(['error' => 'Không có quyền này!'], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Model\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $categories = Categories::destroy($id);
        return response( null, Response::HTTP_NO_CONTENT);

    }
}
