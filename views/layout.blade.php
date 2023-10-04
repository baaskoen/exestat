<html lang="en">
<head>
    <title>Exestat</title>
    <style>
        :root {
            --color-primary: #6767ea;
        }

        body {
            background-color: #edf1f3;
            font-family: Nunito,sans-serif;
            color: #212529;
        }

        main {
            max-width: 1140px;
            margin: auto;
        }

        .text-primary {
            color: var(--color-primary);
        }

        .border-bottom {
            border-bottom: thin solid #dadada;
        }

        .my-lg {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .block {
            border-radius: 5px;
            background-color: white;
            padding: 1rem;
            box-shadow: 0 2px 3px #cdd8df;
        }
    </style>
</head>
<body>
<main>
    <div class="border-bottom my-lg">
        <h1 class="text-primary">Exestat</h1>
    </div>

    @yield('content')
</main>

</body>
</html>
