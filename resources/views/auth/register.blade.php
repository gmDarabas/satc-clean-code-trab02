<!DOCTYPE html>
<html>
<head><title>Cadastro</title></head>
<body>
<h2>Cadastro</h2>
<form method="POST" action="/register">
    @csrf
    <input type="text" name="name" placeholder="Nome" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Senha" required><br>
    <input type="password" name="password_confirmation" placeholder="Confirme a senha" required><br>
    <button type="submit">Cadastrar</button>
</form>
<a href="/login">Já tem conta?</a>
</body>
</html>
