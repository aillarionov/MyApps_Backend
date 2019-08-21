<?php

namespace Informer\Service;

use Informer\API\FBAPI;
use Informer\API\VKAPI;
use Informer\DTO\FB\PhotoDTO as PhotoDTOFB;
use Informer\DTO\VK\PhotoDTO as PhotoDTOVK;
use Informer\DTO\FB\PostDTO as PostDTOFB;
use Informer\DTO\VK\PostDTO as PostDTOVK;
use Informer\DTO\VK\GoodsDTO as GoodsDTOVK;
use Informer\Entities\Catalog;
use Informer\Entities\Item;
use Informer\Enums\CatalogType;
use Informer\Enums\Source;
use PHPMailer\PHPMailer\Exception;

class CatalogService extends CommonService {

    public static function getItems(Catalog $catalog) {
        $items = array();

        switch ($catalog->getType()) {
            case (CatalogType::ITEM):
            case (CatalogType::MEMBER):
            case (CatalogType::IMAGE):
                $items = static::getAlbumPhotos($catalog);
                break;

            case (CatalogType::NEWS):
                $items = static::getWallPosts($catalog);
                break;
            
            case (CatalogType::GOODS):
                $items = static::getGoods($catalog);
                break;
        }


        return $items;
    }

    public static function clearCatalogCache(Catalog $catalog) {
        if ($catalog && $catalog->getId()) {
            $fileName = CACHE_DIR . '/catalog/' . $catalog->getId();
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
    }

    protected static function getGoods(Catalog $catalog) {
        $items = array();

        switch ($catalog->getSource()) {
            case Source::VK:
                $response = VKAPI::marketGet($catalog->getSourceOwner(), $catalog->getSourceAlbum());

                foreach ($response['items'] as $data) {
                    array_push($items, GoodsDTOVK::dataToModel($data));
                }

                break;

            default:
                throw new Exception("Unknown source - [" . $catalog->getSource() . "]");
        }

        return $items;
    }
    
    protected static function getAlbumPhotos(Catalog $catalog) {
        $items = array();

        switch ($catalog->getSource()) {
            case Source::FB:

                foreach (FBAPI::getAlbumPhotos($catalog->getSourceAlbum()) as $data) {
                    array_push($items, PhotoDTOFB::dataToModel($data));
                }

                break;

            case Source::VK:
                $response = VKAPI::photosGet($catalog->getSourceOwner(), $catalog->getSourceAlbum());

                foreach ($response['items'] as $data) {
                    array_push($items, PhotoDTOVK::dataToModel($data));
                }

                break;

            default:
                throw new Exception("Unknown source - [" . $catalog->getSource() . "]");
        }

        return $items;
    }

    protected static function getWallPosts(Catalog $catalog) {
        $items = array();

        switch ($catalog->getSource()) {
            case Source::FB:

                if (strtolower($catalog->getSourceAlbum()) == 'fixedpost') {
                    $response = FBAPI::getFixedPost($catalog->getSourceOwner());
                } else {
                    $response = FBAPI::getFeed($catalog->getSourceOwner());
                }
                
                foreach ($response as $data) {
                    $item = PostDTOFB::dataToModel($data);
                    if (isset($catalog->getParams()['filter']) && !static::filterCheck($item, $catalog->getParams()['filter'])) {
                        continue;
                    }
                    array_push($items, $item);
                }

                break;

            case Source::VK:
                
                if (strtolower($catalog->getSourceAlbum()) == 'fixedpost') {
                    $data = VKAPI::groupsGetById(null, -$catalog->getSourceOwner(), 'fixed_post');
                    if (isset($data[0]) && isset($data[0]['fixed_post'])) {
                        $response = VKAPI::wallGetById($catalog->getSourceOwner() . '_' . $data[0]['fixed_post']);
                    } else {
                        $response = null;
                    }
                } else {
                    $response = VKAPI::wallGet($catalog->getSourceOwner());
                    $response = isset($response['items']) ? $response['items'] : null;
                }

                if ($response) {
                    foreach ($response as $data) {
                        $item = PostDTOVK::dataToModel($data);
                        if (isset($catalog->getParams()['filter']) && !static::filterCheck($item, $catalog->getParams()['filter'])) {
                            continue;
                        }
                        array_push($items, $item);
                    }
                }

                break;

            default:
                throw new Exception("Unknown source - [" . $catalog->getSource() . "]");
        }

        return $items;
    }

    protected static function filterCheck(Item $item, string $filter) {
        return preg_match($filter, $item->getRaw());
    }

}
