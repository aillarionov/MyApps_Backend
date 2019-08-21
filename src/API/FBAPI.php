<?php

namespace Informer\API;

use Facebook\Facebook;
use Facebook\FacebookApp;
use Informer\API\FBAPI;
use Informer\Utils\Log;

class FBAPI {

    private static $GRAPH_VERSION = 'v2.12';
    
    private static $fbApp;

    public static function _init() {
        $_fbApp = new FacebookApp(FB_APPID, FB_SECRET);
                
        static::$fbApp = new Facebook(array(
            'app_id' => FB_APPID,
            'app_secret' => FB_SECRET,
            'default_access_token' => $_fbApp->getAccessToken(),
            'default_graph_version' => static::$GRAPH_VERSION
        ));
    }

    public static function getAlbumPhotos($albumId) {
        $result = static::$fbApp->get("/$albumId/photos?fields=id,name,images,width,height,created_time")->getGraphEdge();
        
        Log::write('INFO', 'fb', 'getAlbumPhotos', array('params' => array('albumId' => $albumId), 'data' => $result));
        
        return $result;
    }
    
    public static function getFeed($ownerId) {
        $result = static::$fbApp->get("/$ownerId/posts?fields=id,message,created_time,attachments{subattachments{media},media}&limit=100")->getGraphEdge();
        
        Log::write('INFO', 'fb', 'getAlbumPhotos', array('params' => array('ownerId' => $ownerId), 'data' => $result));
        
        return $result;
    }

    public static function getFixedPost($ownerId) {
        $result = static::$fbApp->get("/$ownerId/posts?fields=id,message,created_time,attachments{subattachments{media},media}&limit=1")->getGraphEdge();
        
        Log::write('INFO', 'fb', 'getAlbumPhotos', array('params' => array('ownerId' => $ownerId), 'data' => $result));
        
        return $result;
    }
    
}

FBAPI::_init();
