<?php

namespace Informer\Utils;

class FileUtils {

    public static function forceFilePutContents($filepath, $data) {
        try {
            $isInFolder = preg_match("/^(.*)\/([^\/]+)$/", $filepath, $filepathMatches);
            if ($isInFolder) {
                $folderName = $filepathMatches[1];
                $fileName = $filepathMatches[2];
                if (!is_dir($folderName)) {
                    mkdir($folderName, DIR_PERMISSION, true);
                }
            }
            file_put_contents($filepath, $data);
        } catch (Exception $e) {
            echo "ERR: error writing - , " . $e->getMessage();
        }
    }

}
