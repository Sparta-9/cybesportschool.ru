<style>
<?php include '../body_shop/assets/css/loginstyle.css' ?>
</style>


<form class="login" action="../controller/auth.php" method="post">
    <p class="loginclass">
        <label for="login">Логин</label>
        <input type="text" name="login" id="login" placeholder="Логин">
    </p>
    <p class="loginclass">
        <label for="password">Пароль</label>
        <input type="password" name="pass" id="password" placeholder="Пароль">
    </p>
    <p class="loginclass">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Запомнить меня</label>
    </p>
    <p class="loginclass">
        <input type="submit" name="submit" value="Вход">
    </p>
</form>
