<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <form method="post" action="{{url('api/upload')}}" enctype="multipart/form-data" >
                    <input type="file" name="file">
                    <img src="{{asset('storage/2017/08/23/7b439HDZvATAyVYZpcQwinXKjKL1aFpN6C9DznYf.png')}}" />
                    <button type="submit"> 提交 </button>
                </form>
            </div>
        </div>
    </body>
</html>
