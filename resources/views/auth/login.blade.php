<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Website Link Checker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>

        body{
            min-height:100vh;
            background:#f3f4f6;
            display:flex;
            align-items:center;
            justify-content:center;
            font-family:Inter, sans-serif;
        }


        .login-card{

            width:420px;
            background:white;
            border-radius:25px;
            padding:40px;

            box-shadow:
            0 20px 50px rgba(0,0,0,.08);

        }


        .login-icon{

            width:85px;
            height:85px;

            background:#e5e7eb;

            border-radius:22px;

            display:flex;
            align-items:center;
            justify-content:center;

            margin:auto;
            margin-bottom:25px;

            font-size:40px;
            color:#374151;

        }


        h2{

            color:#111827;
            font-weight:800;

        }


        .form-control{

            padding:14px;
            border-radius:14px;

        }


        .form-control:focus{

            border-color:#9ca3af;
            box-shadow:none;

        }


        .login-btn{

            background:#374151;
            color:white;

            padding:14px;

            border-radius:14px;

            font-weight:700;

            border:none;

            transition:.3s;

        }


        .login-btn:hover{

            background:#111827;

        }


        .brand{

            color:#374151;
            font-weight:700;

        }


    </style>


</head>


<body>


<div class="login-card">


    <div class="text-center">


        <div class="login-icon">

            <i class="bi bi-shield-lock"></i>

        </div>


        <h2>
            Admin Login
        </h2>


        <p class="text-muted mb-4">

            Access your Website Link Checker dashboard

        </p>


    </div>



    @if($errors->any())

        <div class="alert alert-danger rounded-3">

            {{ $errors->first() }}

        </div>

    @endif




    <form method="POST" action="/admin/login">

        @csrf



        <div class="mb-3">


            <label class="fw-semibold mb-2">
                Email
            </label>


            <input

                type="email"

                name="email"

                class="form-control"

                placeholder="admin@example.com"

                required

            >


        </div>





        <div class="mb-4">


            <label class="fw-semibold mb-2">

                Password

            </label>



            <input

                type="password"

                name="password"

                class="form-control"

                placeholder="********"

                required

            >


        </div>





        <button class="btn login-btn w-100">

            <i class="bi bi-box-arrow-in-right me-2"></i>

            Login

        </button>



    </form>



    <div class="text-center mt-4">

        <small class="text-muted">

            © Website Link Checker

        </small>

    </div>


</div>



</body>

</html>