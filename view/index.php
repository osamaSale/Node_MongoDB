<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#"></a>
                </div>
            </div>
            <div class="d-flex">
                <button class="btn btn-outline-success" type="submit" onclick="Loguot()">Loguot</button>
            </div>
        </div>
    </nav>
    <div class="container box"><br>
        <div class="table-responsive">
            <div align="right" class="pt-3 pb-3">
                <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                    <i class="material-icons">&#xE147;</i><span>Add New User</span></a><br /><br>
                <input type="text" name="search" id="search" placeholder="Search" class="form-control" />
            </div>
            <div id="error" class="alert alert-light"></div>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th width="10%">Id</th>
                        <th width="10%">Name</th>
                        <th width="10%">Email</th>
                        <th width="10%">File Image</th>
                        <th width="10%">Url Image</th>
                        <th width="10%">Phone</th>
                        <th width="10%">Authorization</th>
                        <th width="10%">View</th>
                        <th width="10%">Delete</th>
                        <th width="10%">Edit</th>
                    </tr>
                </thead>
                <tbody id="employee_data">
                </tbody>
            </table>
            <p class="users"></p>
        </div>
    </div>
    <?php include("./Form/view.php") ?>
    <?php include("./Form/add.php") ?>
    <?php include("./Form/edit.php") ?>
    <script>
        $(document).ready(function() {
            employeeList();
        });

        function employeeList() {
            $.ajax({
                type: 'get',
                url: "http://localhost:5000/users",
                success: function(data) {
                    console.log(data)
                    if (data.status === 202) {
                        $('.users').html(data.massage).show()
                    } else {
                        var response = data.result;
                        var tr = '';
                        for (var i = 0; i < response.length; i++) {
                            var id = response[i]._id;
                            var name = response[i].name;
                            var email = response[i].email;
                            var image = response[i].image;
                            var fileImage = response[i].fileImage;
                            var phone = response[i].phone;
                            var authorization = response[i].authorization;
                            tr += '<tr>';
                            tr += '<td>' + id + '</td>';
                            tr += '<td>' + name + '</td>';
                            tr += '<td>' + email + '</td>';
                            tr += '<td><img src="../images/' + fileImage + '" class="img-thumbnail" width="50" height="15" /> </td>';
                            tr += '<td><img src="' + image + '" class="img-thumbnail" width="50" height="15" /> </td>';
                            tr += '<td>' + phone + '</td>';
                            tr += '<td>' + authorization + '</td>';
                            tr += '<td><a href="#viewEmployeeModal" class="btn btn-success btn-sm" data-toggle="modal" onclick=viewEmployee("' + id + '")>View</a></td>';
                            tr += '<td><a href="#" class="btn btn-danger  btn-sm" data-toggle="modal" onclick=deleteEmployee("' + id + '")>Delete</a></td>'
                            tr += '<td><a href="#editEmployeeModal" class="btn btn-primary  btn-sm" data-toggle="modal" onclick=viewEmployee("' + id + '")>Edit</a></td>'
                            tr += '</tr>';
                        }
                        $('#employee_data').html(tr);
                    }
                }
            });
        }

        // Add User

        function addEmployee() {
            var name = $('.add_epmployee #name_input').val();
            var email = $('.add_epmployee #email_input').val();
            var password = $('.add_epmployee #password_input').val();
            var phone = $('.add_epmployee #phone_input').val();
            var authorization = $('.add_epmployee #authorization_input').val();
            var fileImage = $('.add_epmployee #image_fileImage').prop('files')[0];
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
                    if (data.status === 422) {
                        alert(data.massage)
                    }
                    if (data.status === 201) {
                        alert(data.massage)
                    }
                    if (data.status === 200) {
                        alert(data.massage)
                        $('#addEmployeeModal').modal('hide');
                        employeeList();
                    }
                }
            })
        }
        // View User
        function viewEmployee(id) {
            console.log("id", id)
            $.ajax({
                type: 'get',
                url: `http://localhost:5000/users/${id}`,
                success: function(data) {
                    let response = data.result;
                    $('.edit_employee #id').val(response._id);
                    $('.edit_employee #name').val(response.name);
                    $('.edit_employee #email').val(response.email);
                    $('.edit_employee #password').val(response.password);
                    $('.edit_employee #phone').val(response.phone);
                    $('.edit_employee #authorization').val(response.authorization);
                    $('.edit_employee #user_uploaded_image').html('<img src="' + response.image + '" class="img-thumbnail" width="50" height="35" /> ');


                    $('.view_employee #name_input1').val(response.name);
                    $('.view_employee #email_input1').val(response.email);
                    $('.view_employee #password_input1').val(response.password);
                    $('.view_employee #phone_input1').val(response.phone);
                    $('.view_employee #authorization_input1').val(response.authorization);
                    $('.view_employee #image_input1').val(response.image);
                    $('.view_employee #user_uploaded_image').html('<img src="' + response.image + '" class="img-thumbnail" width="50" height="35" /> ');


                }
            })
        }

        // Edit User
        function editEmployee() {
            var id = $('.edit_employee #id').val();
            var name = $('.edit_employee #name').val();
            var email = $('.edit_employee #email').val();
            var phone = $('.edit_employee #phone').val();
            var authorization = $('.edit_employee #authorization').val();
            var fileImage = $('.edit_employee #fileImage').prop('files')[0];
            let form_data = new FormData();
            form_data.append("id", id);
            form_data.append("name", name);
            form_data.append("email", email);
            form_data.append("fileImage", fileImage);
            form_data.append("phone", phone);
            form_data.append("authorization", authorization);
            $.ajax({
                url: `http://localhost:5000/users/${id}`,
                type: 'put',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data)
                    if (data.status === 200) {
                        alert(data.massage)
                        $('#editEmployeeModal').modal('hide');
                        employeeList();
                    } else if (data.status === 201) {
                        alert(data.massage)
                    } else {
                        alert(data.massage)
                    }
                }

            })

        }

        // Delete User
        function deleteEmployee(id) {
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: `http://localhost:5000/users/${id}`,
                    method: "Delete",
                    success: function(data) {
                        console.log(data)
                        alert(data.massage);
                        employeeList();
                    }
                });
            } else {
                return false;
            }
        };
        $('#search').keyup(function() {
            let name = $('#search').val();
            if (name !== "") {
                $.ajax({
                    url: `http://localhost:5000/search/${name}`,
                    method: "GET",
                    success: function(data) {
                        console.log(data.result)
                        $('div#error').html(data.massage).hide()
                        var response = data.result;
                        result = response
                        var tr = '';
                        for (var i = 0; i < response.length; i++) {
                            var id = response[i]._id;
                            var name = response[i].name;
                            var email = response[i].email;
                            var image = response[i].image;
                            var fileImage = response[i].fileImage;
                            var phone = response[i].phone;
                            var authorization = response[i].authorization;
                            tr += '<tr>';
                            tr += '<td>' + id + '</td>';
                            tr += '<td>' + name + '</td>';
                            tr += '<td>' + email + '</td>';
                            tr += '<td><img src="../images/' + fileImage + '" class="img-thumbnail" width="50" height="15" /> </td>';
                            tr += '<td><img src="' + image + '" class="img-thumbnail" width="50" height="15" /> </td>';
                            tr += '<td>' + phone + '</td>';
                            tr += '<td>' + authorization + '</td>';
                            tr += '<td><a href="#viewEmployeeModal" class="btn btn-success btn-sm" data-toggle="modal" onclick=viewEmployee("' + id + '")>View</a></td>';
                            tr += '<td><a href="#" class="btn btn-danger  btn-sm" data-toggle="modal" onclick=deleteEmployee("' + id + '")>Delete</a></td>'
                            tr += '<td><a href="#editEmployeeModal" class="btn btn-primary  btn-sm" data-toggle="modal" onclick=viewEmployee("' + id + '")>Edit</a></td>'
                            tr += '</tr>';
                        }
                        $('.loading').hide();
                        $('#employee_data').html(tr);
                        if (data.status === 202) {
                            $('div#error').html(data.massage).show();
                            employeeList()
                        }
                    }

                });
            } else {
                employeeList()
            }
        });

        function Loguot() {
            if (confirm("Do you want to Exit?")) {
                return location.href = "./login.php"
            } else {
                console.log("error")
            }
        }
    </script>
</body>

</html>