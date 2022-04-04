<?php

class Kalkulator
{
    protected int $totalBaterai;
    protected int $dayaPakaiBaterai = 10;

    public function __construct()
    {
        $this->totalBaterai = 0;
    }
    public function __destruct()
    {
        echo PHP_EOL . "---------- Program telah berakhir ----------" . PHP_EOL . PHP_EOL;
    }

    // Function validasi 
    // jika sisa baterai kurang dari penggunaan baterai, user diminta untuk isi daya
    protected function validasiProses(int $result){
        if ($this->totalBaterai - $this->dayaPakaiBaterai < 0) {
            echo PHP_EOL."Sisa baterai anda $this->totalBaterai%, Membutuhkan $this->dayaPakaiBaterai% baterai untuk menjalankan proses ini. ". PHP_EOL 
            ."Segera isi daya baterai anda!!!" . PHP_EOL . PHP_EOL;
            return false;
        }else{
            $this->totalBaterai -= $this->dayaPakaiBaterai;
            return $result;
        }
    }

    // ---------- Function Proses Perhitungan -----------------

    public function penambahan(int $number1, int $number2)
    {
        return $this->validasiProses($number1 + $number2);
    }

    public function pengurangan(int $number1, int $number2)
    {
        return $this->validasiProses($number1 - $number2);
    }

    public function perkalian(int $number1, int $number2)
    {
        return $this->validasiProses($number1 * $number2);
    }

    public function pembagian(int $number1, int $number2)
    {
        return $this->validasiProses($number1 / $number2);
    }

    public function perpangkatan(int $number1, int $number2)
    {
        return $this->validasiProses(pow($number1, $number2));
    }

    // --------------------------------------------------------

    public function isiDaya()
    {
        $this->totalBaterai += 20;
        echo PHP_EOL."Sekarang baterai anda $this->totalBaterai%" . PHP_EOL .PHP_EOL;
    }

    public function tampilHasil($hasil){ // function untuk menampilkan hasil
        if ($hasil !== false) {
            echo "Hasil perhitungan : $hasil" . PHP_EOL . PHP_EOL;
        }
    }
    
    
    public function inputBilanganUser($hasilTerakhir){ // function get data dari user
        if ($hasilTerakhir == null) {
            echo PHP_EOL."Bilangan 1 : ";
            $input_bil_pertama = fopen("php://stdin", "r");
            $bil_pertama = (int)trim(fgets($input_bil_pertama));
        } else{
            $bil_pertama = $hasilTerakhir;
            echo PHP_EOL."Hasil Sebelumnya: ".$bil_pertama.PHP_EOL;
        }
        echo "Bilangan 2 : ";
        $input_bil_kedua = fopen("php://stdin", "r");
        $bil_kedua = (int)trim(fgets($input_bil_kedua));
    
        return array($bil_pertama,$bil_kedua);
    }
}


class KalkulatorHemat extends Kalkulator
{
    protected int $dayaPakaiBaterai = 5;
}

// ------ Function yang akan meng-intansiasi / pembuatan objek --------- 

function KelasKalkulator()
{
    $kalkulator = new Kalkulator(); // Objek dari kelas Kalkulator
    prosesOperasi($kalkulator);
}

function KelasKalkulatorHemat()
{
    $kalkulator = new KalkulatorHemat(); // Objek dari kelas KalkulatorHemat
    prosesOperasi($kalkulator);
}

// ----------------------------------------------------------------------

function limit(int $hasil) // Function untuk membatasi sebuah hasil
{
    if($hasil > 1000000){
        echo PHP_EOL . "Nilai diluar batas yang ditentukan" . PHP_EOL . PHP_EOL;
        return $hasil = 0;
    }else{
        return $hasil;
    }
}





function prosesOperasi($kalkulator) // function proses
{
    $hasilTerakhir = null;

    while (true) {
        echo "Pilih salah satu operasi yang kamu inginkan?" . PHP_EOL;
        echo "1. Penambahan" . PHP_EOL;
        echo "2. Pengurangan" . PHP_EOL;
        echo "3. Perkalian" . PHP_EOL;
        echo "4. Pembagian" . PHP_EOL;
        echo "5. Perpangkatan" . PHP_EOL;
        echo "6. isi Daya" . PHP_EOL;
        echo "7. Keluar" . PHP_EOL;
        echo "Operasi : ";
        $input_operasi = fopen("php://stdin", "r");
        $operasi = trim(fgets($input_operasi));

        
        if($operasi == '1'){
            $arrayInput = $kalkulator->inputBilanganUser($hasilTerakhir);
            $hasilTerakhir = $kalkulator->penambahan($arrayInput[0], $arrayInput[1]);
            $kalkulator->tampilHasil($hasilTerakhir);
        }else if($operasi == '2'){
            $arrayInput = $kalkulator->inputBilanganUser($hasilTerakhir);
            $hasilTerakhir = $kalkulator->pengurangan($arrayInput[0], $arrayInput[1]);
            $kalkulator->tampilHasil($hasilTerakhir);
        }else if($operasi == '3'){
            $arrayInput = $kalkulator->inputBilanganUser($hasilTerakhir);
            $hasilTerakhir = $kalkulator->perkalian($arrayInput[0], $arrayInput[1]);
            $kalkulator->tampilHasil($hasilTerakhir);
        }else if($operasi == '4'){
            $arrayInput = $kalkulator->inputBilanganUser($hasilTerakhir);
            $hasilTerakhir = $kalkulator->pembagian($arrayInput[0], $arrayInput[1]);
            $kalkulator->tampilHasil($hasilTerakhir);
        }else if($operasi == '5'){
            $arrayInput = $kalkulator->inputBilanganUser($hasilTerakhir);
            $hasilTerakhir = $kalkulator->perpangkatan($arrayInput[0], $arrayInput[1]);
            $kalkulator->tampilHasil(limit($hasilTerakhir));
        }else if ($operasi == '6') {
            $kalkulator->isiDaya();
            continue;
        }else if($operasi == '7'){
            exit();
        }else{
            echo PHP_EOL."Operasi yang anda pilih tidak ada!!!".PHP_EOL.PHP_EOL;
            continue;
        }

        // Decision dengan kondisi variable HasilTerakhir !== false 
        // artinya bila function validasiBaterai mereturn false artinya baterai tidak cukup untuk melakukan proses.
        // Jadi tak perlu menampilkan interaksi user dibawah ini
        if($hasilTerakhir !== false){ 
            echo "Apakah ingin melanjutkan proses? (y/n) ";
            $input_perulangan_proses = fopen("php://stdin", "r");
            $perulangan_proses = trim(fgets($input_perulangan_proses));
            if($perulangan_proses == 'n'){
                $hasilTerakhir = null;
            }
        }
        
    }
}

start:
echo "------- Pilih Jenis Kalkulator -------" . PHP_EOL;
echo "1. Kalkulator" . PHP_EOL;
echo "2. Kalkulator Hemat" . PHP_EOL;
echo "Kalkulator : ";
$input_tipe_kalkulator = fopen("php://stdin", "r");
$tipe_kalkulator = trim(fgets($input_tipe_kalkulator));


if ($tipe_kalkulator == "1") {
    KelasKalkulator();
} elseif ($tipe_kalkulator == "2") {
    KelasKalkulatorHemat();
} else {
    echo PHP_EOL. "Tipe kalkulator yang anda pilih tidak ada!!!" .PHP_EOL.PHP_EOL;
    goto start;    
}