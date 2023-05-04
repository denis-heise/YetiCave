<section class="lot-item container">
    <h2><?= $lot['title']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="./<?= $lot['image_lot']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['name_category']; ?></span></p>
            <p class="lot-item__description"><?= $lot['description_lot']; ?></p>
        </div>
    <div class="lot-item__right">
        <?php if (isset($_SESSION['name']) && $lot['author_id'] !== $user_id && $bets[0]['user_id'] !== $user_id && !check_date($lot['date_completion'])): ?>
            <div class="lot-item__state">
                <?php $time_left = get_dt_range($lot['date_completion'])?>
                <div class="lot-item__timer timer <?php if($time_left[0] < 1) :?>timer--finishing<?php endif; ?>">
                    <?= $time_left[1]; ?>:<?= $time_left[1]; ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                    <span class="lot-item__amount">Текущая цена</span>
                    <span class="lot-item__cost"><?= $lot['starting_price']; ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                    Мин. ставка <span><?= $lot['bet_step']; ?> р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="lot.php?id=<?= $lot['id']; ?>" method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item <?php if($error): ?>form__item--invalid<?php endif; ?>">
                    <label for="cost">Ваша ставка</label>
                    <input id="cost" type="text" name="cost" placeholder="12 000">
                    <span class="form__error"><?= $error; ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="history">
        <h3>История ставок (<span><?= count($bets); ?></span>)</h3>
        <table class="history__list">
            <?php foreach($bets as $bet): ?>
                <tr class="history__item">
                    <td class="history__name"><?= $bet['user_name']; ?></td>
                    <td class="history__price"><?= $bet['price_bet']; ?> р</td>
                    <td class="history__time"><?= get_time_bet($bet['date_bet']); ?></td>
                    <!-- <td class="history__time">5 минут назад</td> -->
                </tr>
            <?php endforeach; ?>
        </table>
        </div>
    </div>
    </div>
</section>
