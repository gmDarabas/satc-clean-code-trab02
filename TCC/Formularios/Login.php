<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <style>
  .form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 20px;
    padding: 40px 0px 20px 0px;
    background-color: #f7f7f7;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.login-title
{
    color: #555;
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}
</style>
</head>

<body>

<div class="container">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <form method="post" class="form-signin" action="funcoes_usuario/logar.php">
                <h1>Login</h1>
                <p>
                    <input id="email_cad" class="form-control" name="email" required="required" type="text" placeholder="email" />
                </p>
                <p>
                    <input id="senha_log" class="form-control" name="senha" required="required" type="password" placeholder="Senha"/>
                </p>

                <p>
                    <input type="submit" class="form-control botaoverde" value="Entrar" id="entrar" name="entrar"/>
                </p>

                <p class="link form-control">
                    Não possui conta?
                <a href="index.php?id=Formularios/Cadastrar"> Cadastre-se </a>
                </p>
            </form>
        </div>
        </div>
    </div>
</body>
</html>