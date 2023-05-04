<form class="form form--add-lot container form--invalid" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
    <div class="form__item <?php if($errors && isset($errors['lot-name'])) : ?>form__item--invalid <?php endif?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование <sup>*</sup></label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" <?php if($lot) :?> value="<?= $lot['lot-name']; ?>" <?php endif ?>>
        <span class="form__error"><?= $errors ? $errors['lot-name'] : '' ?></span>
    </div>
    <div class="form__item <?php if($errors && isset($errors['category'])) : ?>form__item--invalid <?php endif?>">
        <label for="category">Категория <sup>*</sup></label>
        <select id="category" name="category">
            <option>Выберите категорию</option>
            <?php foreach($categories as $category) : ?>
                <option value="<?= $category['id']?>" <?php if($category['name_category'] === $lot['category']) :?> selected <?php endif ?>><?=$category['name_category']; ?></option>
            <?php endforeach; ?>
        </select>
        <span class="form__error"><?= $errors ? $errors['category'] : '' ?></span>
    </div>
    </div>
    <div class="form__item form__item--wide <?php if($errors && isset($errors['message'])) : ?>form__item--invalid <?php endif?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?php if($lot) :?> <?= $lot['message']; ?> <?php endif ?></textarea>
        <span class="form__error"><?= $errors ? $errors['message'] : '' ?></span>
    </div>
    <div class="form__item form__item--file <?php if($errors && isset($errors['lot-img'])) : ?>form__item--invalid <?php endif?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" value="" name="lot-img">
            <label for="lot-img">
            Добавить
            </label>
            <span class="form__error"><?= $errors ? $errors['lot-img'] : '' ?></span>
        </div>
    </div>
    <div class="form__container-three">
    <div class="form__item form__item--small <?php if($errors && isset($errors['lot-rate'])) : ?>form__item--invalid <?php endif?>">
        <label for="lot-rate">Начальная цена <sup>*</sup></label>
        <input id="lot-rate" type="text" name="lot-rate" placeholder="0" <?php if($lot) :?> value="<?= $lot['lot-rate']; ?>" <?php endif ?>>
        <span class="form__error"><?= $errors ? $errors['lot-rate'] : '' ?></span>
    </div>
    <div class="form__item form__item--small <?php if($errors && isset($errors['lot-step'])) : ?>form__item--invalid <?php endif?>">
        <label for="lot-step">Шаг ставки <sup>*</sup></label>
        <input id="lot-step" type="text" name="lot-step" placeholder="0" <?php if($lot) :?> value="<?= $lot['lot-step']; ?>" <?php endif ?>>
        <span class="form__error"><?= $errors ? $errors['lot-step'] : '' ?></span>
    </div>
    <div class="form__item <?php if($errors && isset($errors['lot-date'])) : ?>form__item--invalid <?php endif?>">
        <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
        <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" <?php if($lot) :?> value="<?= $lot['lot-date']; ?>" <?php endif ?>>
        <span class="form__error"><?= $errors ? $errors['lot-date'] : '' ?></span>
    </div>
    </div>
    <span class="form__error <?php if($errors) : ?>form__error--bottom<?php endif; ?>">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>