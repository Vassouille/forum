<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ThemeRepository")
 */
class Theme
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastusername;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastdate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLastusername()
    {
        return $this->lastusername;
    }

    /**
     * @param mixed $lastusername
     */
    public function setLastusername($lastusername)
    {
        $this->lastusername = $lastusername;
    }

    /**
     * @return mixed
     */
    public function getLastdate()
    {
        return $this->lastdate;
    }

    /**
     * @param mixed $lastdate
     */
    public function setLastdate($lastdate)
    {
        $this->lastdate = $lastdate;
    }
}

