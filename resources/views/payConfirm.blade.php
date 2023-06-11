<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <title>Successful Payment</title>
</head>
<style>
    body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
    }

    h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }
</style>

<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i class="checkmark">✓</i>
        </div>
        <?php
        
        $invoice = Session::get('invoice');
        ?>
        <h1>Success</h1>
        <h3>Invoice no - {{ $invoice }}</h3>
        <h3>Payment Id - {{ $payment_id }}</h3>
        <p>We have Sent You Detail<br> in your Given Mail,</p>

        <p> we'll be in touch shortly!</p><br>
        <a href="/">home</a><br>
        <p><small><small> You Will Be Redirected in <b><span id="seconds">5</span></b> sec</small></small>
        </p>
    </div>
</body>
<script>
    var timer = setTimeout(function() {
        window.location = 'http://localhost:8000/'
    }, 4500);

    timeLeft = 5;

    function countdown() {
        timeLeft--;
        document.getElementById("seconds").innerHTML = String(timeLeft);
        if (timeLeft > 0) {
            setTimeout(countdown, 1000);
        }

    };

    setTimeout(countdown, 1000);
</script>

</html>
