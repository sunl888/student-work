<?php

namespace App\Providers;

use Dingo\Api\Exception\ValidationHttpException;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    public function registerDingoApiExceptionHandler()
    {
        $apiHandler = app('Dingo\Api\Exception\Handler');
        $apiHandler->register(
            function (\Illuminate\Auth\AuthenticationException $exception) {
                return response(
                    [
                        'status_code' => 401,
                        'code' => 401.1,
                        'message' => trans('auth.please_login_first')
                    ], 401
                );
            }
        );
        $apiHandler->register(
            function (\Illuminate\Auth\Access\AuthorizationException $exception) {
                return response(
                    [
                        'status_code' => 401,
                        'code' => 401.3,
                        'message' => $exception->getMessage() == 'This action is unauthorized.' || empty($exception->getMessage())
                            ? trans('auth.no_permission') : $exception->getMessage()
                    ], 401
                );
            }
        );
        $apiHandler->register(
            function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
                return response(
                    [
                        'status_code' => 404,
                        'code' => 404,
                        //todo 这里的错误显示需要处理
                        'message' => $exception->getMessage()
                    ], 404
                );
            }
        );
        $apiHandler->register(
            function (ValidationException $exception) {
                throw new ValidationHttpException($exception->validator->errors());
            }
        );
        $apiHandler->register(
            function (QueryException $exception) {
                if ($this->app->environment() !== 'production') {
                    //throw new HttpException(500, $exception->getSql());
                    throw $exception;
                } else {
                    // todo log
                    throw new HttpException(500);
                }
            }
        );
    }
}
