<?php
    // Mendapatkan tickers
    $tickers = json_decode(file_get_contents('https://indodax.com/api/ticker_all'), true)['tickers'];

    // menentukan limit
    $limit = !isset($_GET['limit']) ? 25 : $_GET['limit'];

    if ($limit == "Tampilkan Semua") {
        echo "<option>1</option>";
    } else {
        // Menghitung jumlah aset dan jumlah halaman
        $total_items = count($tickers);
        $total_pages = ceil($total_items / $limit);

        // Menampilkan option
        for($x = 1; $x <= $total_pages; $x++) {
            echo "<option>$x</option>";
        }
    }