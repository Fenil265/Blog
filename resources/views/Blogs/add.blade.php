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

    <style>
        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
<div class="text-center loader d-none" style="height: 100vh; line-height: 100vh;">
    <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="row-fluid blogsWrapper">
    <div class="container">
        <div class="row mt-5 content">
            <form class="w-50 m-auto formContent">
                <div class="form-group">
                    <label for="blogTitle">Title</label>
                    <input type="text" class="form-control" id="blogTitle"
                           placeholder="Enter Blog Title">
                </div>
                <div class="form-group">
                    <label for="blogCategory">Category</label>
                    <select class="form-control" id="blogCategory">
                    </select>
                </div>
                <div class="form-group">
                    <label for="blogContent">Content</label>
                    <textarea class="form-control" id="blogContent" rows="3"></textarea>
                </div>
                <div class="form-group text-end">
                    <button type="button" class="btn btn-success btn" id="submitBlog" onclick="addBlog()">Add Blog
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>

<script>
    $(document).ready(function () {
        getCategories();
    });

    function addBlog() {
        const formData = {
            title: $('#blogTitle').val(),
            category_id: $('#blogCategory').find(":selected").val(),
            content: $('#blogContent').val()
        };

        $.ajax({
            type: 'POST',
            url: '/api/user/blog/add',
            data: formData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('SavedToken'));
            },
            success: function (data) {
                if (data.status === true) {
                    let dataHtml = '<option value="0">Select Category</option>';
                    $.each(data, function (index, value) {
                        dataHtml += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    $('#blogCategory').html(dataHtml);
                    $('.loader').delay(3000).hide(function () {
                        window.location.href = "/user/blogs";
                    });
                } else {
                    let errorHtml = '<div class="alert alert-danger errorBlock" role="alert"> ' + data.message + ' </div>';
                    $('.blogsWrapper .formContent').prepend(errorHtml);
                    $('.errorBlock').delay(3000).fadeOut();
                }


            }, error: function (jqXHR) {
                const err = eval("(" + jqXHR.responseText + ")");
                let errorHtml = '<div class="alert alert-danger errorBlock" role="alert"> ' + err.message + ' </div>';
                $('.blogsWrapper .formContent').prepend(errorHtml);
                $('.errorBlock').delay(3000).fadeOut();
            }
        });
    }

    function getCategories() {
        $.ajax({
            type: 'GET',
            url: '/api/categories',
            dataType: "json",
            success: function (data) {
                if (data) {
                    let dataHtml = '<option value="0">Select Category</option>';
                    $.each(data, function (index, value) {
                        dataHtml += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    $('#blogCategory').html(dataHtml);
                }

                $('.loader').delay(100).hide(function () {
                    $('.blogsWrapper').removeClass('d-none').fadeIn(400);
                });
            }
        });
    }
</script>

</body>
</html>
