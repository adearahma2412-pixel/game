<?php
session_start();

// ======================================================
// INISIALISASI PERMAINAN
// ======================================================

// Membuat angka rahasia secara acak dari 1 sampai 5
if (!isset($_SESSION['angka'])) {
    $_SESSION['angka'] = rand(1, 5);
}

// Membuat jumlah percobaan jika belum tersedia
if (!isset($_SESSION['percobaan'])) {
    $_SESSION['percobaan'] = 0;
}

// Mengambil angka rahasia dari session
$x = $_SESSION['angka'];

// Mengambil jumlah percobaan
$percobaan = $_SESSION['percobaan'];

// Variabel untuk pesan hasil
$pesan = "";
$jenis_pesan = "";

// Menentukan apakah permainan sudah selesai
$game_selesai = false;

// ======================================================
// PROSES TEBAKAN
// ======================================================

if (isset($_POST['tebak'])) {

    // Mengambil angka yang dimasukkan pengguna
    $tebakan = $_POST['tebak'];

    // ==================================================
    // VALIDASI INPUT
    // ==================================================

    if ($tebakan < 1 || $tebakan > 5) {

        $pesan = "⚠️ INPUT TIDAK VALID!<br>
                  Silakan masukkan angka dari <strong>1 sampai 5</strong>.";

        $jenis_pesan = "salah";

    } else {

        // Menambahkan jumlah percobaan
        $_SESSION['percobaan']++;

        // Memperbarui jumlah percobaan
        $percobaan = $_SESSION['percobaan'];

        // ==================================================
        // CEK JAWABAN
        // ==================================================

        if ($tebakan == $x) {

            $pesan = "🎉 TEBAKAN BENAR!<br>
                      Angka rahasianya adalah <strong>$x</strong><br>
                      Kamu berhasil dalam <strong>$percobaan percobaan</strong>.";

            $jenis_pesan = "benar";

            // Permainan selesai
            $game_selesai = true;

            // Menghapus session
            unset($_SESSION['angka']);
            unset($_SESSION['percobaan']);

        } elseif ($percobaan >= 3) {

            // ==================================================
            // GAME OVER
            // ==================================================

            $pesan = "💀 GAME OVER!<br>
                      Kamu sudah menggunakan semua kesempatan.<br>
                      Angka yang benar adalah <strong>$x</strong>.";

            $jenis_pesan = "game-over";

            // Menandai permainan selesai
            $game_selesai = true;

            // Menghapus session setelah game selesai
            unset($_SESSION['angka']);
            unset($_SESSION['percobaan']);

        } elseif ($tebakan < $x) {

            $sisa = 3 - $percobaan;

            $pesan = "⬆️ TEBAKAN TERLALU KECIL!<br>
                      Coba angka yang lebih besar.<br>
                      Masih ada <strong>$sisa kesempatan</strong>.";

            $jenis_pesan = "salah";

        } else {

            $sisa = 3 - $percobaan;

            $pesan = "⬇️ TEBAKAN TERLALU BESAR!<br>
                      Coba angka yang lebih kecil.<br>
                      Masih ada <strong>$sisa kesempatan</strong>.";

            $jenis_pesan = "salah";
        }
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

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

        .logo {

            font-size: 65px;

            margin-bottom: 10px;

            text-shadow:
                0 0 10px #22d3ee,
                0 0 25px #22d3ee;
        }

        h1 {

            color: #22d3ee;

            font-size: 28px;

            letter-spacing: 2px;

            text-shadow: 0 0 10px #22d3ee;

            margin-bottom: 10px;
        }

        .subtitle {

            color: #94a3b8;

            font-size: 14px;

            margin-bottom: 25px;
        }

        .rules {

            text-align: left;

            background: #020617;

            border-left: 4px solid #a855f7;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 20px;

            color: #cbd5e1;

            line-height: 1.7;
        }

        .rules strong {

            color: #a855f7;
        }

        .attempt {

            background: #0f172a;

            border: 1px solid #334155;

            padding: 10px;

            border-radius: 8px;

            margin-bottom: 20px;

            color: #cbd5e1;

            font-size: 14px;
        }

        .attempt strong {

            color: #22d3ee;
        }

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

        input:focus {

            border-color: #22d3ee;

            box-shadow: 0 0 12px #22d3ee;
        }

        button {

            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 8px;

            background:
                linear-gradient(
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

        button:hover {

            transform: translateY(-2px);

            box-shadow:
                0 0 15px #22d3ee,
                0 0 25px #8b5cf6;
        }

        .hasil {

            margin-top: 20px;

            padding: 15px;

            border-radius: 8px;

            line-height: 1.7;

            font-weight: bold;
        }

        .benar {

            background: rgba(34, 197, 94, 0.15);

            border: 1px solid #22c55e;

            color: #4ade80;

            box-shadow:
                0 0 12px rgba(34, 197, 94, 0.4);
        }

        .salah {

            background: rgba(239, 68, 68, 0.15);

            border: 1px solid #ef4444;

            color: #f87171;

            box-shadow:
                0 0 12px rgba(239, 68, 68, 0.3);
        }

        /* Tampilan khusus Game Over */
        .game-over {

            background: rgba(127, 29, 29, 0.25);

            border: 2px solid #ef4444;

            color: #f87171;

            box-shadow:
                0 0 15px rgba(239, 68, 68, 0.5);
        }

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

        <strong>⚡ GAME RULES</strong><br>

        • Pilih angka dari <b>1 sampai 5</b><br>

        • Kamu memiliki <b>3 kesempatan</b><br>

        • Angka rahasia tetap sama selama permainan<br>

        • Tebak angka dengan tepat untuk menang!

    </div>

    <div class="attempt">

        Percobaan:
        <strong><?php echo $percobaan; ?> / 3</strong>

    </div>

    <?php if (!$game_selesai) { ?>

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

    <?php } ?>

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