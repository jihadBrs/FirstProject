<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Categories
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=255, nullable=true)
     */
    private $name;

    /**
     * @var Categories|null
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="fils")
     */
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Categories", mappedBy="parent")
     */
    private $fils;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Annonces", mappedBy="categories")
     */
    private $annonces;

    public function __construct()
    {
        $this->fils = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($title)
    {
        $this->name = $title;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getFils()
    {
        return $this->fils;
    }

    public function addFil($fil)
    {
        if (!$this->fils->contains($fil)) {
            $this->fils->add($fil);
            $fil->setParent($this);
        }
        return $this;
    }

    public function removeFil($fil)
    {
        if ($this->fils->removeElement($fil)) {
            if ($fil->getParent() === $this) {
                $fil->setParent(null);
            }
        }
        return $this;
    }

    public function getAnnonces()
    {
        return $this->annonces;
    }

    public function addAnnonce($annonce)
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces->add($annonce);
            $annonce->setCategorie($this);
        }
        return $this;
    }

    public function removeAnnonce($annonce)
    {
        if ($this->annonces->removeElement($annonce)) {
            if ($annonce->getCategorie() === $this) {
                $annonce->setCategorie(null);
            }
        }
        return $this;
    }
}