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
                    <input type="text" class="form-control" id="userName" aria-describedby="emailHelp"
                           placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="userEmail" aria-describedby="emailHelp"
                           placeholder="Enter email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="userPassword" placeholder="Password">
                </div>
                <div class="float-end">
                    <button type="button" class="btn btn-primary active" onclick="registerUser()">Register</button>
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

    function registerUser() {
        const formData = {
            name: $('#userName').val(),
            email: $('#userEmail').val(),
            password: $('#userPassword').val()
        };

        $.ajax({
            type: 'POST',
            url: '/api/user/register',
            data: formData,
            success: function (data) {
                if (data.status === false) {
                    let errorHtml = '<div class="alert alert-danger errorBlock" role="alert"> ' + data.message + ' </div>';
                    $('.formContent').prepend(errorHtml);
                } else {
                    console.log(data)
                    let errorHtml = '<div class="alert alert-success errorBlock" role="alert"> ' + data.message + ' </div>';
                    $('.formContent').prepend(errorHtml);
                    $('.errorBlock').delay(3000).fadeOut(function () {
                        window.location.href = "/user/login";
                    });
                }

            }, error: function (jqXHR) {
            }
        });
    }
</script>
