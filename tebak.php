<?php
// Game Tebak Angka menggunakan PHP Session
session_start();

// Membuat angka rahasia hanya sekali
if (!isset($_SESSION['angka'])) {
    $_SESSION['angka'] = rand(1, 5);
    $_SESSION['percobaan'] = 0;
}

// Menyimpan angka rahasia ke dalam variabel
$x = $_SESSION['angka'];

$pesan = "";
$jenis_pesan = "";

// Mengecek apakah tombol tebak ditekan
if (isset($_POST['tebak'])) {

    // Menambah jumlah percobaan
    $_SESSION['percobaan']++;

    $tebakan = $_POST['tebak'];
    $percobaan = $_SESSION['percobaan'];

    // Mengecek apakah tebakan benar
    if ($tebakan == $x) {

        $pesan = "🎉 TEBAKAN BENAR!<br>
                  Angka rahasianya adalah <strong>$x</strong>";

        $jenis_pesan = "benar";

        // Menghapus session setelah permainan selesai
        unset($_SESSION['angka']);
        unset($_SESSION['percobaan']);

    } elseif ($percobaan >= 3) {

        // Jika kesempatan sudah habis
        $pesan = "💀 GAME OVER!<br>
                  Kesempatan kamu sudah habis.<br>
                  Angka yang benar adalah <strong>$x</strong>";

        $jenis_pesan = "salah";

        // Menghapus session setelah game over
        unset($_SESSION['angka']);
        unset($_SESSION['percobaan']);

    } else {

        // Menghitung jumlah kesempatan yang tersisa
        $sisa = 3 - $percobaan;

        $pesan = "⚡ SALAH!<br>
                  Masih ada <strong>$sisa kesempatan</strong>.";

        $jenis_pesan = "salah";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Neon Number Challenge</title>

    <style>

        /* Mengatur semua elemen */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Tampilan halaman */
        body {
            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                radial-gradient(
                    circle at top,
                    #172554,
                    #020617 60%
                );

            color: white;
        }

        /* Kotak utama game */
        .game-box {
            width: 420px;

            padding: 35px;

            background: rgba(15, 23, 42, 0.95);

            border: 2px solid #22d3ee;

            border-radius: 18px;

            text-align: center;

            box-shadow:
                0 0 15px #22d3ee,
                0 0 40px rgba(34, 211, 238, 0.3);
        }

        /* Logo game */
        .logo {
            font-size: 65px;

            margin-bottom: 10px;

            text-shadow:
                0 0 10px #22d3ee,
                0 0 25px #22d3ee;
        }

        /* Judul */
        h1 {
            color: #22d3ee;

            font-size: 28px;

            letter-spacing: 2px;

            text-shadow: 0 0 10px #22d3ee;

            margin-bottom: 10px;
        }

        /* Subtitle */
        .subtitle {
            color: #94a3b8;

            font-size: 14px;

            margin-bottom: 25px;
        }

        /* Kotak aturan */
        .rules {
            text-align: left;

            background: #020617;

            border-left: 4px solid #a855f7;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 25px;

            color: #cbd5e1;

            line-height: 1.7;
        }

        .rules strong {
            color: #a855f7;
        }

        /* Input angka */
        input {
            width: 100%;

            padding: 14px;

            background: #0f172a;

            border: 2px solid #334155;

            border-radius: 8px;

            color: white;

            font-size: 18px;

            text-align: center;

            outline: none;

            margin-bottom: 15px;

            transition: 0.3s;
        }

        /* Efek ketika input dipilih */
        input:focus {
            border-color: #22d3ee;

            box-shadow: 0 0 12px #22d3ee;
        }

        /* Tombol */
        button {
            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 8px;

            background: linear-gradient(
                90deg,
                #06b6d4,
                #8b5cf6
            );

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        /* Efek tombol ketika mouse diarahkan */
        button:hover {
            transform: translateY(-2px);

            box-shadow:
                0 0 15px #22d3ee,
                0 0 25px #8b5cf6;
        }

        /* Kotak hasil */
        .hasil {
            margin-top: 20px;

            padding: 15px;

            border-radius: 8px;

            line-height: 1.7;

            font-weight: bold;
        }

        /* Hasil benar */
        .benar {
            background: rgba(34, 197, 94, 0.15);

            border: 1px solid #22c55e;

            color: #4ade80;

            box-shadow:
                0 0 12px rgba(34, 197, 94, 0.4);
        }

        /* Hasil salah */
        .salah {
            background: rgba(239, 68, 68, 0.15);

            border: 1px solid #ef4444;

            color: #f87171;

            box-shadow:
                0 0 12px rgba(239, 68, 68, 0.3);
        }

        /* Footer */
        .footer {
            margin-top: 25px;

            color: #64748b;

            font-size: 12px;

            letter-spacing: 1px;
        }

    </style>

</head>

<body>

<div class="game-box">

    <div class="logo">
        🎮
    </div>

    <h1>
        NEON NUMBER
    </h1>

    <p class="subtitle">
        CHALLENGE THE SECRET NUMBER
    </p>

    <div class="rules">

        <strong>⚡ GAME RULES</strong>

        <br>

        • Pilih angka dari <b>1 sampai 5</b>

        <br>

        • Kamu memiliki <b>3 kesempatan</b>

        <br>

        • Angka rahasia tetap sama selama permainan

        <br>

        • Tebak angka dengan tepat untuk menang!

    </div>

    <form method="post">

        <input
            type="number"
            name="tebak"
            min="1"
            max="5"
            placeholder="1 - 5"
            required
        >

        <button type="submit">
            🚀 SUBMIT GUESS
        </button>

    </form>

    <?php if ($pesan != "") { ?>

        <div class="hasil <?php echo $jenis_pesan; ?>">

            <?php echo $pesan; ?>

        </div>

    <?php } ?>

    <div class="footer">

        NEON NUMBER CHALLENGE • PHP GAME

    </div>

</div>

</body>

</html>