<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamations
 *
 * @ORM\Table(name="reclamations", indexes={@ORM\Index(name="freelancer_id", columns={"freelancer_id"}), @ORM\Index(name="utilisateur_id", columns={"utilisateur_id"})})
 * @ORM\Entity
 */
class Reclamations
{
    /**
     * @var int
     *
     * @ORM\Column(name="reclamation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reclamationId;

    /**
     * @var string
     *
     * @ORM\Column(name="reclamation_titre", type="string", length=255, nullable=false)
     */
    private $reclamationTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="reclamation_subject", type="string", length=255, nullable=false)
     */
    private $reclamationSubject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reclamation", type="date", nullable=false)
     */
    private $dateReclamation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="consulter", type="string", length=5, nullable=true)
     */
    private $consulter;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     * })
     */
    private $utilisateur;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="freelancer_id", referencedColumnName="id")
     * })
     */
    private $freelancer;


}
