<?php

namespace Informer\Callback\FB;


class Feed extends CommonCallback {

    public function __construct() {
        
    }

    public function execute($value) {
        

//        value": {
//            "from": {
//                "name": "Test Page",
//                "id": "1067280970047460"
//            },
//            "post_id": "44444444_444444444",
//            "item": "status",
//            "verb": "add",
//            "published": 1,
//            "created_time": 1520090276,
//            "message": "Example post content."
//        }
        
        $from = isset($value['from']) ? $value['from'] : null;
        $from_id = isset($from['from']) ? $from['from'] : null;
        $post_id = isset($value['post_id']) ? $value['post_id'] : null;
        $verb = isset($value['verb']) ? $value['verb'] : null;
        $published = isset($value['published']) ? $value['published'] : null;
        $message = isset($value['message']) ? $value['message'] : null;
        
        
        if ($from_id && $published && $verb == 'add') {
            
        }
    }

}
