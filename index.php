
<?php
// 1. Array multidimensi mata kuliah
$matkul = [
    ["nama" => "Algoritma dan Pemrograman", "sks" => 3, "nilai" => 85],
    ["nama" => "Basis Data", "sks" => 3, "nilai" => 78],
    ["nama" => "Matematika Diskrit", "sks" => 3, "nilai" => 65],
    ["nama" => "Jaringan Komputer", "sks" => 2, "nilai" => 55],
    ["nama" => "Sistem Digital", "sks" => 2, "nilai" => 92]
];

// 2. Fungsi helper untuk menghitung huruf dan bobot
function hitungBobot($nilai)
{
    if ($nilai >= 80) {
        return ["huruf" => "A", "bobot" => 4.0];
    } elseif ($nilai >= 70) {
        return ["huruf" => "B", "bobot" => 3.0];
    } elseif ($nilai >= 60) {
        return ["huruf" => "C", "bobot" => 2.0];
    } elseif ($nilai >= 50) {
        return ["huruf" => "D", "bobot" => 1.0];
    } else {
        return ["huruf" => "E", "bobot" => 0.0];
    }
}

// Variabel untuk menghitung IPS
$totalSKS = 0;
$totalMutu = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Nilai Mata Kuliah</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f9;
        }

        h2, h3 {
            color: #243447;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #263b59;
            color: white;
        }

        .mengulang {
            background-color: #ffcccc;
            color: #b00020;
        }

        .ringkasan {
            background: white;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<h2>Daftar Nilai Mata Kuliah</h2>

<table>
    <tr>
        <th>No</th>
        <th>Nama Mata Kuliah</th>
        <th>SKS</th>
        <th>Nilai Angka</th>
        <th>Nilai Huruf</th>
        <th>Bobot</th>
        <th>Status</th>
    </tr>

    <?php foreach ($matkul as $index => $mk): ?>
        <?php
            // Mengambil nilai huruf dan bobot
            $hasil = hitungBobot($mk["nilai"]);

            // Menentukan status kelulusan
            $status = ($hasil["bobot"] >= 2.0)
                ? "LULUS"
                : "MENGULANG";

            // Menghitung total SKS dan mutu
            $totalSKS += $mk["sks"];
            $totalMutu += $mk["sks"] * $hasil["bobot"];

            // Memberi warna merah jika mengulang
            $kelas = ($status == "MENGULANG")
                ? "mengulang"
                : "";
        ?>

        <tr class="<?= $kelas ?>">
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($mk["nama"]) ?></td>
            <td><?= $mk["sks"] ?></td>
            <td><?= $mk["nilai"] ?></td>
            <td><?= $hasil["huruf"] ?></td>
            <td><?= number_format($hasil["bobot"], 1) ?></td>
            <td><?= $status ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
// 3. Menghitung IPS
$ips = ($totalSKS > 0)
    ? $totalMutu / $totalSKS
    : 0;

// 4. Menentukan batas SKS semester depan
$batasSKS = ($ips >= 3.00) ? 24 : 20;
?>

<div class="ringkasan">
    <h3>Ringkasan IPS</h3>

    <p>Total SKS: <?= $totalSKS ?></p>

    <p>Total Mutu: <?= number_format($totalMutu, 2) ?></p>

    <p>IPS:
        <strong><?= number_format($ips, 2) ?></strong>
    </p>

    <p>Batas Maksimal SKS Semester Depan:
        <strong><?= $batasSKS ?> SKS</strong>
    </p>
</div>

</body>
</html>
