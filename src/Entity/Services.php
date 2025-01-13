<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Services
 *
 * @ORM\Table(name="services")
 * @ORM\Entity
 */
class Services
{
    /**
     * @var int
     *
     * @ORM\Column(name="service_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $serviceId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="service_nom", type="string", length=255, nullable=true)
     */
    private $serviceNom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="service_description", type="string", length=255, nullable=true)
     */
    private $serviceDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="service_image", type="string", length=255, nullable=true)
     */
    private $serviceImage;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nb_sous_services", type="integer", nullable=true)
     */
    private $nbSousServices;
    public function __toString(): string
    {
        return $this->serviceNom;
    }

}
