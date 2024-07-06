<!doctype html>
<html lang="en">

<head>
    <title>Login - Stock Managemrnt</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <!-- FontAwesome 6.2.0 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- (Optional) Use CSS or JS implementation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"
        integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .root{
            --primary:#0f256e;
        }
        .card {
            box-shadow: 0px 4px 30px 0px rgba(15, 37, 110, 0.2);
            border: none;
        }

        .card-header .logo {
            color: rgba(15, 37, 110, 1);
            font-size: 30px;
            font-weight: 700;
            line-height: 50px;
            letter-spacing: 0em;
            text-align: center;


        }

        .card .logo-desc {
            font-family: Nunito;
            font-size: 17px;
            font-weight: 400;
            line-height: 50px;
            letter-spacing: 0em;
            text-align: center;

        }

        .title {
            font-family: Nunito;
            font-size: 18px;
            font-weight: 400;
            line-height: 20px;
            letter-spacing: 0em;
            text-align: center;

        }

        .title-desc {
            font-family: Nunito;
            font-size: 14px;
            font-weight: 400;
            line-height: 22px;
            letter-spacing: 0em;
            text-align: center;

        }

        .label-username,
        .label-remember,
        .label-password {
            font-family: Nunito;
        }

        .form-check-input:checked {
            background-color: #0f256e !important;
            border-color: #0d6efd;
        }
        .login-btn{
            background-color: #0f256e;
            color: #ffffff;
            font-family: Nunito;
        }
    </style>
</head>

<body>

    <main>
        <section class="vh-100 bg-white">
            <div class="container py-5 h-100">

                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center mt-5">
                            <img src="{{asset('img/logo.svg')}}" class="img-fluid mt-2" style="width: 60%" alt="">
                                        <p class="logo-desc">Manufacturers of Concrete Pavers & Blocks</p>
                        </div>
                        <div class="card shadow-2-strong bg-white mt-5" style="margin-bottom: 151px">
                            <div class="card-header bg-white text-center">

                                <div class="text-center ">
                                    <h5 class="title mt-4">Sign In</h5>
                                    <span class="title-desc mb-2">Please Enter Your Username and Password <br> to Login.</span>
                                </div>
                            </div>
                            <div class="card-body my-2 mx-3">

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <label for="username"
                                        class=" col-form-label label-username text-md-end mb-2">{{ __('Username') }}</label>


                                    <input id="username" type="text"
                                        class="form-control  @error('username') is-invalid @enderror" name="username"
                                        value="" required autocomplete="username">

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <label for="password"
                                        class=" col-form-label label-password text-md-end mt-2 mb-2">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control  @error('password') is-invalid @enderror"
                                            name="password"
                                            aria-label="Dollar amount (with dot and two decimal places)">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror



                                    <div class="form-check my-4">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label label-remember" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    <div class="row mb-3 mt-2">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn login-btn">
                                                {{ __('Log In') }}
                                            </button>


                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>
