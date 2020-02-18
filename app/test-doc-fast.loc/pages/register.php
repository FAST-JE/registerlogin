<?php
if (!$user->isLogged()) { ?>
<h1>Register</h1>
<form action="/handler" method="POST">
    <input type="email" name="email" placeholder="email"><br>
    <span><?=(App\Classes\Flash::isExists('email') ? App\Classes\Flash::get('email') : '')?></span><br>
    <input type="password" name="password" placeholder="password"><br>
    <span><?=(App\Classes\Flash::isExists('password') ? App\Classes\Flash::get('password') : '')?></span><br>
    <input type="hidden" name="func" value="register">
    <input type="submit">
</form>
<? } ?>