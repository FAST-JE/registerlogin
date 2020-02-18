<? if (!$user->isLogged()) { ?>
    <h1>Вход</h1>
    <form action="/handler" method="POST">
        <span><?=(App\Classes\Flash::isExists('error') ? App\Classes\Flash::get('error') : '')?></span><br>
        <input type="email" name="email" placeholder="email"><br>
        <span><?=(App\Classes\Flash::isExists('email') ? App\Classes\Flash::get('email') : '')?></span><br>
        <input type="password" name="password" placeholder="password"><br>
        <span><?=(App\Classes\Flash::isExists('password') ? App\Classes\Flash::get('password') : '')?></span><br>
        <input type="hidden" name="func" value="login">
        <input type="submit">
    </form>
<? } ?>