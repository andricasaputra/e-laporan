<?php

namespace App\Http\Controllers;

class TanggalController
{
    const SERVER_TIMEZONE = 'Asia/Makassar';

    const SERVER_DATEFORMAT = 'Y-m-d';

    public static function bulanTahun(string $tanggal) : string
    {
        $bulan = array(

            1 => 'Januari',

            'Februari',

            'Maret',

            'April',

            'Mei',

            'Juni',

            'Juli',

            'Agustus',

            'September',

            'Oktober',

            'November',

            'Desember',

        );

        $pecahkan = explode('-', $tanggal);

        return $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];

    }

    public static function balikTanggal(string $tanggal) : string
    {
        $bulan = array(

            'Januari'   => '1',

            'Februari'  => '2',

            'Pebruari'  => '2',

            'Maret'     => '3',

            'April'     => '4',

            'Mei'       => '5',

            'Juni'      => '6',

            'Juli'      => '7',

            'Agustus'   => '8',

            'September' => '9',

            'Oktober'   => '10',

            'November'  => '10',

            'Nopember'  => '10',

            'Desember'  => '12',

        );

        $pecahkan = explode(' ', $tanggal);

        return $pecahkan[2] . '-' . $bulan[$pecahkan[1]] . '-' . $pecahkan[0];

    }

    public static function balikTanggalVersi2(string $tanggal) : string
    {
        $bulan = array(

            'Januari'   => '1',

            'Februari'  => '2',

            'Pebruari'  => '2',

            'Maret'     => '3',

            'April'     => '4',

            'Mei'       => '5',

            'Juni'      => '6',

            'Juli'      => '7',

            'Agustus'   => '8',

            'September' => '9',

            'Oktober'   => '10',

            'November'  => '10',

            'Nopember'  => '10',

            'Desember'  => '12',

        );

        $pecahkan = explode(' ', $tanggal);

        if ($bulan[$pecahkan[1]] < 10) {

            $bulannya = "0" . $bulan[$pecahkan[1]];

        } else {

            $bulannya = $bulan[$pecahkan[1]];
        }

        return $pecahkan[0] . '/' . $bulannya . '/' . $pecahkan[2];

    }

    public static function tanggalIndo(string $tanggal) : string
    {
        $bulan = array(

            1 => 'Januari',

            'Februari',

            'Maret',

            'April',

            'Mei',

            'Juni',

            'Juli',

            'Agustus',

            'September',

            'Oktober',

            'November',

            'Desember',

        );

        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];

    }

    public static function tanggalIndoVersi2(string $tanggal) : string
    {
        $bulan = array(

            1 => 'Januari',

            'Februari',

            'Maret',

            'April',

            'Mei',

            'Juni',

            'Juli',

            'Agustus',

            'September',

            'Oktober',

            'November',

            'Desember',

        );

        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]];

    }

    public static function bulan($bln) : string
    {
        $bulan = $bln;

        switch ($bulan) {

            case 1:$bulan = "Januari";

                break;

            case 2:$bulan = "Februari";

                break;

            case 3:$bulan = "Maret";

                break;

            case 4:$bulan = "April";

                break;

            case 5:$bulan = "Mei";

                break;

            case 6:$bulan = "Juni";

                break;

            case 7:$bulan = "Juli";

                break;

            case 8:$bulan = "Agustus";

                break;

            case 9:$bulan = "September";

                break;

            case 10:$bulan = "Oktober";

                break;

            case 11:$bulan = "November";

                break;

            case 12:$bulan = "Desember";

                break;

        }

        return $bulan;

    }

    public static function hari(string $tanggal) : string
    {
        $hari = date('l', microtime($tanggal));

        $hari_indonesia = array(

            'Monday' => 'Senin',

            'Tuesday' => 'Selasa',

            'Wednesday' => 'Rabu',

            'Thursday' => 'Kamis',

            'Friday' => 'Jum' . "'" . 'at',

            'Saturday' => 'Sabtu',

            'Sunday' => 'Minggu'

        );

        $hari_ini = $hari_indonesia[$hari];

        return $hari_ini;

    }

    public static function sekarang() : string
    {
        date_default_timezone_set(self::SERVER_TIMEZONE);

        $date = new \DateTime('now');

        $date->setTimezone(new \DateTimeZone(self::SERVER_TIMEZONE));

        $str_server_now = $date->format(self::SERVER_DATEFORMAT);

        return $str_server_now;
    }

    public static function besok() : string
    {
        date_default_timezone_set(self::SERVER_TIMEZONE);

        $date = new \DateTime('tomorrow');

        $date->setTimezone(new \DateTimeZone(self::SERVER_TIMEZONE));

        $str_server_tom = $date->format(self::SERVER_DATEFORMAT);

        return $str_server_tom;
    }

}
