<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Website Link Checker</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
    body {
        margin: 0;
        padding: 0;
        background: #f5f6f8;
    }

    .login-navbar {
        width: 100%;
        height: 78px;
        background: #e5e7eb;
        display: flex;
        align-items: center;
    }

    .login-navbar-container {
        width: 100%;
        padding-left: 40px;
    }

    .login-navbar-logo {
        display: flex;
        align-items: center;
    }

    .login-navbar-logo img {
        height: 55px;
        width: auto;
        display: block;
    }

    .login-page {
        width: 100% !important;
        min-height: calc(100vh - 78px);

        background: #f5f6f8;

        display: flex !important;
        justify-content: center !important;
        align-items: center !important;

        padding: 30px 20px;
        box-sizing: border-box;
    }

    .login-card {
        width: 380px !important;
        max-width: 380px !important;

        margin: 0 auto !important;

        background: #ffffff;

        padding: 30px;

        border: 1px solid #e1e4e8;
        border-radius: 10px;

        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);

        box-sizing: border-box;

        transform: translateY(50px);
    }

    .login-input {
        width: 100%;
        box-sizing: border-box;

        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: #ffffff;
    }

    .login-input:focus {
        border-color: #6b7280;
        outline: none;
        box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.12);
    }

    .login-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
    }

    .login-link {
        color: #6b7280;
        font-size: 13px;
        text-decoration: none;
    }

    .login-link:hover {
        color: #374151;
    }

    .login-button {
        background: #4b5563 !important;

        border-radius: 7px;

        padding: 10px 25px !important;

        min-width: 90px;
        min-height: 40px;

        font-size: 14px !important;
        line-height: 20px !important;

        font-weight: 600;

        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;

        white-space: nowrap;

        transition: 0.2s;
    }

    .login-button:hover {
        background: #374151 !important;
    }

    .login-button:hover {
        background: #374151 !important;
    }

    .login-header {
        width: 100% !important;

        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;

        text-align: center !important;

        margin: 0 auto 25px auto !important;
    }

    .login-icon {
    font-size: 28px;
    margin-bottom: 8px;
    text-align: center;
    }

    .login-header h2 {
        margin: 0;
        color: #374151;
        font-size: 22px;
        font-weight: 600;
        text-align: center;
    }

    .login-header p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 13px;
        text-align: center;
    }
</style>
</head>

<body>

    <!-- ================= NAVBAR ================= -->

    <nav class="login-navbar">

        <div class="login-navbar-container">

            <a href="/" class="login-navbar-logo">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Website Link Checker"
                >
            </a>

        </div>

    </nav>


    <!-- ================= LOGIN ================= -->

    <div class="login-card">

    <!-- Login Header -->
    <div class="login-header">

        <div class="login-icon">
            🔐
        </div>

        <h2>Connexion</h2>

        <p>Accédez à votre espace</p>

    </div>


    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form method="POST" action="{{ route('login') }}">
                @csrf


                <!-- Email -->
                <div>

                    <x-input-label
                        for="email"
                        :value="__('Email')"
                    />

                    <x-text-input
                        id="email"
                        class="login-input block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-2"
                    />

                </div>


                <!-- Password -->
                <div class="mt-4">

                    <x-input-label
                        for="password"
                        :value="__('Password')"
                    />

                    <x-text-input
                        id="password"
                        class="login-input block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"
                    />

                </div>


                <!-- Remember me -->
                <div class="block mt-4">

                    <label
                        for="remember_me"
                        class="inline-flex items-center"
                    >

                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300"
                            name="remember"
                        >

                        <span class="ms-2 text-sm text-gray-600">
                            {{ __('Remember me') }}
                        </span>

                    </label>

                </div>


                <!-- Actions -->
                <div class="login-actions">

                    @if (Route::has('password.request'))

                        <a
                            class="login-link"
                            href="{{ route('password.request') }}"
                        >
                            {{ __('Forgot your password?') }}
                        </a>

                    @endif


                    <a
                        class="login-link"
                        href="{{ route('register') }}"
                    >
                        {{ __('Create account') }}
                    </a>


                    <x-primary-button class="login-button">
                        {{ __('Log in') }}
                    </x-primary-button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>