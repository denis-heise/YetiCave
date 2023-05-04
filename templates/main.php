<?php
    require_once('helpers.php');
?>
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach($categories as  $key => $category) : ?>
            <li class="promo__item promo__item--<?= $category['character_code']; ?>">
                <a class="promo__link" href="/"><?=$category['name_category']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach($goods as $good) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?= $good['image_lot']; ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $good['name_category']; ?></span>
                    <h3 class="lot__title">
                        <a class="text-link" href="lot.php?id=<?= $good['id']; ?>"><?=  $good['title']; ?></a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= $good['starting_price']; ?><b class="rub">р</b></span>
                        </div>
                        <?php $time_left = get_dt_range($good['date_completion'])?>
                        <div class="lot__timer timer <?php if($time_left[0] < 1) :?>timer--finishing<?php endif; ?>">
                            <?= "$time_left[0]: $time_left[1]"; ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>