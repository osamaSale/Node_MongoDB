<div class="container-fluid">
    <a class="navbar-brand" href="#">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="#">About</a>
        </div>
    </div>
</div>
<div class="d-flex">
    <a class="navbar-brand mr-3" href="#" id="image"><span id="image"></span><span id="name"></span></a>
    <button class="btn btn-outline-success" type="submit" onclick="Loguot()">Loguot</button>
</div>

<script>
    $(document).ready(function() {
        let authorization = localStorage.getItem("authorization")
        if (authorization === 'admin') {
            let image = localStorage.getItem("image")
            let name = localStorage.getItem("name")
            let img = '<img src="' + image + '" width="30" height="30" alt="logo" class="rounded-circle me-2">'
            $('#image').html(img)
            $('#authorization').html(authorization)
        } else if (authorization === 'user') {
            let image = localStorage.getItem("image")
            let img = '<img src="' + image + '" width="30" height="30" alt="logo" class="rounded-circle me-2">'
            $('#image').html(img)
            $('#authorization').html(authorization)
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