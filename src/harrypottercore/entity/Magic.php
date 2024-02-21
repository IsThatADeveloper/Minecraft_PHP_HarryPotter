<?php

declare(strict_types=1);

namespace harrypottercore\entity;

use harrypottercore\Main;
use pocketmine\entity\projectile\Snowball as ISnowball;
use pocketmine\Player;
use pocketmine\math\Vector3;

use pocketmine\level\particle\AngryVillagerParticle;
use pocketmine\level\particle\InkParticle;

use pocketmine\entity\Entity;

class Magic extends ISnowball
{
    /**
     * @var Main
     */
    public $plugin;

    /**
     * @var Player
     */
    public $owner;
    
    public $entity;

    public function entityBaseTick(int $tickDiff = 1): bool {
        if ($this->entity instanceof Entity and $this->owner instanceof Player and $this->owner->isOnline() and !$this->isCollided) {
            $entity->getLevel()->addParticle(new AngryVillagerParticle($entity->asVector3()));
            $entity->getLevel()->addParticle(new InkParticle($entity->asVector3()));
        } else {
            $this->owner = null;
        }
        return parent::entityBaseTick($tickDiff);
    }
}
