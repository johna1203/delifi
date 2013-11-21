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

class Content extends AbstractMapper
{
    function init()
    {
        $this->entityPrototype = $this->getServiceManager()->get('Application\Model\Content');
        $this->hydrator        = new Reflection();
    }
}