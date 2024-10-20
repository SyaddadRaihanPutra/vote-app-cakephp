<?php
$user = $this->request->getSession()->read('Auth.User');
?>

<h1>Selamat datang, <span class="title"><?= $user['username'] ; ?></span></h1>
