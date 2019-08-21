<?php

namespace Informer\Utils;

class Log {

    public static function write($mode, $module, $param, $data) {
        if (DEBUG || $mode == 'IMPORTANT') {
            
            if (!is_dir(DEBUG_LOGS_DIR)) {
                mkdir(DEBUG_LOGS_DIR, DIR_PERMISSION, true);
            }
            
            $i = 0;
            $fileName = null;
            while (!$fileName || file_exists($fileName)) {
                $fileName = DEBUG_LOGS_DIR . '/' . date('Y_m_d_H_i_s_') . ($i++ . '_') . $module . ($param ? '_' . $param : '') . '.json';
            }
            
            file_put_contents($fileName, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

}
