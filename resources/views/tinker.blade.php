<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BotMan Studio</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">

    <script>
        var botmanWidget = {
            bubbleBackground: '#f28f20',
            mainColor: '#f28f20',
            placeholderText: 'Type a message',
            title: 'Pratik',
            headerTextColor: '#fff',
            introMessage: 'lochawala मैं आपका स्वागत है । यह प्रोडक्ट आर्डर  करने के लिए <strong>Hi</strong> मैसेज भेजे । धन्यवाद! ',
            mobileHeight: "100%",
            timeFormat: "hh:MM TT",
        };
    </script>

    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

    <!-- Styles -->
    <style>
        body {
            font-family: "Source Sans Pro", sans-serif;
            margin: 0;
            padding: 0;
            background: radial-gradient(#57bfc7, #45a6b3);
        }

        .container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .content {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content" id="app">
        <botman-tinker api-endpoint="/botman"></botman-tinker>
    </div>
</div>

<script src="/js/app.js"></script>
</body>
</html>