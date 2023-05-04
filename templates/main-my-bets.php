<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
      <?php if($bets): ?>
        <?php foreach($bets as $bet): ?>
          <tr class="rates__item 
              <?php if(check_date($bet['date_completion'])): ?>rates__item--end<?php endif; ?>
              <?php if($bet['winner_id'] === $user_id): ?>rates__item--win<?php endif; ?>
            ">
            <td class="rates__info">
              <div class="rates__img">
                <img src="<?= $bet['image_lot']?>" width="54" height="40" alt="Сноуборд">
              </div>
                <div>
                  <h3 class="rates__title"><a href="lot.php?id=<?= $bet['id']?>"><?= $bet['title'] ?></a></h3>
                  <?php if($bet['winner_id'] === $user_id): ?>
                    <p>
                      <?= $bet['contacts'] ?>
                    </p>  
                  <?php endif; ?>
                </div>
            </td>
            <td class="rates__category">
            <?= $bet['name_category'] ?>
            </td>
            <td class="rates__timer">
              <?php $time_left = get_dt_range($bet['date_completion'])?>
              <div class="timer 
              <?php if($time_left[0] < 1) :?>timer--finishing<?php endif; ?>
                <?php 
                  if (check_date($bet['date_completion'])): ?> timer--end <?php endif; 
                  if($bet['winner_id'] === $user_id): ?>timer--win<?php endif; 
                ?>">
                <?php if(check_date($bet['date_completion'])): ?>
                  Торги окончены
                <?php elseif($bet['winner_id'] === $user_id): ?>
                  Ставка выиграла
                <?php else: ?>
                  <?php
                   if($time_left[0] > 24) {
                    $days = floor($time_left[0] / 24);
                    $hours = $time_left[0] - ($days * 24);
                    print("$days д. $hours") ;
                   }
                  ?>:<?= $time_left[1] ?>
                <?php endif; ?>
              </div>
            </td>
            <td class="rates__price">
            <?= $bet['price_bet'] ?> р
            </td>
            <td class="rates__time">
              <?= get_time_mybet($bet['date_bet']); ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
      <!-- <tr class="rates__item">
        <td class="rates__info">
          <div class="rates__img">
            <img src="../img/rate2.jpg" width="54" height="40" alt="Сноуборд">
          </div>
          <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>
        </td>
        <td class="rates__category">
          Доски и лыжи
        </td>
        <td class="rates__timer">
          <div class="timer timer--finishing">07:13:34</div>
        </td>
        <td class="rates__price">
          10 999 р
        </td>
        <td class="rates__time">
          20 минут назад
        </td>
      </tr>
      <tr class="rates__item rates__item--win">
        <td class="rates__info">
          <div class="rates__img">
            <img src="../img/rate3.jpg" width="54" height="40" alt="Крепления">
          </div>
          <div>
            <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
            <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
          </div>
        </td>
        <td class="rates__category">
          Крепления
        </td>
        <td class="rates__timer">
          <div class="timer timer--win">Ставка выиграла</div>
        </td>
        <td class="rates__price">
          10 999 р
        </td>
        <td class="rates__time">
          Час назад
        </td>
      </tr>
      <tr class="rates__item rates__item--end">
        <td class="rates__info">
          <div class="rates__img">
            <img src="../img/rate7.jpg" width="54" height="40" alt="Сноуборд">
          </div>
          <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>
        </td>
        <td class="rates__category">
          Доски и лыжи
        </td>
        <td class="rates__timer">
          <div class="timer timer--end">Торги окончены</div>
        </td>
        <td class="rates__price">
          10 999 р
        </td>
        <td class="rates__time">
          19.03.17 в 08:21
        </td>
      </tr> -->
    </table>
  </section>