<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Model\ChangePasswordreset;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function process(ChangePasswordRequest $request) {

        return $this->getPasswordResetTableRow($request)->count() > 0 ? $this->changepassword($request): $this->tokenNotFoundResponse();
    }

    private function getPasswordResetTableRow($request) {
        return ChangePasswordreset::where(['email' => $request->email, 'token' => $request->resetToken]);
    }
    private function tokenNotFoundResponse(){
        return response()->json(['error' =>'Token hoặc Email không chính xác'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    private function changepassword($request){
        $user = User::whereEmail($request->email)->first();
        $user->update(['password' =>$request->password]);
        $this->getPasswordResetTableRow($request)->delete();
        return response()->json(['data' => 'Thay đổi mật khẩu thành công'], Response::HTTP_CREATED);
    }
}
