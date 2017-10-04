# 学生事务工作进程监控系统

## 环境要求
- PHP >= 7.0
-  MySQL >= 5.6
-  Node.js

## 开始安装
从 [github](https://github.com/wqer1019/student-work.git) 克隆本项目
```shell
# from github clone this project.
git clone https://github.com/wqer1019/student-work.git
```
composer
```shell
cd student-work
composer install
```
安装前端依赖
```npm
npm install
```
编译前端资源
```npm
npm run dev
```
配置
```php
# 修改.env里面的数据库信息
cp .env.example .env
```
生成密钥
```php
php artisan key:generate
```
创建数据库并填充测试数据
```php
php artisan migrate --seed
```

## UML模型
<p align="center">
  <img style="max-width:50%" src="https://github.com/wqer1019/student-work/blob/master/public/design_chart.png">
  <br>
</p>

## License

The project is open-sourced software licensed under the [MIT license](https://mit-license.org/).

