<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Bunga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('https://www.astra-daihatsu.id/_next/image?url=https%3A%2F%2Fdsoodysseusstprod.blob.core.windows.net%2Fstrapi-media%2Fassets%2Fsys_master_media_h49_h01_8823924293662_7a883606_9d22_4a65_bcec_98a154188cf2_bb4f523bf2.jpg&w=3840&q=75');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            color: #fff;
        }

        .main {
            height: 100vh;
        }

        .motorkeong {
            height: 600px;
            width: 550px;
            box-sizing: border-box;
            border-radius: 10px;
        }

        @media print {
            body>*:not(.output-container) {
                display: none;
            }

            form {
                display: none;
            }

            .mawang {
                display: none;
            }
        }

        select.form-control-sm {
            font-size: 12px;
            padding: 2px;
            width: 300px;
        }
    </style>
</head>

<body>
    <div class="container main d-flex flex-column justify-content-center align-items-center">
        <div class="container motorkeong p-5 shadow-lg p-3 mb-5">
            <p class="container text-center fs-5 fw-bold">Welcome to Bank</p>
           
            <form action="" method="post">
                <div>
                    <label for="nom" class="fs-5 m-2">Masukan nominal</label>
                    <input type="text" class="form-control" name="nom" id="nom" oninput="formatCurrency(this)"
                        placeholder="Masukkan nominal">
                </div>

                <div>
                    <div class="wrap d-flex">
                        <label for="bunga" class="fs-5 m-2">Bunga per</label>
                        <select class="form-control m-2 w-25 h-10" name="persen" aria-label="Default select example">
                            <option value="bulan">Bulan</option>
                            <option value="triwulan">Triwulan</option>
                            <option value="semester">Semester</option>
                            <option value="tahun">Tahun</option>
                        </select>
                    </div>
                    <input type="number" class="form-control" name="bunga" id="bunga" placeholder="Masukkan bunga (%)">
                </div>

                <div>
                    <label for="waktu" class="fs-5 m-1">Masukan periode waktu</label>
                    <div class="wrap d-flex">
                        <input type="number" class="form-control" name="waktu" id="waktu"
                            placeholder="Masukkan periode waktu">
                        <select class="form-control m-1 w-25 h-10" name="periode" aria-label="Default select example">
                            <option value="bln">Bulan</option>
                            <option value="tri">Triwulan</option>
                            <option value="smt">Semester</option>
                            <option value="thn">Tahun</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="fs-5 m-2">Jenis Bunga</label>
                    <select class="form-control" name="jenisBunga">
                        <option value="tunggal">Bunga Tunggal</option>
                        <option value="majemuk">Bunga Majemuk</option>
                    </select>
                </div>

                <div>
                    <button class="container btn btn-success form-control mt-3" type="submit"
                        name="hitung">Hitung</button>
                </div>
            </form>

            <?php
if (isset($_POST['hitung']) && $_POST['nom'] && $_POST['bunga'] && $_POST['waktu']) {
    $nom = str_replace(['Rp. ', '.'], '', $_POST['nom']);
    $nom = (float) $nom;
    $bunga = $_POST['bunga'];
    $bunga = (float) $bunga;

    $waktu = $_POST['waktu'];
    $periode = $_POST['periode'];
    $persen = $_POST['persen'];
    $jenisBunga = $_POST['jenisBunga']; // Ambil pilihan jenis bunga

    // Ubah periode ke bulan
    switch ($periode) {
        case "bln":
            break;
        case "tri":
            $waktu = $waktu * 3;
            break;
        case "smt":
            $waktu = $waktu * 6;
            break;
        case "thn":
            $waktu = $waktu * 12;
            break;
    }

    // Frekuensi penggandaan berdasarkan opsi yang dipilih
    switch ($persen) {
        case "bulan":
            $n = 12;
            break;
        case "triwulan":
            $n = 4;
            break;
        case "semester":
            $n = 2;
            break;
        case "tahun":
            $n = 1;
            break;
    }

    // Perhitungan berdasarkan jenis bunga
    switch ($jenisBunga) {
        case "tunggal":
            // Rumus bunga tunggal
            $totalBunga = $nom * $bunga / 100 * $waktu;
            $total = $nom + $totalBunga;
            break;
        case "majemuk":
            // Rumus bunga majemuk
            $modalAwal = $nom;
            $sukuBunga = $bunga / 100;
            $konversiLamaPinjaman = $waktu / 12;
            $modalAkhir = $modalAwal * pow((1 + ($sukuBunga / $n)), ($n * $konversiLamaPinjaman));
            $modalAkhir = round($modalAkhir, 4); // Membulatkan hasil ke 4 desimal
            $totalBunga = $modalAkhir - $modalAwal;
            $total = $modalAkhir;
            break;
    }

    $str = "<div class='card my-3 bg-primary text-white'>
    <div class='card-body text-center'>
        <p class='ms-2 mb-0'>Total pinjaman awal Rp. " . number_format($nom, 0, ',', '.') . "</p> 
        <p class='ms-2 mb-0'>Bunga per $persen adalah $bunga% </p> 
        <p class='ms-2 mb-0'>Total nominal pinjaman final Rp. " . number_format($total, 0, ',', '.') . " setelah $waktu bulan </p> 
        <button onclick=window.print() class='mawang container btn btn-success form-control mt-3' type='submit' name='print'>Print</button>
    </div>
    </div>";
    echo $str;
} else {
    echo '
    <div class="alert alert-danger my-3" role="alert">
    Silahkan Masukan Nominal, Persentase bunga, dan Periode waktu
    </div>';
}
?>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script>
        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters
            let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Add thousand separators
            input.value = formattedValue ? 'Rp. ' + formattedValue : '';
        }
    </script>
</body>

</html>