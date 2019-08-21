<?php

namespace Informer\Utils\DAO;

/**
 * @author alex
 */
class CommonDAO {

    static protected $entityClass = Informer\Utils\Entity\BaseEntity::class;
    private $em;

    public function __construct() {
        global $g_entityManager;
        $this->em = $g_entityManager;
    }

    protected function getEm() {
        return $this->em;
    }

    public function create($entity) {
        $this->getEm()->persist($entity);
    }

    public function get($id) {
        return $this->getEm()->find(static::$entityClass, $id);
    }

    public function delete($entity) {
        $this->getEm()->remove($entity);
    }

    public function update($entity) {
        $this->getEm()->merge($entity);
    }

    public function listAll() {
        return $this->getEm()->getRepository(static::$entityClass)->findAll();
    }

}
