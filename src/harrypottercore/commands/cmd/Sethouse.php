<?php

namespace harrypottercore\commands\cmd;

use harrypottercore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;

//particles
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\BubbleParticle;
use harrypottercore\messages\Translation;

class Sethouse extends PluginCommand{

    private $owner;
	
    public $group;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
    }
	
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
            if (!isset($args[0])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§csethome §7{§cslytherin§7} §7{§cgryffindor§7} §7{§chufflepuff§7} §7{§cravenclaw§7}");
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'slytherin':
	      if($this->check($sender) == null) { 
		 $this->getPlugin()->setPermission($sender, "slytherin.use");
		 $this->setHome($sender, ucwords($args[0]));
             	 $sender->sendMessage(Translation::getMessage("setHome", ["home" => ucwords($args[0])])); //home set slytherin
	      	 $sender->getLevel()->addParticle(new SmokeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
		 $this->sound($sender);
	      }else{
		 $this->check($sender);
	      }
              break;
                    case 'gryffindor':
	      if($this->check($sender) == null) { 
		 $this->getPlugin()->setPermission($sender, "gryffindor.use");
		 $this->setHome($sender, ucwords($args[0]));
             	 $sender->sendMessage(Translation::getMessage("setHome", ["home" => ucwords($args[0])])); //home set gryffindor
	      	 $sender->getLevel()->addParticle(new FlameParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
		 $this->sound($sender);
	      }else{
		 $this->check($sender);
	      }
	      break;
                    case 'hufflepuff':
	      if($this->check($sender) == null) { 
		 $this->getPlugin()->setPermission($sender, "hufflepuff.use");
		 $this->setHome($sender, ucwords($args[0]));
             	 $sender->sendMessage(Translation::getMessage("setHome", ["home" => ucwords($args[0])])); //home set hufflepuff
	      	 $sender->getLevel()->addParticle(new LavaDripParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
		 $this->sound($sender);
	      }else{
		 $this->check($sender);
	      }
              break;
                    case 'ravenclaw':
	      if($this->check($sender) == null) { 
		 $this->getPlugin()->setPermission($sender, "ravenclaw.use");
		 $this->setHome($sender, ucwords($args[0]));
             	 $sender->sendMessage(Translation::getMessage("setHome", ["home" => ucwords($args[0])])); //home set ravenclaw
	      	 $sender->getLevel()->addParticle(new BubbleParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
		 $this->sound($sender);
	      }else{
		 $this->check($sender);
	      }
              break;
              }
            }
    return false;
    }
	
    public function setHome(Player $player, $house) { 
	$purePerms = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PurePerms");
	$house = $purePerms->getGroup($house);
	return $purePerms->setGroup($player, $house);
    }
	
    public function check(Player $player) {
   	      $this->group = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->getGroup($player)->getName();
       	      $guest = "Guest";
	      $slytherin = "Slytherin";
	      $gryffindor = "Gryffindor";
	      $hufflepuff = "Hufflepuff";
	      $ravenclaw = "Ravenclaw";
       	      if($this->group === $slytherin){
		      return $player->sendMessage("§7(§c!§7) §cYour house is already set as §2slytherin §cuse the command §7/§cmyhouse to gain information about it");
	      }elseif($this->group === $gryffindor){
		      return $player->sendMessage("§7(§c!§7) §cYour house is already set as §6gryffindor §cuse the command §7/§cmyhouse to gain information about it");
	      }elseif($this->group === $hufflepuff){
		      return $player->sendMessage("§7(§c!§7) §cYour house is already set as §ehufflepuff §cuse the command §7/§cmyhouse to gain information about it");
	      }elseif($this->group === $ravenclaw){
		      return $player->sendMessage("§7(§c!§7) §cYour house is already set as §bravenclaw §cuse the command §7/§cmyhouse to gain information about it");
	      }elseif($this->group === $guest){
		      return null;
	      }
    }
	
    public function sound(Player $player) { 
		$pk = new PlaySoundPacket();
		$pk->x = $player->getX();
		$pk->y = $player->getY();
		$pk->z = $player->getZ();
		$pk->volume = 1;
		$pk->pitch = 1;
		$pk->soundName = 'random.explode3';
		$player->dataPacket($pk);
    }
}
