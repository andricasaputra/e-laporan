<?php

namespace App\Http\Controllers\Operasional\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DatabaseManagerController extends Controller
{
	/**
     * Untuk menyimpan nama database
     *
     * @var string
     */
	private $db;

	/**
     * Set nama database
     *
     * @return void
     */
	private function setDbName()
	{
		$this->db = "Tables_in_" . env('DB_DATABASE');

		return $this;
	}

	/**
     * Mengambil nama database
     *
     * @return string
     */
	private function getDbName()
	{
		return $this->setDbName()->db;
	}

	/**
     * Menjalankan proses export database
     *
     * @return void
     */
    private function exportProccess()
    {
    	set_time_limit(3000);

    	$pdo = DB::connection()->getPdo();

        $queryTables = DB::statement("SET NAMES 'utf8'");

        $allTables = DB::select('SHOW TABLES');

        $db = $this->getDbName();

        foreach ($allTables as $table) {

        	// ignore backup views table
        	if(strpos($table->{$this->db}, 'v_') === false){

        		$targetTables[] = $table->{$this->db};

        	}

        }
   
        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . DB::getDatabaseName() . "` \r\n--\r\n\r\n\r\n";

        foreach ($targetTables as $table) {

            if (empty($table)) {

                continue;

            }

        	$result        = $pdo->prepare('SELECT * FROM `' . $table . '`');

            $result->execute();

            $fieldsAmount  = $result->columnCount();

            $rowsNum       = $result->rowCount();

            $res           = $pdo->prepare('SHOW CREATE TABLE ' . $table);

            $res->execute();

            $TableMLine    = $res->fetchAll(\PDO::FETCH_NUM)[0];

            $content 	  .= "\n\n" . $TableMLine[1] . ";\n\n";

            $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);

            for ($i = 0, $stCounter = 0; $i < $fieldsAmount; $i++, $stCounter = 0) {

            	foreach ($result->fetchAll(\PDO::FETCH_NUM) as $row) :

                    //when started (and every after 100 command cycle):
                    if ($stCounter % 100 == 0 || $stCounter == 0) {

                        $content .= "\nINSERT INTO " . $table . " VALUES";

                    }

                    $content .= "\n(";

                    for ($j = 0; $j < $fieldsAmount; $j++) {

                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));

                        if (isset($row[$j])) {

                            $content .= '"' . $row[$j] . '"';

                        } else {

                            $content .= '""';
                        }

                        if ($j < ($fieldsAmount - 1)) {

                            $content .= ',';

                        }
                    }

                    $content .= ")";

                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ((($stCounter + 1) % 100 == 0 && $stCounter != 0) || $stCounter + 1 == $rowsNum) {

                        $content .= ";";

                    } else {

                        $content .= ",";

                    }

                    $stCounter = $stCounter + 1;

