<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 420px;
            border-radius: 15px;
            overflow: hidden;
        }

       .card-header {
            background: #e5e7eb;
            color: #111827;
            padding: 25px;
        }   
        .form-control {
            height: 45px;
            border-radius: 8px;
        }

        .btn-login {
            background: #374151;
            color: white;
            height: 45px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #4b5563;
            color: white;
        }

        .admin-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="card shadow-lg login-card">

    <div class="card-header text-center">

        <div class="admin-icon">
            🔐
        </div>

        <h3>Connexion Admin</h3>
        <p class="mb-0 text-secondary">
            Accès au tableau de bord
        </p>

    </div>


    <div class="card-body p-4">


        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif


        <form method="POST" action="/admin/login">
            @csrf


            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="admin@example.com"
                    required>

            </div>



            <div class="mb-3">

                <label class="form-label">
                    Mot de passe
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="********"
                    required>

            </div>



            <button class="btn btn-login w-100">
                Se connecter
            </button>


        </form>


    </div>

</div>


</body>
</html>