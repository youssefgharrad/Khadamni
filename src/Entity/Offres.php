<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offres
 *
 * @ORM\Table(name="offres", indexes={@ORM\Index(name="Service_id", columns={"Service_id"}), @ORM\Index(name="Sous_service_id", columns={"Sous_service_id"})})
 * @ORM\Entity
 */
class Offres
{
    /**
     * @var int
     *
     * @ORM\Column(name="Offre_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $offreId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Offre_adresse", type="string", length=255, nullable=true)
     */
    private $offreAdresse;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="Offre_date", type="date", nullable=true)
     */
    private $offreDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Offre_description", type="string", length=255, nullable=true)
     */
    private $offreDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Offre_image", type="string", length=255, nullable=true)
     */
    private $offreImage;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Service_id", type="integer", nullable=true)
     */
    private $serviceId;

    /**
     * @var \SousServices
     *
     * @ORM\ManyToOne(targetEntity="SousServices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Sous_service_id", referencedColumnName="Sous_service_id")
     * })
     */
    private $sousService;


}
