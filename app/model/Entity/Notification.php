<?php

namespace ZBubliny\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="notification")
 */
class Notification {

    use \Kdyby\Doctrine\Entities\Attributes\Identifier;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $describe;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $key;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $url;

}
