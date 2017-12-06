<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discussion
 *
 * @ORM\Table(name="discussion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DiscussionRepository")
 */
class Discussion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $authorid;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="integer")
     */
    private $themeid;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorid;
    }

    /**
     * @param mixed $authorid
     */
    public function setAuthorId($authorid)
    {
        $this->authorid = $authorid;
    }

    /**
     * @return mixed
     */
    public function getThemeId()
    {
        return $this->themeid;
    }

    /**
     * @param mixed $theme_id
     */
    public function setThemeId($themeid)
    {
        $this->themeid = $themeid;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $authorname
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
}

