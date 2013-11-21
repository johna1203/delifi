<?php

namespace Application\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Stdlib\Hydrator\Reflection;

abstract class AbstractMapper extends TableGateway implements ServiceManagerAwareInterface
{
    protected $tableName = '';
    protected $idCol = 'id';
    protected $entityPrototype = null;
    /** @var Reflection */
    protected $hydrator = null;
    /** @var ServiceManager */
    protected $serviceManager;

    function __construct(AdapterInterface $adapter)
    {
        parent::__construct($this->tableName, $adapter, new RowGatewayFeature($this->idCol));
    }

    /**
     * Set service manager
     *
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->init();
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function hydrate(ResultSet $results)
    {
        $rows = new HydratingResultSet(
            $this->hydrator,
            $this->entityPrototype
        );

        return $rows->initialize($results->toArray());
    }

    public function insert($entity)
    {
        $data = $this->hydrator->extract($entity);
        if (isset($data['serviceManager']))
            unset($data['serviceManager']);

        return parent::insert($data);
    }

    public function updateEntity($entity)
    {
        $data = $this->hydrator->extract($entity);
        if (isset($data['serviceManager']))
            unset($data['serviceManager']);

        return parent::update($data, $this->idCol . '=' . $entity->getId());
    }


    abstract function init();


}