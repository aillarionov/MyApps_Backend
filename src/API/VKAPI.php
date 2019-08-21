<?php

namespace Informer\API;

use Informer\API\VK;

class VKAPI {

    private static $vkApp;

    public static function _init() {
        static::$vkApp = new VK(VK_ACCESSTOKEN);
    }

    public static function wallGet($owner_id, $domain = null, $offset = 0, $count = 100, $filter = 'all', $extended = 1, $fields = null) {
        $params = array(
            'owner_id' => $owner_id,
            'domain' => $domain,
            'offset' => $offset,
            'count' => $count,
            'filter' => $filter,
            'extended' => $extended,
            'fields' => $fields,
        );
        return static::$vkApp->request('wall.get', $params);
    }

    public static function marketGet($owner_id,  $album_id = 0, $offset = 0, $count = 100,  $extended = 1) {
        $params = array(
            'owner_id' => $owner_id,
            'album_id' => $album_id,
            'offset' => $offset,
            'count' => $count,
            'extended' => $extended
        );
        return static::$vkApp->request('market.get', $params);
    }
    
    
    public static function wallGetById($posts, $extended = 0, $copy_history_depth = 2, $fields = null) {
        $params = array(
            'posts' => $posts,
            'extended' => $extended,
            'copy_history_depth' => $copy_history_depth,
            'fields' => $fields
        );
        return static::$vkApp->request('wall.getById', $params);
    }

    public static function wallPost($data) {
        return static::$vkApp->request('wall.post', $data);
    }

    public static function photosGetAlbums($owner_id, $album_ids = null, $offset = 0, $count = 0, $need_system = 0, $need_covers = 0, $photo_sizes = 0) {
        $params = array(
            'owner_id' => $owner_id,
            'album_ids' => $album_ids,
            'offset' => $offset,
            'count' => $count,
            'need_system' => $need_system,
            'need_covers' => $need_covers,
            'photo_sizes' => $photo_sizes,
        );
        return static::$vkApp->request('photos.getAlbums', $params);
    }

    public static function photosGet($owner_id, $album_id, $photo_ids = null, $rev = 0, $extended = 0, $feed_type = null, $feed = null, $photo_sizes = 0, $offset = 0, $count = 1000) {
        $params = array(
            'owner_id' => $owner_id,
            'album_id' => $album_id,
            'photo_ids' => $photo_ids,
            'rev' => $rev,
            'extended' => $extended,
            'feed_type' => $feed_type,
            'feed' => $feed,
            'photo_sizes' => $photo_sizes,
            'offset' => $offset,
            'count' => $count,
        );
        return static::$vkApp->request('photos.get', $params);
    }

    public static function photosGetById($photos, $extended = 0, $photoSizes = 0) {
        $params = array(
            'photos' => $photos,
            'extended' => $extended,
            'photo_sizes' => $photoSizes
        );
        return static::$vkApp->request('photos.getById', $params);
    }

    public static function photosGetWallUploadServer($group_id) {
        $params = array(
            'group_id' => $group_id,
        );
        return static::$vkApp->request('photos.getWallUploadServer', $params);
    }

    public static function groupsGetById($groupIds, $groupId, $fields) {
        $params = array(
            'group_ids' => $groupIds,
            'group_id' => $groupId,
            'fields' => $fields
        );
        return static::$vkApp->request('groups.getById', $params);
    }

    public static function messagesIsMessagesFromGroupAllowed($groupId, $userId) {
        $params = array(
            'group_id' => $groupId,
            'user_id' => $userId
        );
        return static::$vkGroup->request('messages.isMessagesFromGroupAllowed', $params);
    }

}

VKAPI::_init();
