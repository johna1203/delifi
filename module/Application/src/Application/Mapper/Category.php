<?php
/**
 * ECGKodokux
 *
 *
 * @package    ${GROUP}
 * @subpackage ${MODULENAME}
 * @license    BSD License
 */


namespace Application\Mapper;


use Zend\Stdlib\Hydrator\Reflection;

class Category extends AbstractMapper
{
    protected $tableName = 'category';
    protected $idCol = 'id';

    function init()
    {
        $this->entityPrototype = $this->getServiceManager()->get('Application\Model\Category');
        $this->hydrator        = new Reflection();
    }

    public function findAll()
    {
        return $this->hydrate($this->select());
    }

    public function findByUserId($userId)
    {
        return $this->hydrate($this->select(array('userId' => $userId)));
    }

}