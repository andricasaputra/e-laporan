<?php

namespace App\Http\Controllers\Operasional\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

    	try {

            $pdo = DB::connection()->getPdo();

            $queryTables = DB::statement("SET NAMES 'utf8'");

            $allTables = DB::select('SHOW TABLES');

            $db = $this->getDbName();

            foreach ($allTables as $table) {

                // ignore backup views table
                if (@$table->{$db}) {

                    if(strpos($table->{$db}, 'v_') === false){

                        $targetTables[] = $table->{$db};

                    }

                } else {

                    return false;

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

                $content      .= "\n\n" . $TableMLine[1] . ";\n\n";

                $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);

                for ($i = 0, $stCounter = 0; $i < $fieldsAmount; $i++, $stCounter = 0) {

                    foreach ($result->fetchAll(\PDO::FETCH_NUM) as $row) :

                        //when started (and every after 100 command cycle):
                        if ($stCounter % 100 == 0 || $stCounter == 0) {

                            $content .= "\nINSERT INTO `" . $table . "` VALUES";

                        }

                        $content .= "\n(";

                        for ($j = 0; $j < $fieldsAmount; $j++) {

                            $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));

                            if (isset($row[$j])) {

                                $content .= empty($row[$j]) ? 'NULL' : "'" . $row[$j] . "'";

                            } else {

                                $content .= "''";
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

            $zip = new \ZipArchive();

            // set unique file name
            $fileName = DB::getDatabaseName() . '_' . str_random(7) . microtime(true);

            // set file to sql extension
            $fileSql  = $fileName  . '.sql';

            // put to storage
            Storage::put($fileSql, $content);

            // then move it to desire folder
            Storage::move($fileSql, 'backup/e-operasional/'. $fileSql); 

            // now if file sql exist in storage we going to zip this file
            if (file_exists(storage_path('app/backup/e-operasional/' . $fileSql))) {

                // set file to zip extension
                $fileZip = $fileName . '.zip';

                // create zip file
                if ($zip->open($fileZip, \ZipArchive::CREATE) !== true) {

                    exit("cannot open $fileName \n");

                }

                // add file to public directory
                $zip->addFile(storage_path('app/backup/e-operasional/' . $fileSql));

                // close zipping proccess
                $zip->close();

                // lastly we move sql file from public folder to our storage directory
                rename(public_path() . '/' . $fileZip, storage_path('app/backup/e-operasional/' . $fileZip));

                return true;

            }

            return false;
                 
        } catch (Exception $e) {
                
            return false;
        }     
    }

    /**
     * Menjalankan proses import database
     *
     * @return void
     */
    private function importProccess(Request $sqlFile)
    {
    	set_time_limit(3000);

        $sqlFileContent = $this->sqlFileRequest($sqlFile);

        $allLines    	= explode("\n", $sqlFileContent);

        $setkey 		= DB::statement('SET foreign_key_checks = 0');

        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $sqlFileContent, $targetTables);

        foreach ($targetTables[2] as $table) {

            DB::statement('DROP TABLE IF EXISTS ' . $table);
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

        return back()->withSuccess('Restore Database Berhasil!');
    }

    /**
     * Mengambil content dari file .sql
     *
     * @return string
     */
    private function sqlFileRequest(Request $sqlFile)
    {
        return (strlen($sqlFile->file('filesql')->getRealPath()) > 300 
                ? $sqlFile->file('filesql')->getRealPath() 
                : file_get_contents($sqlFile->file('filesql')->getRealPath()));

    }

    /**
     * Mengambil content dari file .zip
     *
     * @return string
     */
    private function zipFileRequest(Request $zipFile)
    {
        // soon
    }

    /**
     * Export database yang dipanggil pada route
     *
     * @return void
     */
    public function export()
    {
    	if ($this->exportProccess()) {

            return redirect(route('database.menu'))
                    ->withSuccess('Berhasil unduh database');
        }

        return redirect(route('database.menu'))
                ->withWarning('Terjadi kesalahan pada server, harap coba kembali dalam beberapa saat :(');
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

    	if ($extension == 'sql') {

    		return $this->importProccess($sqlFile);

    	}

    	return back()->withWarning('File yang diunggah harus berupa sql');	
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
