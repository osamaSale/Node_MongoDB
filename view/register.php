<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container" style="margin-top: 100px;">

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div id="error" class="alert alert-danger" role="alert"></div>
                <div class="modal-header">
                    <h5 class="modal-title">Register</h5>
                </div>
                <div class="modal-body">
                    <div class='form-group'>
                        <label>Name</label>
                        <input type='text' name='name' id='name' class='form-control'>
                    </div>
                    <div class='form-group'>
                        <label>Email</label>
                        <input type='email' name='email' id='email' class='form-control'>
                    </div>
                    <div class='form-group'>
                        <label>Password</label>
                        <input type='password' name='password' id='password' class='form-control'>
                    </div>
                    <div class='form-group'>
                        <label>Phone</label>
                        <input type='tel' name='phone' id='phone' class='form-control'>
                    </div>
                    <div class="form-group">
                        <label>Authorization</label>
                        <select id="authorization" name="authorization" class="form-control" required>
                            <option>Open</option>
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" id="fileImage" name="fileImage" class="form-control">
                        <span id="user_uploaded_image"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnFetch" class="spinner-button btn btn-primary mb-2" onclick="addEmployee()" style="width: 100%;">Add</button>
                    </div>
                    </br>
                    <div class="form-group">
                        <p class="text-center">
                            Already have an account ? Login <a href="./login.php"> Here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var element = document.getElementById("error");
            element.style.display = "none";
        })

        function addEmployee() {
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var phone = $('#phone').val();
            var authorization = $('#authorization').val();
            var fileImage = $('#fileImage').prop('files')[0];
            let form_data = new FormData();
            form_data.append("name", name);
            form_data.append("email", email);
            form_data.append("password", password);
            form_data.append("fileImage", fileImage);
            form_data.append("phone", phone);
            form_data.append("authorization", authorization);
            $.ajax({
                url: "http://localhost:5000/users",
                type: 'post',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                    // if Empty faild

                    if (data.status === 422) {
                        $('div#error').html(data.massage).show();
                    }
                    // if Email

                    if (data.status === 201) {
                        $('div#error').html(data.massage).show();
                    }

                    // successfully register

                    if (data.status === 200) {
                        $('div#error').html(data.massage).show();
                        location.href = "./login.php"
                    }
                }
            })
        }
    </script>
</body>

</html>