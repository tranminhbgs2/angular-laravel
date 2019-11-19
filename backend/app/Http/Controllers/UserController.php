<?php

namespace App\Http\Controllers;

use App\Http\Resources\Customer\CustomerConllection;
use App\Http\Resources\Customer\CustomerResource;
use App\Model\Role_id;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'store','update', 'destroy', 'uploadfile']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CustomerConllection::collection(User::all());
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
            $customer = new User;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->password = $request->password;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->gender = $request->gender;
            $customer->save();
            $customer->ma_customer = 'SV' . $customer->id;
            $customer->save();
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture = date('His') . '-' . $filename;
                $file->move(public_path('avatar'), $picture);
                $customer->avatar = url('/') . '/avatar/' . $picture;
                $customer->save();
                return response()->json(["message" => "Image Uploaded Succesfully"]);
            } else {
                return response()->json(["message" => "Select image first."]);
            }
            return response([
                'data' => new CustomerResource($customer)
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = User::where('ma_customer', $slug)->first();
        if($data) {
            return new CustomerResource($data);
        }
        else {
            return response()->json(['error' => 'User không tồn tại'], Response::HTTP_NOT_FOUND);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = User::where('ma_customer', $id)->first();
        if($request->password_old){
            $pass = $customer->password;
            $data = $request->all();
            if(Hash::check($data['password'], $pass)){
                return response()->json(['error' => 'Mật khẩu mới không được giống mật khẩu cũ!']);
            }
            elseif(Hash::check($data['password_old'], $pass)) {
                $customer->password = $request->password;
                $customer->update();
                return response([
                    'data' => 'Thay đổi mật khẩu thành công!'
                ], Response::HTTP_CREATED);
            }
            else
            return response()->json(['error' => 'Mật khẩu cũ không đúng!']);
        }
        else {
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->gender = $request->gender;
            $customer->story = $request->story;
            $customer->update();
            {
                return response([
                    'data' => new CustomerResource($customer)
                ], Response::HTTP_CREATED);
            }
        }

    }
    //Update File
    public  function uploadfile(Request $request, $slug) {
        $customer = User::where('ma_customer', $slug)->first();
        if ($request->hasFile('avatar'))
        {
            $oldfile = $customer->avatar;
            $file      = $request->file('avatar');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $file->move(public_path('avatar'), $picture);
            $customer->avatar = url('/') . '/avatar/' .$picture;
            $customer->update();
//            if($oldfile) {
//                unlink($oldfile);
//            }
            return response()->json(["message" => "Cập nhật ảnh thành công"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Model\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        $customer->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}
