<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <?php include("./navbar.php") ?>
    </nav>
    <div class="container pt-3 pb-3">
        <div class="pt-3 pb-3">
            <input type="text" name="search" id="search" placeholder="Search" class="form-control" />
            <div id="error" class="alert alert-light"></div>
        </div>
        <div class="row pt-3 pb-3" id="data"></div>
    </div>
  

    <script>
        $(document).ready(function() {
            listCardUser();
            let result = {};
        });

        function listCardUser() {
            $.ajax({
                type: 'get',
                url: "http://localhost:5000/users",
                success: function(data) {
                    var response = data.result;
                    let div = '';
                    for (var i = 0; i < response.length; i++) {
                        var id = response[i].id;
                        var name = response[i].name;
                        var email = response[i].email;
                        var image = response[i].image;
                        var phone = response[i].phone;
                        var authorization = response[i].authorization;
                        div += '<div class="col-md-4 pt-3 pb-3">';
                        div += '<div class="card text-center">';
                        div += '<div class="card-header text-left">';
                        div += '<img src="' + image + '" width="30" height="30" alt="logo" class="rounded-circle me-2">';
                        div += '<span>' + name + '</span>';
                        div += '</div>';
                        div += '<div class="card-body">'
                        div += '<h5 class="card-title">' + email + '</h5>'
                        div += '<p class="card-text">' + phone + '</p>';
                        div += '</div>';
                        div += '<div class="card-footer text-muted">' + authorization + '</div>';
                        div += '</div>';
                        div += '</div>';
                    }
                    $('#data').html(div);
                }
            });
        }
        $('#search').keyup(function() {
            let name = $('#search').val();
            if (name !== "") {
                $.ajax({
                    url: `http://localhost:5000/search/${name}`,
                    method: "GET",
                    success: function(data) {
                        console.log(data)
                        $('div#error').html(data.massage).hide()
                        var response = data;
                        result = response
                        let div = '';
                        for (var i = 0; i < response.length; i++) {
                            var id = response[i].id;
                            var name = response[i].name;
                            var email = response[i].email;
                            var image = response[i].image;
                            var phone = response[i].phone;
                            var authorization = response[i].authorization;
                            div += '<div class="col-md-4 pt-3 pb-3">';
                            div += '<div class="card text-center">';
                            div += '<div class="card-header text-left">';
                            div += '<img src="' + image + '" width="30" height="30" alt="logo" class="rounded-circle me-2">';
                            div += '<span>' + name + '</span>';
                            div += '</div>';
                            div += '<div class="card-body">'
                            div += '<h5 class="card-title">' + email + '</h5>'
                            div += '<p class="card-text">' + phone + '</p>';
                            div += '</div>';
                            div += '<div class="card-footer text-muted">' + authorization + '</div>';
                            div += '</div>';
                            div += '</div>';
                        }
                        $('#data').html(div);
                        if (data.status === 202) {
                            $('div#error').html(data.massage).show();
                            employeeList()
                        }
                    }
                });
            } else {
                listCardUser()
            }
        });
    </script>
</body>

</html>