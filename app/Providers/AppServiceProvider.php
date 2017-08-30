<?php

namespace App\Providers;

use HttpException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * 如果你现在运行的 MySQL 版本低于 5.7.7（或者低于 10.2.2 版本的 MariaDB），需要手动配置迁移命令生成的默认字符串长度，以便 MySQL 为它们创建索引。
         */
        \DB::listen(
            function ($query) {
                \Log::info(
                    'sql', [$query->sql
                        , $query->bindings
                        , $query->time]
                );
            }
        );
        \Carbon\Carbon::setLocale('zh');
        Schema::defaultStringLength(191);
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
        $this->registerDingoApiExceptionHandler();
    }

    public function registerDingoApiExceptionHandler()
    {
        // 自定义异常响应
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
                        'message' => $exception->getMessage()
                    ], 404
                );
            }
        );
        // 验证
        $apiHandler->register(
            function (ValidationException $exception) {
                return response(
                    [
                        'status_code' => 422,
                        'code' => 422,
                        'message' => $exception->validator->errors()
                    ], 422
                );
            }
        );
        $apiHandler->register(
            function (QueryException $exception) {
                if ($this->app->environment() !== 'production') {
                    throw $exception;
                } else {
                    throw new HttpException(500);
                }
            }
        );
        $apiHandler->register(
        // Zizaco/entrust没有权限会抛出这个异常
            function (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
                return response([
                    'status_code' => 403,
                    'code' => 403,
                    'message' => '对不起，你没有操作权限'
                ], 403);

            }
        );
    }
}
