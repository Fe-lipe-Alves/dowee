<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>{{ config('app.name') }}</title>

    <style>
        html, body {
            height: 100%;
        }

        .container-loading{
            width: 200px;
            margin: 0 auto;
        }
        .swing div {
            border-radius: 50%;
            float: left;
            height: 1em;
            width: 1em;
        }
        .swing div:nth-of-type(1) {
            background: -webkit-linear-gradient(left, #385c78 0%, #325774 100%);
            background: linear-gradient(to right, #385c78 0%, #325774 100%);
        }
        .swing div:nth-of-type(2) {
            background: -webkit-linear-gradient(left, #325774 0%, #47536a 100%);
            background: linear-gradient(to right, #325774 0%, #47536a 100%);
        }
        .swing div:nth-of-type(3) {
            background: -webkit-linear-gradient(left, #4a5369 0%, #6b4d59 100%);
            background: linear-gradient(to right, #4a5369 0%, #6b4d59 100%);
        }
        .swing div:nth-of-type(4) {
            background: -webkit-linear-gradient(left, #744c55 0%, #954646 100%);
            background: linear-gradient(to right, #744c55 0%, #954646 100%);
        }
        .swing div:nth-of-type(5) {
            background: -webkit-linear-gradient(left, #9c4543 0%, #bb4034 100%);
            background: linear-gradient(to right, #9c4543 0%, #bb4034 100%);
        }
        .swing div:nth-of-type(6) {
            background: -webkit-linear-gradient(left, #c33f31 0%, #d83b27 100%);
            background: linear-gradient(to right, #c33f31 0%, #d83b27 100%);
        }
        .swing div:nth-of-type(7) {
            background: -webkit-linear-gradient(left, #da3b26 0%, #db412c 100%);
            background: linear-gradient(to right, #da3b26 0%, #db412c 100%);
        }
        .box-shadow {
            clear: left;
            padding-top: 1.5em;
        }
        .box-shadow div {
            -webkit-filter: blur(1px);
            filter: blur(1px);
            float: left;
            width: 1em;
            height: .25em;
            border-radius: 50%;
            background: #e3dbd2;
        }
        .box-shadow .shadow-l {
            background: #d5d8d6;
        }
        .box-shadow .shadow-r {
            background: #eed3ca;
        }
        @-webkit-keyframes ball-l {
            0%, 50% {
                -webkit-transform: rotate(0) translateX(0);
                transform: rotate(0) translateX(0);
            }
            100% {
                -webkit-transform: rotate(50deg) translateX(-2.5em);
                transform: rotate(50deg) translateX(-2.5em);
            }
        }
        @keyframes ball-l {
            0%, 50% {
                -webkit-transform: rotate(0) translate(0);
                transform: rotate(0) translateX(0);
            }
            100% {
                -webkit-transform: rotate(50deg) translateX(-2.5em);
                transform: rotate(50deg) translateX(-2.5em);
            }
        }
        @-webkit-keyframes ball-r {
            0% {
                -webkit-transform: rotate(-50deg) translateX(2.5em);
                transform: rotate(-50deg) translateX(2.5em);
            }
            50%,
            100% {
                -webkit-transform: rotate(0) translateX(0);
                transform: rotate(0) translateX(0);
            }
        }
        @keyframes ball-r {
            0% {
                -webkit-transform: rotate(-50deg) translateX(2.5em);
                transform: rotate(-50deg) translateX(2.5em);
            }
            50%,
            100% {
                -webkit-transform: rotate(0) translateX(0);
                transform: rotate(0) translateX(0)
            }
        }
        @-webkit-keyframes shadow-l-n {
            0%, 50% {
                opacity: .5;
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
            100% {
                opacity: .125;
                -webkit-transform: translateX(-1.57em);
                transform: translateX(-1.75em);
            }
        }
        @keyframes shadow-l-n {
            0%, 50% {
                opacity: .5;
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
            100% {
                opacity: .125;
                -webkit-transform: translateX(-1.75);
                transform: translateX(-1.75em);
            }
        }
        @-webkit-keyframes shadow-r-n {
            0% {
                opacity: .125;
                -webkit-transform: translateX(1.75em);
                transform: translateX(1.75em);
            }
            50%,
            100% {
                opacity: .5;
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
        }
        @keyframes shadow-r-n {
            0% {
                opacity: .125;
                -webkit-transform: translateX(1.75em);
                transform: translateX(1.75em);
            }
            50%,
            100% {
                opacity: .5;
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }
        }
        .swing-l {
            -webkit-animation: ball-l .425s ease-in-out infinite alternate;
            animation: ball-l .425s ease-in-out infinite alternate;
        }
        .swing-r {
            -webkit-animation: ball-r .425s ease-in-out infinite alternate;
            animation: ball-r .425s ease-in-out infinite alternate;
        }
        .shadow-l {
            -webkit-animation: shadow-l-n .425s ease-in-out infinite alternate;
            animation: shadow-l-n .425s ease-in-out infinite alternate;
        }
        .shadow-r {
            -webkit-animation: shadow-r-n .425s ease-in-out infinite alternate;
            animation: shadow-r-n .425s ease-in-out infinite alternate;
        }
    </style>
</head>
<body class="container-fluid">

<div class="row justfy-content-center align-items-center vh-100">
    <div class="col-12 text-center">
        <h2 id="title">{{ config('app.name') }}</h2>
        <small id="message">Aplicativo em construção</small>

        <div aria-busy="true" aria-label="Loading" role="progressbar" class="container-loading mt-5">
            <div class="swing d-flex justify-content-center">
                <div class="swing-l"></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div class="swing-r"></div>
            </div>
            <div class="box-shadow d-flex justify-content-center">
                <div class="shadow-l"></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div class="shadow-r"></div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>
