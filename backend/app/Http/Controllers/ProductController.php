<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductConllection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use App\Model\Role_id;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\JWTAuth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show',
            'store','update', 'destroy', 'upfile','booksame', 'showTicket']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Return ProductConllection::collection(Product::all());
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
//        $role = $request->role_id;
//        if($role === 1) {
        $product = new Product;
        $product->name = $request->name;
        $product->detail = $request->description;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->author =$request->author;
        $product->translator = $request->translator;
        $product->company = $request->company;
        $product->content = $request->contents;
        $product->pushlisher = $request->pushlisher;
        $product->categories_id = $request->category_id;
        $product->save();
        //dd($request->all());
        if ($request->hasFile('image'))
        {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $file->move(public_path('img'), $picture);
            $product->img = url('/') . '/img/' .$picture;
            $product->save();
            return response()->json(["message" => "Image Uploaded Succesfully"]);
        }
        else
        {
            $product->img = 'http://localhost:8000/img/171215-11623_p17985.jpg';
            $product->save();
            return response()->json(["message" => "Select image first."]);
        }
        return response([
             new ProductResource($product)
        ],Response::HTTP_CREATED);
//        } else {
//            return response()->json(['error' => 'Không có quyền này!'], Response::HTTP_UNAUTHORIZED);
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

            $data = Product::where('slug', $slug)->first();
            if ($data) {
                return new ProductResource($data);
            } else {
                return response()->json(['error' => 'Không có dữ liệu'], Response::HTTP_NOT_FOUND);
            }

    }
    public function showTicket($id)
    {
        $data = Product::where('id', $id)->first();
        if($data) {
            return new ProductResource($data);
        }
        else {
            return response()->json(['error' => 'Không có dữ liệu'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
//        $user = Auth::user();
//        $role = Role_id::where('user_id', $user->id)->get('role_id');
//        if($role === 1) {
        $product = Product::where('slug', $slug)->first();
        $product->name = $request->name;
        $product->detail = $request->description;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->author =$request->author;
        $product->translator = $request->translator;
        $product->company = $request->company;
        $product->content = $request->contents;
        $product->pushlisher = $request->pushlisher;
        $product->categories_id = $request->categories_id;
        unset($request['description']);
        $product->update();
        return response([
            'data' => new ProductResource($product)
        ],Response::HTTP_CREATED);
//        } else {
//            return response()->json(['error' => 'Không có quyền này!'], Response::HTTP_UNAUTHORIZED);
//        }

    }
    public function upfile(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();
//        dd($product);
        if ($request->hasFile('img'))
        {
            $oldfile = $product->img;
            $file      = $request->file('img');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $file->move(public_path('img'), $picture);
            $url = url('/') . '/img/' .$picture;
            $product->img = $url;
            $product->update();
//            if($oldfile) {
//                unlink($oldfile);
//            }
            return response()->json(["message" => "Cập nhật ảnh thành công"]);
        }
        else {
            return response()->json(["message" => "Select image first."]);
        }
    }
    // Danh sách sách liên quan
    public function booksame($slug)
    {

        $data = Product::where('slug', $slug)->first();
        $data1 = Product::where('categories_id', $data->categories_id)->get();
        if ($data1) {
            return ProductConllection::collection($data1);
        } else {
            return response()->json(['error' => 'Không có dữ liệu'], Response::HTTP_NOT_FOUND);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();
        $role = Role_id::where('user_id', $user->id)->get('role_id');
        if($role === 1) {
        return $product;
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
        } else {
            return response()->json(['error' => 'Không có quyền này!'], Response::HTTP_UNAUTHORIZED);
        }
    }

    //check User
    public function  ProductUserCheck($product)
    {
        if(Auth::id() !== $product->user_id)
        {
            throw new ProductNotBelongsToUser;
        }

    }
}
