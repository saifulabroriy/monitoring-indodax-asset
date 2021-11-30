<?php
    // Include file module telegram 
    include_once "telegram.php";

    // Mendapatkan state bot telegram
    $state = $_GET["state"];

    // Fungsi mendapatkan data di return menjadi JSON dari URL
    function getData($url){
        // persiapkan curl
        $curl = curl_init(); 

        // Set Opsi pada curl
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 

        // eksekusi dan dimasukkan ke markets
        $res = curl_exec($curl); 

        // Error Handler
        if (curl_errno($curl)) {
            print "Error: " . curl_error($curl);
        } else {
            // Tutup curl
            curl_close($curl);

            // return sebagai assoc array
            return json_decode($res, true);
        }
    }

    // Mendapatkan aset
    $url = "https://indodax.com/api/ticker_all";
    $data = getData($url);

    // Mendapatkan tickers
    $tickers = $data['tickers'];

    // Jika page tidak diisi maka page = 1
    $page = !isset($_GET['page']) ? 1 : $_GET['page'];
    
    // limit
    $limit = 25;

    // posisi atau cursor
    $offset = ($page - 1) * $limit;

    // potong array asli menjadi array yang dilimit
    $limited_tickers = array_splice($tickers, $offset, $limit);

    // Mendapatkan symbols
    $symbols = array_keys($limited_tickers);

    // array untuk tempat aset lowest dan highest
    $low_asset = array();
    $high_asset = array();

    // Cek lowest dan highest
    for($i = 0; $i <= count($limited_tickers) - 1; $i++) {
        // membongkar menjadi beberapa variable agar mudah
        $symbol = explode("_", $symbols[$i]);
        $koin = $symbol[0];
        $pair = $symbol[1];
        $last = $limited_tickers[$symbols[$i]]['last'];
        $low = $limited_tickers[$symbols[$i]]['low'];
        $high = $limited_tickers[$symbols[$i]]['high'];
        $lowest = $last - $low;
        $highest = $high - $last;

        // Cek price
        if($lowest <= 0){
            array_push($low_asset, "$koin/$pair");
        }

        if($highest <= 0){
            array_push($high_asset, "$koin/$pair");
        }
    }
    
    $num = 1;
    for($i = 0; $i <= count($limited_tickers) - 1; $i++) {
        // membongkar menjadi beberapa variable agar mudah
        $symbol = explode("_", $symbols[$i]);
        $koin = strtoupper($symbol[0]);
        $pair = strtoupper($symbol[1]);
        $last = $limited_tickers[$symbols[$i]]['last'];
        $low = $limited_tickers[$symbols[$i]]['low'];
        $high = $limited_tickers[$symbols[$i]]['high'];
        $last_formatted = number_format($last, 3, ",", ".");
        $low_formatted = number_format($low, 3, ",", ".");
        $high_formatted = number_format($high, 3, ",", ".");
        $lowest = number_format($last - $low, 3, ",", ".");
        $highest = number_format($high - $last, 3, ",", ".");

        // Membuat baris tabel
        echo "<tr class=\"table__row\">";
        echo "<td class=\"table__item table__item--number\">$num</td>";
        echo "<td class=\"table__item table__item--coin\">$koin</td>";
        echo "<td class=\"table__item table__item--pair\">$pair</td>";
        echo "<td class=\"table__item table__item--last\">$last_formatted</td>";
        echo "<td class=\"table__item table__item--low\">$low_formatted</td>";
        echo "<td class=\"table__item table__item--high\">$high_formatted</td>";
        echo "<td class=\"table__item table__item--lowest\">$lowest</td>";
        echo "<td class=\"table__item table__item--highest\">$highest</td>";
        echo "</tr>";

        $num++;
    }

    // Jika state yang dikirim true
    if ($state == "true"){
        // Mendapatkan timestamp dari mikrotime bingbon
        $waktu = round($ex_infos->serverTime / 1000 );

        $msg = "Waktu Server: " . date('j M Y, H:i:s', $waktu) . " %0a%0a";

        // Jika array low ada isinya
        if (count($low_asset) > 0){
            $msg .= "LOW %0a%0a";
            for ($i=0; $i < count($low_asset); $i++) { 
                $msg .= $i + 1 . ". " . $low_asset[$i] . " %0a";
            }
            $msg .= "%0a";
        }
        
        // Jika array high ada isinya
        if (count($high_asset) > 0){
            $msg .= "HIGH %0a%0a";
            for ($i=0; $i < count($high_asset); $i++) { 
                $msg .= $i + 1 . ". " . $high_asset[$i] . " %0a";
            }
        }

        // Jika salah satu dari array low dan high ada isinya maka kirim pesan
        if (count($high_asset) > 0 || count($low_asset) > 0){
            sendMessage($msg);
        }
    }