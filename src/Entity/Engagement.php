<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Engagement
 *
 * @ORM\Table(name="engagement")
 * @ORM\Entity
 */
class Engagement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ide;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="jour", type="string", length=255, nullable=false)
     */
    private $jour;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255, nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="heure", type="integer", nullable=false)
     */
    private $heure;

    /**
     * @var int
     *
     * @ORM\Column(name="idF", type="integer", nullable=false)
     */
    private $idf;


}
