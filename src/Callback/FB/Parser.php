<?php

namespace Informer\Callback\FB;

class Parser {

    public function parse($data) {
        $params = $_GET;

        \Informer\Utils\Log::write("IMPORTANT", "fb", null, array("data" => $data, "params" => $params));

        
        $type = isset($params["hub_mode"]) ? $params["hub_mode"] : "";
        $result = null;
        
        // Confirmation
        switch ($type) {
            case 'subscribe':
                $callback = new Confirmation();
                $result = $callback->execute($params, $data);
                return $result;
        }

        
        // Updates
        $entry = isset($data["entry"]) ? $data["entry"] : null;
        $changes = isset($entry["changes"]) ? $entry["changes"] : array();
        
        foreach ($changes as $change) {
            $field = isset($change["field"]) ? $change["field"] : null;
            $values = isset($change["values"]) ? $change["values"] : null;
            
            switch ($field) {
                case '':
                    $callback = new Feed();
                    $result = $callback->execute($values);
                    break;
            }
            
        }
        
        return $result;
        
        
        
    }

}