                endforeach;
            }

            $content .= "\n\n\n";
           
        }

        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

        $backupName =  DB::getDatabaseName().'_(' . date('H:i:s') . '_' . date('d-m-Y') . ').sql';

        ob_get_clean();

        header('Content-Type: application/octet-stream');

        header("Content-Transfer-Encoding: Binary");

        header('Content-Length: ' . (function_exists('mb_strlen') 
        		? mb_strlen($content, '8bit') 
        		: strlen($content))
    		  );

        header("Content-disposition: attachment; filename=\"" . $backupName . "\"");

        echo $content;

        exit;
    }

    /**
     * Menjalankan proses import database
     *
     * @return void
     */
    private function importProccess($sqlFile)
    {
    	set_time_limit(3000);

        $sqlFileContent = (strlen($sqlFile->file('filesql')->getRealPath()) > 300 
        					? $sqlFile->file('filesql')->getRealPath() 
        					: file_get_contents($sqlFile->file('filesql')->getRealPath()));

        $allLines    	= explode("\n", $sqlFileContent);

        $setkey 		= DB::statement('SET foreign_key_checks = 0');

        // normal table
        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $sqlFileContent, $targetTables);

        // view table
        preg_match_all("/SQL SECURITY DEFINER VIEW(.*?)\`(.*?)\`/si", "\n" . $sqlFileContent, $targetViewTables);

        foreach ($targetTables[2] as $table) {

            $tableName = DB::statement('DROP TABLE IF EXISTS ' . $table);
        }

        foreach ($targetViewTables[2] as $tableView) {

            $tableViewName = DB::statement('DROP VIEW ' . $tableView);
        }

        $setutf 	= DB::statement("SET NAMES 'utf8'");

        // Temporary variable, used to store current query
        $templine 	= ''; 

        // Loop through each line
        foreach ($allLines as $line) {

            if (substr($line, 0, 2) != '--' && $line != '') {

            	// (if it is not a comment..) Add this line to the current segment
                $templine .= $line; 

                if (substr(trim($line), -1, 1) == ';') {

                    // If it has a semicolon at the end, it's the end of the query
                    try {

                    	DB::statement($templine);

                    } catch (Exception $e) {

                    	die('Error performing query \'<strong>' . $templine . '\': ' . $e . '<br /><br />');

                    }

                    $templine = ''; 
                }
            }
        }

        $this->restoreViewTables();

        return back()->withSuccess('Restore Database Berhasil!');
    }

    /**
     * Berfungsi sebagai creator views table
     *
     * @return void
     */
    private function restoreViewTables()
    {
    	DB::statement("DROP VIEW v_rekap_komoditi_dokel_kh");

    	DB::statement("DROP VIEW v_rekap_komoditi_dokel_kt");

    	DB::statement("DROP VIEW v_rekap_komoditi_domas_kh");

    	DB::statement("DROP VIEW v_rekap_komoditi_domas_kt");

    	DB::statement("DROP VIEW v_rekap_komoditi_ekspor_kh");

    	DB::statement("DROP VIEW v_rekap_komoditi_ekspor_kt");

    	DB::statement("DROP VIEW v_rekap_komoditi_impor_kh");

    	DB::statement("DROP VIEW v_rekap_komoditi_impor_kt");

    	DB::statement("DROP VIEW v_rekap_komoditi_reekspor_kh");

    	DB::statement("DROP VIEW v_rekap_komoditi_reekspor_kt");

    	DB::statement("DROP VIEW v_rekap_komoditi_serah_terima_kh");

    	DB::statement("DROP VIEW v_rekap_komoditi_serah_terima_kt");

    	DB::statement("DROP VIEW v_pemakaian_dokumen_kh");

    	DB::statement("DROP VIEW v_pemakaian_dokumen_kt");

    	DB::statement("CREATE VIEW v_rekap_komoditi_dokel_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                bulan, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi 
                        FROM dokel_kh
                        WHERE nama_mp != ''
                        GROUP BY nama_mp, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_dokel_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                bulan,
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM dokel_kt
                        WHERE nama_komoditas != ''
                        GROUP BY nama_komoditas, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_domas_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                bulan, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi  
                        FROM domas_kh
                        WHERE nama_mp != ''
                        GROUP BY nama_mp, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_domas_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                bulan, 
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM domas_kt
                        WHERE nama_komoditas != ''
                        GROUP BY nama_komoditas, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_ekspor_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                bulan, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi 
                        FROM ekspor_kh
                        WHERE nama_mp != ''
                        GROUP BY nama_mp, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_ekspor_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                bulan, 
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM ekspor_kt
                        WHERE nama_komoditas != ''
                        GROUP BY nama_komoditas, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_impor_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                bulan, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi 
                        FROM impor_kh
                        WHERE nama_mp != ''
                        GROUP BY nama_mp, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_impor_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                bulan, 
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM impor_kt
                        WHERE nama_komoditas != ''
                        GROUP BY nama_komoditas, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_reekspor_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                bulan, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi 
                        FROM reekspor_kh
                        WHERE nama_mp != ''
                        GROUP BY nama_mp, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_reekspor_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                bulan, 
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM reekspor_kt
                        WHERE nama_komoditas != ''
                        GROUP BY nama_komoditas, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_serah_terima_kh AS
                        SELECT  id, 
                                wilker_id,
                                satuan, 
                                nama_mp,
                                bulan, 
                                sum(jumlah) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(satuan) as frekuensi 
                        FROM serah_terima_kh
                        WHERE nama_mp != ''
                        GROUP BY nama_mp, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_rekap_komoditi_serah_terima_kt AS
                        SELECT  id, 
                                wilker_id,
                                sat_netto, 
                                nama_komoditas,
                                bulan, 
                                sum(volume_netto) as volume, 
                                sum(total_pnbp) as pnbp,
                                count(sat_netto) as frekuensi 
                        FROM serah_terima_kt
                        WHERE nama_komoditas != ''
                        GROUP BY nama_komoditas, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_pemakaian_dokumen_kh AS

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM dokel_kh
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION 

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM domas_kh
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM ekspor_kh
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM impor_kh
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id
                    ");

    	DB::statement("CREATE VIEW v_pemakaian_dokumen_kt AS

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM dokel_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION 

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM domas_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM ekspor_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id

                        UNION

                        SELECT  wilker_id,
                                dok_pelepasan as dokumen, 
                                bulan,
                                count(dok_pelepasan) as jumlah,
                                CONCAT(min(no_seri), '-', max(no_seri)) as no_seri
                        FROM impor_kt
                        WHERE dok_pelepasan IS NOT NULL AND dok_pelepasan != ''
                        GROUP BY dokumen, bulan, wilker_id
                    ");
    }

    /**
     * Export database yang dipanggil pada route
     *
     * @return void
     */
    public function export()
    {
    	$this->exportProccess();
    }

    /**
     * Import database yang dipanggil pada route
     *
     * @return void
     */
    public function import(Request $sqlFile)
    {
    	if (! $sqlFile->has('filesql')) {

    		return back()->withWarning('Pilih File sql untuk diunggah!');

    	}

    	$sqlFile->validate(['filesql' => 'required']);

    	$extension = $sqlFile->file('filesql')->getClientOriginalExtension();

    	if ($extension == 'sql' || $extension == 'zip' || $extension == 'rar') {

    		return $this->importProccess($sqlFile);

    	}

    	return back()->withWarning('File yang diunggah harus berupa sql, zip atau rar');	
    }

    /**
     * Menampilkan halaman menu untuk database management
     *
     * @return void
     */
    public function menu()
    {
    	return view('intern.operasional.admin.setting.database.menu');
    }

    /**
     * Menampilkan halaman import database
     *
     * @return void
     */
    public function importPage()
    {
    	return view('intern.operasional.admin.setting.database.import');
    }
}
