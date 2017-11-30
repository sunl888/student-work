<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginFailed;
use HttpException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Cache;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web')->only('logout');
    }
    // 验证码
    public function captcha(){
        return response()->json(['src' => captcha_src()]);
    }
    public function getUser()
    {
        return Auth::user();
    }

    public function needVerificationCodeRequest(Request $request)
    {
        return [
            'need' => $this->needVerificationCode($request->ip())
        ];
    }
    /**
     * 是否需要验证码
     * @return bool
     */
    protected function needVerificationCode($ip)
    {
        $key = $this->getAttemptLoginTimesKey($ip);
        if (!Cache::has($key)) {
            return false;
        }
        $times = Cache::get($key);
        return $times > config('students.need_not_verification_code_times', 5);
    }
    protected function getAttemptLoginTimesKey($ip)
    {
        return 'attempt_login_times:' . $ip;
    }
    protected function addAttemptLoginTimes($ip)
    {
        $key = $this->getAttemptLoginTimesKey($ip);
        $cacheTime = config('students.not_verification_code_time_interval', 60 * 12);
        if (Cache::has($key)) {
            Cache::increment($key);
        } else {
            Cache::put($key, 1, $cacheTime);
        }
    }
    
    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        throw new HttpException(423, "请在 $seconds 秒后重试。");
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $ip = $request->ip();
        $this->addAttemptLoginTimes($ip);
        if ($this->needVerificationCode($ip)) {
            // 验证码
            $this->validate($request, [
                'captcha' => 'required|captcha'
            ],[
                'captcha.required' => '验证码必须填写',
                'captcha.captcha' => '验证码错误'
            ]);
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->response->noContent();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return $this->response->noContent();
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw new LoginFailed('登录失败！请检查用户名和密码是否输入正确。');
    }
}