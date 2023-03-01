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

    .card .card-text {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        line-height: 2; /* fallback */
        min-height: 100px;
        color: #555;
    }

    .card .card-title {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .card:hover {
        box-shadow: 5px 6px 6px 2px #e9ecef;
        transform: scale(1.02);
        background-color: lemonchiffon;
    }
</style>
<div class="text-center loader" style="height: 80vh; line-height: 80vh;">
    <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="newBlog row-fluid mt-5 d-none">
    <div class="container">
        <div class="mb-5 justify-content-end d-flex">
            <a href="{{route('blogs.add')}}" type="button" class="btn btn-success">Add New Blog</a>
        </div>
    </div>
</div>
<div class="row-fluid mt-5 d-none blogsWrapper">
    <div class="container">
        <div class="row content">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="card-link">Edit</a>
                    <a href="#" class="card-link">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>

<script>
    $(document).ready(function () {
        getUser();
    });

    function getUser() {
        $.ajax({
            type: 'GET',
            url: '/api/user',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('SavedToken'));
            },
            dataType: "json",
            success: function (data) {
                getBlogs(data);

                $('.loader').delay(100).hide(function () {
                    $('.blogsWrapper').removeClass('d-none').fadeIn(400);
                });
            }
        });
    }

    function getBlogs(data) {
        $.ajax({
            type: 'GET',
            url: '/api/user/blogs',
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('SavedToken'));
            },
            success: function (data) {
                if (data) {
                    let dataHtml = '';
                    $.each(data.data, function (index, value) {
                        dataHtml += '<div class="col-12 col-sm-12 col-md-6 col-lg-4  mb-5"><a href="/user/blog/' + value.id + '" target="_self"><div class="card"> <div class="card-body">';
                        dataHtml += '<h5 class="card-title">' + value.title + '</h5>';
                        dataHtml += '<h6 class="card-subtitle mb-2 text-muted"> Category: ' + value.category.name + '</h6>';
                        dataHtml += '<p class="card-text">' + value.content + '</p>';
                        dataHtml += '<p class=""> <b>Author: </b> ' + value.user.name + '</p></div></div></a></div>';

                    });
                    $('.blogsWrapper .content').html(dataHtml);
                }

                $('.loader').delay(100).hide(function () {
                    $('.blogsWrapper, .newBlog').removeClass('d-none').fadeIn(400);
                });
            }
        });
    }
</script>

</body>
</html>
