@include('navbar')

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
<style>
    .card {
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
    }

    a {
        text-decoration: none;
    }

    /*.card .card-text {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        line-height: 2; !* fallback *!
        min-height: 100px;
        color: #555;
    }*/

    .card .card-title {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
</style>
<div class="text-center loader" style="height: 100vh; line-height: 100vh;">
    <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="row-fluid d-none blogsWrapper">
    <div class="container">
        <div class="row mt-5 content">
            <div class="col mb-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                            the
                            card's
                            content.</p>
                        <a href="#" class="card-link edit-link">Edit</a>
                        <a type="button" class="card-link delete-link" onclick="deleteBlog()">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>

<script>
    $(document).ready(function () {
        getBlogs();
    });

    function getBlogs() {
        $.ajax({
            type: 'GET',
            url: '/api/blog/' + {{request()->route('id')}},
            dataType: "json",
            success: function (data) {
                if (data) {
                    $('.card-title').html(data.title);
                    $('.card-subtitle').html('Category: ' + data.category.name);
                    $('.card-text').html(data.content);
                    $('.edit-link').attr('href', "{{route('user.blogs.edit', ['id' => request()->route('id')])}}");
                }

                $('.loader').delay(100).hide(function () {
                    $('.blogsWrapper').removeClass('d-none').fadeIn(400);
                });
            }
        });
    }

    function deleteBlog() {
        $.ajax({
            type: 'DELETE',
            url: '/api/user/blog/delete/' + {{request()->route('id')}},
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('SavedToken'));
            },
            success: function (data) {
                window.location.href = "/user/blogs";
                $('.loader').delay(100).hide(function () {
                    $('.blogsWrapper').removeClass('d-none').fadeIn(400);
                });
            }
        });
    }
</script>

</body>
</html>
