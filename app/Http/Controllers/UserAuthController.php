<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class UserAuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);
        Auth::guard("web")->login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]));

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return ["token"=>$token];
    }
    public function login(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $resArr = [];
        $resArr['token'] = $user->createToken('api-application')->accessToken;
        $resArr['name'] = $user->name;

        return response()->json($resArr, 200);

        }else {
            return response()->json(['error' => 'User Not found']);
        }
    }
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        Auth::guard('web')->logout();
        $res = ['message'=>'you have logged out successfully'];
        return response()->json($res,200);
    }
    public function updatePassword(Request $request){
        $request->validate([
            "new_password"=>"required|confirmed|string|min:8",
            "old_password"=>"required"
        ]);
        // dd(Hash::check($request->old_password,Auth::user()->password));
        if (!Hash::check($request->old_password,Auth::user()->password)) {
            return response()->json(["meesage"=>"Current password entered is incorrect"],403);
        }else{
            $user = User::where(["email"=>Auth::user()->email])->first();


            $user->update(["password"=>Hash::make($request->new_password)]);

            $token = $request->user()->token();
            $token->revoke();
            Auth::guard('web')->logout();
            return response()->json(["message"=>"Password changed successfully you have to login again"],200);
        }
    }
    public function resetPassword(Request $request){
        $request->validate([
            'email'=>"required|exists:users,email"
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                ? response()->json(['status' =>"Password reset email sent successfully"],200)
                : response()->json(['email' =>"Check Your Email"],200);
    }
    public function resetPasswordFront(Request $request){
        $token = $request->token;
        $email = $request->email;
        return view("passwordReset",compact('token','email'));
    }
    public function changePassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return "password reset succssfully";
    }
}
