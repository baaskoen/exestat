<html lang="en">
<head>
    <title>Exestat</title>
    @include('exestat::styles')
</head>
<body>
<main>
    <div class="border-bottom my-lg flex items-center justify-between">
        <a href="{{ route('exestat.index') }}">
            <h1 class="text-primary">Exestat</h1>
        </a>

        <a href="{{ route('exestat.clear') }}">
            <button>Clear all data</button>
        </a>

    </div>

    @yield('content')
</main>

@yield('scripts')

</body>
</html>
