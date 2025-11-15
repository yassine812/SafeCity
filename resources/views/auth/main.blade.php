<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeCity — Auth</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --grad-start:#b6e0ff;
            --grad-end:#f3b8d8;
            --card-bg:#ffffff;
            --accent:#ff7fbf;
            --input:#e8f2fb;
        }

        body {
            background: linear-gradient(120deg, var(--grad-start), var(--grad-end));
            font-family: 'Inter', sans-serif;
        }

        .auth-card {
            max-width: 980px;
            margin: 6vh auto;
            background: var(--card-bg);
            border-radius: 22px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 420px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.14);
        }

        .left-side { padding: 55px; }

        input {
            background: var(--input);
            border: none;
            outline: none;
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            margin-top: 4px;
        }

        .btn-main {
            background: linear-gradient(90deg, var(--accent), #ff9ac9);
            border-radius: 999px;
            color: #fff;
            font-weight: 600;
            padding: 11px 20px;
            width: 100%;
            margin-top: 12px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-main:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 127, 191, 0.3);
        }

        .character-img {
            width: 100%;
            height: 100%;
            background-image: url('{{ asset("images/illustration.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        @media(max-width:900px){
            .auth-card{ grid-template-columns:1fr; }
            .right-side{ display:none; }
        }

        .hidden { display: none; }
    </style>
</head>

<body>

<div class="auth-card">
    <div class="left-side">
        <!-- Logo -->
        <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="currentColor">
                    <path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                </svg>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">
                SafeCity
            </span>
        </div>

        <!-- LOGIN FORM -->
        <div id="loginForm">
            <h1 class="text-3xl font-bold mb-1">Welcome back!</h1>
            <p class="text-gray-500 mb-6">Sign in to continue to your SafeCity account</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                </div>

                <button type="submit" class="btn-main">LOGIN →</button>

                <!-- Social Login -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="flex justify-center">
                    <a href="/auth/google" class="w-12 h-12 rounded-full border-2 border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="24" alt="Google">
                    </a>
                </div>

                <p class="text-sm text-center mt-6 text-gray-500">
                    Don't have an account?
                    <button type="button" onclick="showRegister()" class="text-pink-500 font-medium hover:underline ml-1">
                        Sign up for free
                    </button>
                </p>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div id="registerForm" class="hidden">
            <h1 class="text-3xl font-bold mb-1">Create an account</h1>
            <p class="text-gray-500 mb-6">Join SafeCity in a few seconds.</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                </div>

                <button type="submit" class="btn-main">REGISTER →</button>

                <!-- Social Login -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="flex justify-center">
                    <a href="/auth/google" class="w-12 h-12 rounded-full border-2 border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="24" alt="Google">
                    </a>
                </div>

                <p class="text-sm text-center text-gray-500">
                    Already registered?
                    <button type="button" onclick="showLogin()" class="text-pink-500 font-medium hover:underline ml-1">
                        Sign in here
                    </button>
                </p>
            </form>
        </div>
    </div>

    <div class="right-side">
        <div class="character-img"></div>
    </div>
</div>

<script>
    function showRegister() {
        document.getElementById('loginForm').classList.add('hidden');
        document.getElementById('registerForm').classList.remove('hidden');
        window.history.pushState({}, '', '{{ route("register") }}');
    }

    function showLogin() {
        document.getElementById('registerForm').classList.add('hidden');
        document.getElementById('loginForm').classList.remove('hidden');
        window.history.pushState({}, '', '{{ route("login") }}');
    }

    // Show register form if on /register
    @if(request()->routeIs('register'))
        document.addEventListener('DOMContentLoaded', function() {
            showRegister();
        });
    @endif
</script>

</body>
</html>
