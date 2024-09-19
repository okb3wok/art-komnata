<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Админка</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">

</head>

<body class="login-page bg-body-secondary">
<div class="login-box">
    <div class="card card-outline card-secondary">

        <div class="card-body login-card-body">
            <p class="login-box-msg">Введите логин и пароль</p>


            <form action="./" method="post">
                <div class="input-group mb-1">
                    <div class="form-floating"> <input id="login" name="auth_users_login" type="text" class="form-control" value="" placeholder=""> <label for="login">Логин</label> </div>
                    <div class="input-group-text">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                          <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg></span>
                    </div>
                </div>
                <div class="input-group mb-1">
                    <div class="form-floating"> <input id="loginPassword" name="auth_users_pass" type="password" class="form-control" placeholder=""> <label for="loginPassword">Пароль</label> </div>
                    <div class="input-group-text"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                      <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                    </svg></span> </div>
                </div>
                <div class="row">
                    <div class="col-8 d-inline-flex align-items-center">
                        <div class="form-check"> <input name="remember" class="form-check-input" type="checkbox" value="on" id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                Запомнить меня
                            </label> </div>
                    </div>
                    <div class="col-4">
                        <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary">Вход</button> </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

</html>