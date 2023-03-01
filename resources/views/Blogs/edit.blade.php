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

    .form-group {
        margin-bottom: 1rem;
    }
</style>
<div class="text-center loader" style="height: 90vh; line-height: 90vh;">
    <div class="spinner-grow text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="row-fluid blogsWrapper d-none">
    <div class="container">
        <div class="row mt-5 content">
            <form class="w-50 m-auto formContent">
                <div class="form-group">
                    <label for="blogTitle">Title</label>
                    <input type="text" class="form-control" id="blogTitle"
                           placeholder="Please provide blog title">
                </div>
                <div class="form-group">
                    <label for="blogCategory">Category</label>
                    <select class="form-control" id="blogCategory">
                    </select>
                </div>
                <div class="form-group">
                    <label for="blogContent">Content</label>
                    <textarea class="form-control" id="blogContent" rows="10"></textarea>
                </div>
                <div class="form-group text-end">
                    <button type="button" class="btn btn-success btn" id="submitBlog"
                            onclick="updateBlog();">Update Blog
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

    function getBlogs() {
        $.ajax({
            type: 'GET',
            url: '/api/blog/' + {{request()->route('id')}},
            dataType: "json",
            success: function (data) {
                if (data) {
                    $('#blogTitle').val(data.title);
                    $('#blogCategory').val(data.category.id).change();
                    $('#blogContent').val(data.content);
                }

                $('.loader').delay(100).hide(function () {
                    $('.blogsWrapper').removeClass('d-none').fadeIn(400);
                });
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
                    getBlogs();
                }

                $('.loader').delay(100).hide(function () {
                    $('.blogsWrapper').removeClass('d-none').fadeIn(400);
                });
            }
        });
    }

    function updateBlog() {
        const formData = {
            title: $('#blogTitle').val(),
            category_id: $('#blogCategory').find(":selected").val(),
            content: $('#blogContent').val()
        };

        $.ajax({
            type: 'PUT',
            url: '/api/user/blog/update/' + {{request()->route('id')}},
            data: formData,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('SavedToken'));
            },
            success: function (data) {
                let successHtml = '<div class="alert alert-success successBlock" role="alert"> Blog Updated Successfully </div>';
                $('.blogsWrapper .formContent').prepend(successHtml);
                $('.loader').delay(1000).hide(function () {
                    window.location.href = "/user/blogs";
                });
            }, error: function (jqXHR) {
                const err = eval("(" + jqXHR.responseText + ")");
                let errorHtml = '<div class="alert alert-danger errorBlock" role="alert"> ' + err.message + ' </div>';
                $('.blogsWrapper .formContent').prepend(errorHtml);
                $('.errorBlock').delay(3000).fadeOut();
            }
        });
    }
</script>

</body>
</html>
