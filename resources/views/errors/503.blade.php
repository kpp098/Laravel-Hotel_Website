<!doctype html>
<html>

<head>
    <title>Be right back.</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/maintainn.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/maintenence.jpeg') }}">
</head>

<body>
    <div class="container">
        <div class="animation">

            <div class="one spin-one"></div>
            <div class="two spin-two"></div>
            <div class="three spin-one"></div>
        </div>
        <br>
        <div class="content">
            <div class="title"> Be right <span>back <span>.</div>
            <div class="maintain">Our System Is Under <span> Maintenance</span>.</div><br>

        </div>

</body>
<script>
    setTimeout(function() {
        window.location.href = "/";

    }, 5000);
</script>

</html>
