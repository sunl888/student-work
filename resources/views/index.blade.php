<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="renderer" content="webkit"> 
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">
    <title>淮南师范学院学生事务进程考核系统</title>
    <style type="text/css">
        body, html{
            width: 100%;
            height: 100%;
        }
    	.browsehappy{
            width: 100%;
            height: 100%;
    		position: fixed;
    		font-size: 18px;
    		margin-top: -18px;
            padding: 25% 30%;
            color: #444;
            background: rgba(255, 255, 255, 0.7);
            z-index: 9999;
    	}
        .link{
            color: #20a0ff;
        }
        .link:hover{
            color: #20a0ff;
            text-decoration: underline;
        }
        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url(../../fonts/iconfont/MaterialIcons-Regular.eot); /* For IE6-8 */
            src: local('Material Icons'),
            local('MaterialIcons-Regular'),
            url(../../fonts/iconfont/MaterialIcons-Regular.woff2) format('woff2'),
            url(../../fonts/iconfont/MaterialIcons-Regular.woff) format('woff'),
            url(../../fonts/iconfont/MaterialIcons-Regular.ttf) format('truetype');
        }

        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px; /* Preferred icon size */
            display: inline-block;
            width: 1em;
            height: 1em;
            line-height: 1;
            text-transform: none;

            /* Support for all WebKit browsers. */
            -webkit-font-smoothing: antialiased;
            /* Support for Safari and Chrome. */
            text-rendering: optimizeLegibility;

            /* Support for Firefox. */
            -moz-osx-font-smoothing: grayscale;

            /* Support for IE. */
            font-feature-settings: 'liga';
        }
    </style>

</head>
<body>
    <!--[if lt IE 10]>
    <p class="browsehappy">
      你正在使用一个<strong>过时</strong>的浏览器。请<a class="link" href="http://browsehappy.com">升级你的浏览器</a>以查看此页面。
    </p>
    <![endif]-->
    <div id="app"></div>

    <script src="{{asset(mix('js/main.js'))}}"></script>
</body>
</html>
