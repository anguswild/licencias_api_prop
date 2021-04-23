<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends ApiController
{
    public function __construct(){
        $this->middleware('client.credentials')->only(['store']);
        $this->middleware('auth:api')->except(['store', 'login']);
    }

    public $successStatus = 200;

    public function login()
    {
        if (Auth::attempt(['username' => request('username'), 'password' => request('password')])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('Token_ws');
            $success['token'] =  $tokenResult->accessToken;
            $success['token_type'] = 'Bearer';

            $success['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();

            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        
        $success['name'] =  $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function index()
    {
        $usuarios = User::all(); 
        return $this->showAll($usuarios, 200);
    }

    public function show(User $usuario)
    {
        return $this->showOne($usuario);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Error de Validación'
            ];
            return response()->json($response, 404);
        }

        $data['password'] = bcrypt($data['password']);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        
        return $this->showOne($user, 201);
    }
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return $this->showOne($usuario);
    }
}
