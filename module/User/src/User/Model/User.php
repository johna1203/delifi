<?php
namespace User\Model;

use Application\Model\AbstractEntity;

class User extends AbstractEntity
{
    private $id;
    private $name;
    private $firstName;
    private $lastName;
    private $scId;
    private $email;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $fisrtName
     */
    public function setFirstName($fisrtName)
    {
        $this->firstName = $fisrtName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getScId()
    {
        return $this->scId;
    }

    /**
     * @param mixed $scId
     */
    public function setScId($scId)
    {
        $this->scId = $scId;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

}