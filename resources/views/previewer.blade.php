<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <title>Bridge Data File viewer</title>
        <style type="text/css">
            body {
                background: #E67817;
                position: absolute;
                top: 0;
                bottom: 0;left: 0;
                right: 0;
            }
            iframe {
                width: 80%;
                margin-right: 10%;
                margin-left: 10%;
                min-height: 90%;
                margin-top: 5%;
                margin-bottom: 5%;
                background: red;
            }
            .headert {
                background: #fff;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                padding: 15px 15px;
            }
            .headert img {
                width: 160px;
            }
        </style>
    </head>
    <body>
        <div class="headert">
            <a href="/"><img src="{{ asset('logo.png') }}" alt="logo-large" class="logo-lg logo-dark"> </a>
        </div>
        <iframe src="{{ $file }}" frameborder="0" seamless></iframe>
    </body>
</html>