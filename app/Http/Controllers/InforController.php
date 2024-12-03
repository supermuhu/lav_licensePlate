<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InforController extends Controller
{
    public function infor()
    {
        $cities = City::all();
        return view('user/information/getInfor', compact('cities'));
    }
    public function postInfor(Request $request)
    {
        if (User::where('phone', $request->phone)->exists()) {
            return response()->json([
                'data' => null,
                'message' => 'Số điện thoại đã được sử dụng!',
                'status' => 400,
            ]);
        }
        $request->session()->put('phone', $request->phone);
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->city_id = $request->city;
        $otp = rand(10000, 99999);
        $request->session()->put('otp', $otp);
        $user->otp = $otp;
        $user->expired = time() + 60 * 5;
        $user->save();
        $request->session()->put('message', 'Gửi mã OTP thành công');
        return response()->json([
            'data' => null,
            'message' => 'Lưu người dùng thành công',
            'status' => 500,
        ]);
    }
    public function verifyOtp(Request $request)
    {
        $otp = session('otp');
        return view('user/information/verifyOtp', compact('otp'));
    }
    public function postVerifyOtp(Request $request)
    {
        $phone = $request->session()->get('phone');
        $user = User::where('phone', $phone)->first();
        $otp = $request->otp;
        if (!empty($user) && $user->otp == $otp) {
            if ($user->expired < time()) {
                $request->session()->put('error', 'Mã OTP đã hết hạn');
                return back();
                // return redirect()->route('user.changeOtp');
            }
            $user->phone_verified_at = Carbon::now();
            $user->save();
            Auth::login($user, true);
            $request->session()->put('message', 'Xác thực thành công');
            return redirect('/');
        }
    }
    public function changeOtp(Request $request){
        $phone = $request->session()->get('phone');
        $otp = rand(10000, 99999);
        $expired = time() + 5*60;
        $user = User::where('phone', $phone)->first();
        $user->otp = $otp;
        $user->expired = $expired;
        $user->save();
        $request->session()->put('otp', $otp);
        $request->session()->put('message', 'Gửi lại mã OTP thành công');
        return redirect()->route('user.verifyOtp');
    }
}
