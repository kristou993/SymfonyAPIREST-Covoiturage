<?php

namespace CovoiturageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnonceCo
 *
 * @ORM\Table(name="annonce_co")
 * @ORM\Entity(repositoryClass="CovoiturageBundle\Repository\AnnonceCoRepository")
 */
class AnnonceCo
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255,nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255,nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="gouvernorat", type="string", length=255)
     */
    private $gouvernorat;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255,nullable=true)
     */
    private $prix;



    /**
     * @var string
     *
     * @ORM\Column(name="adressedestination", type="string", length=255,nullable=true)
     */
    private $adressedestination;

    /**
     * @var string
     *
     * @ORM\Column(name="adressedebut", type="string", length=255,nullable=true)
     */
    private $adressedebut;

    /**
     * @var string
     *
     * @ORM\Column(name="gouvernoratdest", type="string", length=255)
     */
    private $gouvernoratdest;

    /**
     * @var boolean
     *
     * @ORM\Column(name="multiville", type="boolean",options={"default":false})
     */
    private $multiville;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fumeur", type="boolean",nullable=true)
     */
    private $fumeur;

    /**
     * @var boolean
     *
     * @ORM\Column(name="clim", type="boolean",nullable=true)
     */
    private $clim;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bagage", type="boolean",nullable=true)
     */
    private $bagage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepublication", type="date")
     */
    private $datepublication;



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
     * Set titre
     *
     * @param string $titre
     *
     * @return AnnonceCo
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AnnonceCo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return AnnonceCo
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AnnonceCo
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set gouvernorat
     *
     * @param string $gouvernorat
     *
     * @return AnnonceCo
     */
    public function setGouvernorat($gouvernorat)
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }

    /**
     * Get gouvernorat
     *
     * @return string
     */
    public function getGouvernorat()
    {
        return $this->gouvernorat;
    }

    /**
     * Set user
     *
     * @param \CovoiturageBundle\Entity\User $user
     *
     * @return AnnonceCo
     */
    public function setUser(\CovoiturageBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CovoiturageBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return AnnonceCo
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }




    /**
     * Set adressedestination
     *
     * @param string $adressedestination
     *
     * @return AnnonceCo
     */
    public function setAdressedestination($adressedestination)
    {
        $this->adressedestination = $adressedestination;

        return $this;
    }

    /**
     * Get adressedestination
     *
     * @return string
     */
    public function getAdressedestination()
    {
        return $this->adressedestination;
    }

    /**
     * Set adressedebut
     *
     * @param string $adressedebut
     *
     * @return AnnonceCo
     */
    public function setAdressedebut($adressedebut)
    {
        $this->adressedebut = $adressedebut;

        return $this;
    }

    /**
     * Get adressedebut
     *
     * @return string
     */
    public function getAdressedebut()
    {
        return $this->adressedebut;
    }

    /**
     * Set gouvernoratDestination
     *
     * @param string $gouvernoratDestination
     *
     * @return AnnonceCo
     */


    /**
     * Set gouvernoratdest
     *
     * @param string $gouvernoratdest
     *
     * @return AnnonceCo
     */
    public function setGouvernoratdest($gouvernoratdest)
    {
        $this->gouvernoratdest = $gouvernoratdest;

        return $this;
    }

    /**
     * Get gouvernoratdest
     *
     * @return string
     */
    public function getGouvernoratdest()
    {
        return $this->gouvernoratdest;
    }

    /**
     * Set multiville
     *
     * @param boolean $multiville
     *
     * @return AnnonceCo
     */
    public function setMultiville($multiville)
    {
        $this->multiville = $multiville;

        return $this;
    }

    /**
     * Get multiville
     *
     * @return boolean
     */
    public function getMultiville()
    {
        return $this->multiville;
    }

    /**
     * Set fumeur
     *
     * @param boolean $fumeur
     *
     * @return AnnonceCo
     */
    public function setFumeur($fumeur)
    {
        $this->fumeur = $fumeur;

        return $this;
    }

    /**
     * Get fumeur
     *
     * @return boolean
     */
    public function getFumeur()
    {
        return $this->fumeur;
    }

    /**
     * Set clim
     *
     * @param boolean $clim
     *
     * @return AnnonceCo
     */
    public function setClim($clim)
    {
        $this->clim = $clim;

        return $this;
    }

    /**
     * Get clim
     *
     * @return boolean
     */
    public function getClim()
    {
        return $this->clim;
    }

    /**
     * Set bagage
     *
     * @param boolean $bagage
     *
     * @return AnnonceCo
     */
    public function setBagage($bagage)
    {
        $this->bagage = $bagage;

        return $this;
    }

    /**
     * Get bagage
     *
     * @return boolean
     */
    public function getBagage()
    {
        return $this->bagage;
    }

    /**
     * Set datepublication
     *
     * @param \DateTime $datepublication
     *
     * @return AnnonceCo
     */
    public function setDatepublication($datepublication)
    {
        $this->datepublication = $datepublication;

        return $this;
    }

    /**
     * Get datepublication
     *
     * @return \DateTime
     */
    public function getDatepublication()
    {
        return $this->datepublication;
    }
}
