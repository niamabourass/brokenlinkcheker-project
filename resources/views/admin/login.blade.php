<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h3>Connexion Admin</h3>
                </div>

                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="/admin/login">
                        @csrf

                        <div class="mb-3">
                            <label>Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Mot de passe</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                        </div>

                        <button class="btn btn-dark w-100">
                            Se connecter
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>