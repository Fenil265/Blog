@include('navbar')
<style>
    .form-group {
        margin-bottom: 1rem;
    }
</style>

<div class="row-fluid mt-5">
    <div class="container">
        <div class="row content">
            <form class="w-50 m-auto formContent">
                <div class="form-group">
                    <input type="email" class="form-control" id="userEmail" aria-describedby="emailHelp"
                           placeholder="Enter email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="userPassword" placeholder="Password">
                </div>
                <div class="float-end">
                    <a href="{{route('user.register')}}" type="button" class="btn btn-primary active">Register</a>
                    <button type="button" class="btn btn-success" onclick="loginUser()">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>

<script>
    $(document).ready(function () {
        console.log('ready!')
    });

    function loginUser() {
        const formData = {
            email: $('#userEmail').val(),
            password: $('#userPassword').val()
        };

        $.ajax({
            type: 'POST',
            url: '/api/user/login',
            data: formData,
            success: function (data) {
                if (data.status === false) {
                    let errorHtml = '<div class="alert alert-danger errorBlock" role="alert"> ' + data.message + ' </div>';
                    $('.formContent').prepend(errorHtml);
                } else {
                    let errorHtml = '<div class="alert alert-success errorBlock" role="alert"> ' + data.status + ' </div>';
                    $('.formContent').prepend(errorHtml);
                    localStorage.setItem("SavedToken", 'Bearer ' + data.authorisation.token);
                    localStorage.setItem("logged", true);
                    $('.errorBlock').fadeOut(function () {
                        window.location.href = "/user/blogs";
                    });
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
