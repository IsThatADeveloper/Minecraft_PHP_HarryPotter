<?php

declare(strict_types=1);

namespace harrypottercore\entity;

use pocketmine\block\Block;
use pocketmine\block\Water;
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\sound\FizzSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\Player;
use pocketmine\Server;
use harrypottercore\Main;

use pocketmine\entity\AttributeMap;
use pocketmine\entity\Attribute;

class Bludger extends Human {
  
    /** @var float  */
    public $width = 0.01;
    /** @var float  */
    public $height = 0.01;
  
    public $health = 1;
  
    public $speed = 0.5;
  
    public function getName() : string{
	return "Bludger";
    }
	  
    public function initEntity() : void{
	parent::initEntity();
        $this->setNameTag($this->getName());
        $this->setNameTagAlwaysVisible(false);
        $this->setMaxHealth($this->health);
	$attr = $this->attributeMap->getAttribute(Attribute::MOVEMENT_SPEED);
	$attr->setValue($attr->getValue() + $this->speed);
    }
  
    public function getMaxHealth() : int{
	return (int) $this->health;
    }
  
    public function targetOption(Creature $creature, float $distance) : bool{
	return false;
    }
	
    /**
    * @param EntityDamageEvent $source
    */
    public function attack(EntityDamageEvent $source) : void {
        if($source instanceof EntityDamageByEntityEvent){
            $damager = $source->getDamager();
            if(!$damager instanceof Player){
               return;
	    }
	    $this->setHealth($this->getHealth() - 1);
            $this->getLevel()->broadcastLevelSoundEvent($this, LevelSoundEventPacket::SOUND_ITEM_SHIELD_BLOCK);
	}
        $source->setCancelled();
    }
	
    public function entityRun(Player $player) : void {
	    $loctionX = $this->getX()+5;
	    $loctionZ = $this->getZ()+5;
	    if($player->getX() >= $loctionX or $player->getZ() >= $loctionZ) {
	       $attr = $this->attributeMap->getAttribute(Attribute::MOVEMENT_SPEED);
	       $attr->setValue($attr->getValue() + $this->speed * 3);
	       $loctionX1 = $this->getX()+8;
	       $loctionZ1 = $this->getZ()+8;
	       if($player->getX() >= $loctionX1 or $player->getZ() >= $loctionZ1) {
	          $attr = $this->attributeMap->getAttribute(Attribute::MOVEMENT_SPEED);
	          $attr->setValue($attr->getValue() + $this->speed * 1.5);
	       }
	    }
    }
  
    public function onUpdate(int $currentTick) : bool {
       if($this->isClosed()) {
          return false;
       }
       $this->getLevel()->addParticle(new FlameParticle(new Vector3($this->x, $this->y, $this->z)));
       $this->getLevel()->addParticle(new SmokeParticle(new Vector3($this->x, $this->y, $this->z)));
       foreach(Main::getInstance()->getServer()->getOnlinePlayers() as $player) {
       $this->setScale(1);
       $this->setMotion($this->generateRandomUpDownMotion());
       if($this->motion->y >= 100 and $this->motion->y <= 149) { 
       	  $this->setMotion($this->generateConstantMotion());
       }elseif($this->motion->y >= 150) {
               Main::getInstance()->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(int $currentTick) use($player) : void{
       	       $this->setMotion($this->generateDownMotion());
	       }), 20);
       }
       $this->entityRun($player);
       }
       return parent::onUpdate($currentTick);
    }
	
    public function generateRandomUpDownMotion() : Vector3{
	return new Vector3(mt_rand(-1000, 1000) / 1000, mt_rand(-250, 500) / 1000, mt_rand(-1000, 1000) / 1000);
    }
	
    public function generateConstantMotion() : Vector3{
	return new Vector3(mt_rand(-1000, 1000) / 1000, mt_rand(-200, 200) / 1000, mt_rand(-1000, 1000) / 1000);
    }
	
    public function generateDownMotion() : Vector3{
	return new Vector3(mt_rand(-1000, 1000) / 1000, mt_rand(-200, 0) / 1000, mt_rand(-1000, 1000) / 1000);
    }
	
    public function setYMotion() : Vector3{
	return new Vector3(mt_rand(-1000, 1000) / 1000, 0.3, mt_rand(-1000, 1000) / 1000);
    }
	
    public function setXYMotion() : Vector3{
	return new Vector3(0.3, 0.3, mt_rand(-1000, 1000) / 1000);
    }
	
    public function setXYZMotion() : Vector3{
	return new Vector3(0.3, 0.3, 0.3);
    }
}
