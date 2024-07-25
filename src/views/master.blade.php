<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')">
    <meta property="og:image" content="@yield('og:image')">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset(setting('favicon_image')) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('vendor/installer/bootstrap.min.css') }}">
    <script src="{{ asset('vendor/installer/axios.min.js') }}"></script>
    <style>
        #box {
            height: 100vh;
            width: 100%;
            background: #e1e1e1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #box .plate {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            overflow: hidden;
            max-width: 700px;
            position: relative;
        }

        .loader {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(1px);
            z-index: 1000;
        }

        .loader.hidden {
            display: none;
        }

        .loader .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: #000;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div id="box">
        <div class="plate">
            <div id="loader" class="loader hidden">
                <div class="spinner"></div>
            </div>
            <h1 class="text-center">
                @yield('title')
            </h1>
            <div class="px-3 pt-3 d-none" id="errorWrapper">
                @include('installer::error-alert')
            </div>
            @yield('body')
        </div>
    </div>

    <script>
        // function to show loader
        function showLoader() {
            document.getElementById('loader').classList.remove('hidden');
        }

        // function to hide loader
        function hideLoader() {
            document.getElementById('loader').classList.add('hidden');
        }

        // function to show error
        function showError(msg) {
            document.getElementById('errorAlertMsg').innerHTML = msg;
            document.getElementById('errorWrapper').classList.remove('d-none');
        }

        // function to hide error
        function hideError() {
            document.getElementById('errorWrapper').classList.add('d-none');
        }

        document.addEventListener("DOMContentLoaded", function() {
            // attach click event listener to elements with the class 'loader-show'
            const triggerElements = document.querySelectorAll('.loader-show');
            triggerElements.forEach(element => {
                element.addEventListener('click', function() {
                    showLoader();
                });
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
