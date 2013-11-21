<?php
/**
 * ECGKodokux
 *
 *
 * @package    ${GROUP}
 * @subpackage ${MODULENAME}
 * @license    BSD License
 */


namespace User\Mapper;

use Application\Mapper\AbstractMapper;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Stdlib\Hydrator\Reflection;

class User extends AbstractMapper
{
    protected $tableName = 'user';
    protected $idCol = 'id';
    protected $entityPrototype = null;
    protected $hydrator = null;

    function __construct(AdapterInterface $adapter)
    {
        parent::__construct($this->tableName, $adapter, new RowGatewayFeature($this->idCol));
    }

    function init()
    {
        $this->entityPrototype = $this->getServiceManager()->get('User\Model\User');
        $this->hydrator        = new Reflection();
    }

    public function findByScId($sc_id)
    {
        return $this->hydrate($this->select(array('scId' => $sc_id)));
    }
}