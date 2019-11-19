<?php
namespace App\Http\Controllers;
use App\Model\Role_id;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\User;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signup', 'respondWithToken']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email hoặc mật khẩu không đúng'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function signup(SignUpRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        $user->ma_customer = 'SV'.$user->id;
        $user->save();
        $user_id = $user->id;
        $role_id = 3;
//        $user_type = 'App\Model\Customer';
        $role = new Role_id();
        $role->role_id = $role_id;
        $role->user_id = $user_id;
//        $role->user_type = $user_type;
        $role->save();
//        User::create($request->all());
//        return $this->login($request);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user()->id;
        $role = Role_id::where('user_id', $user)->first();
        if($role){
            $role_id = $role->role_id;
        }
        else{
            $role_id = 'không';
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user,
            'name' => auth()->user()->name,
            'role_id' => $role_id
        ]);
    }
}
