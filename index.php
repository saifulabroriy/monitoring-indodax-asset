<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Monitoring Indodax (PHP)</title>
    <link rel="stylesheet" href="css/main.css" />
    <script src="js/jquery.js"></script>
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <h1 class="header__title">Monitoring Indodax (PHP)</h1>
    </header>
    <!-- Akhir Header -->

    <!-- Main -->
    <main class="content">
      <section class="tele">
        <h2 class="tele__title">Bot Telegram</h2>
        <div class="tele__setting">
          <button class="tele__btn tele__btn--start">Start Bot</button>
          <button class="tele__btn tele__btn--stop tele__btn--clicked">Stop Bot</button>
        </div>
        <p class="tele__detail">Bot tidak mengirimkan pesan</p>
      </section>
      <section class="tool">
        <div class="timer">
          <h3 class="timer__title">Timer</h3>
          <div class="slider">
            <input type="range" min="10" max="60" value="20" step="5" class="slider__tab">
            <span class="slider__value"></span>
            <p class="slider__sec">Detik</p>
          </div>
        </div>
        <h2 class="tool__title">Marketplace Indodax</h2>
        
        <!-- Dropdown -->
        <div class="dropdown">
          <label for="dropdown__page">Halaman</label>
          <select class="dropdown__page"><?php include "limit.php" ?></select>
          <label for="dropdown__limit">Jumlah</label>
          <select name="limit" class="dropdown__limit">
            <option <?= $limit == 10 ? ' selected="selected"' : '';?>>10</option>
            <option <?= $limit == 25 ? ' selected="selected"' : '';?>>25</option>
            <option <?= $limit == 50 ? ' selected="selected"' : '';?>>50</option>
            <option <?= $limit == 75 ? ' selected="selected"' : '';?>>75</option>
            <option <?= $limit == 100 ? ' selected="selected"' : '';?>>100</option>
            <option>Tampilkan Semua</option>
          </select>
        </div>
        <!-- Akhir Dropdown -->
      </section>
      <section class="table">
        <table>
          <thead>
            <tr class="table__header__row">
              <th class="table__header table__header--number">No.</th>
              <th class="table__header table__header--coin">Koin</th>
              <th class="table__header table__header--pair">Pair</th>
              <th class="table__header table__header--last">Last</th>
              <th class="table__header table__header--low">Low</th>
              <th class="table__header table__header--high">High</th>
              <th class="table__header table__header--lowest">Is Lowest?</th>
              <th class="table__header table__header--highest">Is Highest?</th>
            </tr>
          </thead>
          <tbody class="table__body">
            
          </tbody>
        </table>
      </section>
    </main>
    <!-- Akhir Main -->

    <!-- Footer -->
    <footer class="footer">
      <p class="footer__text">Created by Kelompok 13 API 2021</p>
    </footer>
    <!-- Akhir Footer -->

    <script src="js/main.js"></script>
  </body>
</html>
