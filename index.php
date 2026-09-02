<?php
include 'koneksi.php';

// ambil data anggota
$anggota = mysqli_query($conn, "SELECT * FROM anggota");

// proses submit
if (isset($_POST['submit'])) {

    $nomor = $_POST['nomor'];
    $status = $_POST['status'];
    $tanggal = date("Y-m-d");

    // cek apakah sudah ada hari ini
    $cek = mysqli_query($conn, "SELECT * FROM presensi 
        WHERE nomor_absen='$nomor' AND tanggal='$tanggal'");

    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE presensi 
            SET status='$status' 
            WHERE nomor_absen='$nomor' AND tanggal='$tanggal'");
    } else {
        mysqli_query($conn, "INSERT INTO presensi (nomor_absen, tanggal, status) 
            VALUES ('$nomor', '$tanggal', '$status')");
    }

    header("Location: index.php?pesan=berhasil");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran Member Neet</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .container-box {
            /* background: linear-gradient(135deg, #7E60BF, #433878); */
            background-color: #433878;
            padding: 25px;
            border-radius: 16px;
            margin-top: 50px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-box {
            background-color: #ffeeff;
            padding: 20px;
            border-radius: 12px;
        }

        h5 {
            color: #ffffff;
            font-weight: 600;
        }

        label {
            color: #374151;
            font-weight: 500;
        }

        input,
        select {
            border-radius: 8px !important;
        }

        button {
            border-radius: 10px !important;
        }

        .btn {
            background-color: #7E60BF;
            color: #ffffff;
            border: none;
            transition: all 0.3s ease;
        }

        /* 🔥 efek hover glow merah */
        .btn:hover {
            color: #ffffff;
            background-color: #7E60BF;
        }

        /* biar pas diklik ada efek tekan */
        .btn:active {
            transform: scale(0.97);
            box-shadow: #7E60BF;
        }

        .notif {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            background: #16a34a;
            /* hijau */
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: 0.5s;
        }

        label {
            padding-bottom: 4px;
            font-weight: 500;
        }
    </style>

</head>

<script>
    window.onload = function () {
        const notif = document.getElementById("notif");

        if (notif) {
            // munculin
            setTimeout(() => {
                notif.style.top = "20px";
            }, 100);

            // hilang lagi
            setTimeout(() => {
                notif.style.top = "-100px";
            }, 3000);
        }
    };
</script>

<body>

    <div class="container p-4">
        <div class="container-box">

            <h5 class="text-center mb-4">Kehadiran Member Neet</h5>

            <div class="form-box">

                <form method="POST">

                    <!-- 1. NAMA -->
                    <div class="mb-3">
                        <label>Nama</label>
                        <select class="form-select" name="nomor" id="namaSelect" required>
                            <option value="">Pilih Nama</option>
                            <?php while ($a = mysqli_fetch_array($anggota)) { ?>
                                <option value="<?= $a['id']; ?>">
                                    <?= $a['nama']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- 2. NOMOR ABSEN -->
                    <div class="mb-3">
                        <label>Nomor Absen</label>
                        <input type="text" id="nomorAbsen" class="form-control" readonly>
                    </div>

                    <!-- 3. TANGGAL -->
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>" readonly>
                    </div>

                    <!-- 4. STATUS -->
                    <div class="mb-3">
                        <label>Status Absensi</label>
                        <select class="form-select" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="1">Hadir</option>
                            <option value="2">Absen</option>
                            <option value="3">Sudah izin atmin</option>
                        </select>
                    </div>

                    <!-- 5. SUBMIT -->
                    <button type="submit" name="submit" class="btn w-100">
                        Kirim
                    </button>

                </form>

                <?php if (isset($_GET['pesan']) && $_GET['pesan'] == "berhasil") { ?>
                    <div id="notif" class="notif">
                        ✅ Telah absen!
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>

    <script>
        const selectNama = document.getElementById("namaSelect");
        const nomorInput = document.getElementById("nomorAbsen");

        selectNama.addEventListener("change", function () {
            nomorInput.value = this.value;
        });
    </script>

</body>

</html>