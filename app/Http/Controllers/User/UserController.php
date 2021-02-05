<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function register(Request  $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'store' => 'required',
            'category' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Registration Failed.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')-> accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function logout()
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function viewProfile(){
        $user = Auth::user();

        return $this->sendResponse($user, 'User details successfully.');
    }


}
