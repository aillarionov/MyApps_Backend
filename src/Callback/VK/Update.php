<?php

namespace Informer\Callback\VK;

use Exception;
use Informer\Callback\CommonCallback;
use Informer\Entities\Catalog;
use Informer\Enums\Source;
use Informer\Service\CatalogService;

class Update extends CommonCallback {

    public function __construct() {
        
    }

    public function execute($data) {
        $groupId = isset($data["group_id"]) ? intval($data["group_id"]) : null;
        $albumId = isset($data['album_id']) ? intval($data['album_id']) : null;
        $itemId = isset($data['id']) ? intval($data['id']) : null;


        if (!$groupId) {
            throw new Exception("groupId", 1001);
        }

        if (!$albumId) {
            throw new Exception("albumId", 1001);
        }

        if (!$itemId) {
            throw new Exception("itemId", 1001);
        }

        $catalogs = static::getEm()->getRepository(Catalog::class)->findBy(array(
            "source" => Source::VK,
            "sourceOwner" => $groupId,
            "sourceAlbum" => $albumId
        ));

        
        // Очистка кеша каталогов
        if ($catalogs) {
            foreach ($catalogs as $catalog) {
                CatalogService::clearCatalogCache($catalog);
            }
        }
        
        return "ok";
    }

}
