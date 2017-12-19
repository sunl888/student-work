<?php

namespace App\Providers;

use App\Models\TaskProgress;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        if (app()->environment() !== 'production') {
            \DB::listen(
                function ($query) {
                    \Log::info(
                        'sql', [$query->sql
                            , $query->bindings
                            , $query->time]
                    );
                }
            );
        }
        \Carbon\Carbon::setLocale('zh');
        /**
         * 如果你现在运行的 MySQL 版本低于 5.7.7（或者低于 10.2.2 版本的 MariaDB），需要手动配置迁移命令生成的默认字符串长度，以便 MySQL 为它们创建索引。
         */
        Schema::defaultStringLength(191);

        // 验证用户是否存在
        Validator::extend('users', function ($attribute, $value, $parameters, $validator) {
            $validate = explode(',', $value);
            if (array_first($validate) == TaskProgress::$personnelSign) {
                return true;
            } elseif (count($validate) == 1) {
                $user = User::find(array_first($validate));
                if ($user) {
                    return true;
                }
            } elseif (count($validate) > 1) {
                $users = User::whereIn('id', $validate)->get();
                if ($users->count() == count($validate)) {
                    return true;
                }
            }
            return false;
        });
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
                        'message' => '你还没有登陆^_^'
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
                            ? '没有权限' : $exception->getMessage()
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
                        'message' => strpos($exception->getMessage(), "No query results") ? $exception->getMessage() : 'Not Found',
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
    }
}
