<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousServices
 *
 * @ORM\Table(name="sous_services", indexes={@ORM\Index(name="sous_services_ibfk_1", columns={"Service_id"})})
 * @ORM\Entity
 */
class SousServices
{
    /**
     * @var int
     *
     * @ORM\Column(name="Sous_service_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sousServiceId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sous_service_nom", type="string", length=255, nullable=true)
     */
    private $sousServiceNom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sous_service_description", type="string", length=255, nullable=true)
     */
    private $sousServiceDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sous_service_image", type="string", length=255, nullable=true)
     */
    private $sousServiceImage;

    /**
     * @var int|null
     *
     * @ORM\Column(name="Service_id", type="integer", nullable=true)
     */
    private $serviceId;
    public function __toString()
    {
        return $this->sousServiceNom; // assuming "nom" is the name of the sous-service property
    }

}
