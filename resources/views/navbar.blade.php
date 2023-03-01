<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand navbar-expand-sm navbar-dark bg-dark sticky-top">
    <div class="collapse navbar-collapse justify-content-between m-auto" id="navbarNav"
         style="max-width: 80%!important;">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('blog.index')}}">Home</a>
            </li>
            {{--<li class="nav-item">
                <a class="nav-link" href="#">Chat</a>
            </li>--}}
            <li class="nav-item logged">
                <a class="nav-link" href="{{route('user.login')}}">Login</a>
            </li>
            <li class="nav-item myBlogs">
                <a href="{{route('user.blogs')}}" type="button" class="nav-link">My Blogs</a>
            </li>
        </ul>
        <div class="logoutWrapper">
            <a type="button" class="btn btn-primary" onclick="logoutUser()">Logout</a>
        </div>
    </div>
</nav>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        let logged = localStorage.getItem('logged');
        if (logged) {
            $('.logged').hide();
            $('.myBlogs').show();
        } else {
            $('.logoutWrapper').hide();
            $('.myBlogs').hide();

        }
    });

    function logoutUser() {
        const formData = {};

        $.ajax({
            type: 'POST',
            url: '/api/user/logout',
            data: formData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('SavedToken'));
            },
            success: function (data) {
                if (data.status === false || data.status === "Authorization Token not found") {
                    let errorHtml = '<div class="alert alert-danger errorBlock" role="alert"> ' + data.message + ' </div>';
                    $('.formContent').prepend(errorHtml);
                    window.location.href = "/";
                } else {
                    $('.logoutWrapper').hide();
                    localStorage.removeItem("SavedToken");
                    localStorage.removeItem("logged");
                    window.location.href = "/";
                }

            }, error: function (jqXHR) {
                const err = eval("(" + jqXHR.responseText + ")");
                console.log(err);
                let errorHtml = '<div class="alert alert-danger errorBlock" role="alert"> ' + err.error + ' </div>';
                $('.formContent').prepend(errorHtml);
                $('.errorBlock').delay(3000).fadeOut();
            }
        });
    }
</script>
