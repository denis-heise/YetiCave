<div class="container">
  <section class="lots">
    <h2>Результаты поиска по запросу «<span><?= $word_search; ?></span>»</h2>
      <?php if($word_error): ?>
        <?= $word_error; ?>
      <? else: ?>
        <ul class="lots__list">
          <?php foreach($goods as $good) : ?>
            <li class="lots__item lot">
              <div class="lot__image">
                <img src="<?= $good[3]; ?>" width="350" height="260" alt="Сноуборд">
              </div>
              <div class="lot__info">
                <span class="lot__category"><?= $good[5]; ?></span>
                <h3 class="lot__title">
                  <a class="text-link" href="lot.php?id=<?= $good[0]; ?>"><?=  $good[1]; ?></a>
                </h3>
                <div class="lot__state">
                  <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost"><?= $good[2]; ?><b class="rub">р</b></span>
                  </div>
                  <?php $time_left = get_dt_range($good[4])?>
                  <div class="lot__timer timer <?php if($time_left[0] < 1) :?>timer--finishing<?php endif; ?>">
                      <?= "$time_left[0]: $time_left[1]"; ?>
                  </div>
                </div>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      <? endif; ?>
  </section>
  <?php if(!$word_error && $pages): ?>
    <ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
    <?php for($i = 1; $i <= $pages; $i++) : ?>
      <li class="pagination-item <?php if($i === 1) : ?> pagination-item-active <?php endif?>"><a href="#"><?= $i ?></a></li>
    <?php endfor; ?>
    <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
  </ul>
  <? endif; ?>
</div>