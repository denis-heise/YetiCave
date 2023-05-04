<form class="form container form--invalid" action="registration.php" method="post" autocomplete="off"> <!-- form
--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?php if($errors && isset($errors['email'])) : ?>form__item--invalid <?php endif?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" <?php if($data_form_registration): ?> value="<?= $data_form_registration['email']?>" <?php endif?>>
        <span class="form__error"><?= $errors ? $errors['email'] : '' ?></span>
    </div>
    <div class="form__item <?php if($errors && isset($errors['password'])) : ?>form__item--invalid <?php endif?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" <?php if($data_form_registration): ?> value="<?= $data_form_registration['password']?>" <?php endif?>>
        <span class="form__error"><?= $errors ? $errors['password'] : '' ?></span>
    </div>
    <div class="form__item <?php if($errors && isset($errors['name'])) : ?>form__item--invalid <?php endif?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" <?php if($data_form_registration): ?> value="<?= $data_form_registration['name']?>" <?php endif?>>
        <span class="form__error"><?= $errors ? $errors['name'] : '' ?></span>
    </div>
    <div class="form__item <?php if($errors && isset($errors['message'])) : ?>form__item--invalid <?php endif?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?php if($data_form_registration): ?><?= $data_form_registration['message']?><?php endif?></textarea>
        <span class="form__error"><?= $errors ? $errors['message'] : '' ?></span>
    </div>
    <span class="form__error <?php if($errors) : ?>form__error--bottom<?php endif; ?>">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>