<form class="form container" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?php if($errors && isset($errors['email'])) : ?>form__item--invalid <?php endif?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" <?php if($data_form_login): ?> value="<?= $data_form_login['email'] ?>" <?php endif; ?>>
        <span class="form__error"><?= $errors ? $errors['email'] : '' ?></span>
    </div>
    <div class="form__item form__item--last <?php if($errors && isset($errors['password'])) : ?>form__item--invalid <?php endif?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль"  <?php if($data_form_login): ?> value="<?= $data_form_login['password'] ?>" <?php endif; ?>>
        <span class="form__error"><?= $errors ? $errors['password'] : '' ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>