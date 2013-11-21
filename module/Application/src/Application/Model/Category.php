<?php
/**
 * ECGKodokux
 *
 *
 * @package    ${GROUP}
 * @subpackage ${MODULENAME}
 * @license    BSD License
 */


namespace Application\Model;


class Category extends AbstractEntity
{
    private $id;
    private $categoryName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * @param mixed $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }
} 