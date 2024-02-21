<?php

namespace harrypottercore\commands\tutorial;

use harrypottercore\Main;
use harrypottercore\messages\Translation;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use onebone\tokenapi\TokenAPI;
use pocketmine\Player;
use pocketmine\Server;

use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\ExplodeParticle;

use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI;

use pocketmine\utils\config;

class TutorialFiles {
	
    	private $plugin;

    	public function __construct(Main $plugin) {
    	    $this->plugin = $plugin;
    	}
	
    	public function getPlugin() {
	    return $this->plugin;
    	}
  
  	public function questGainWand(Player $player, int $token) { 
                     if($player->hasPermission("getwand.use")){
                    	$player->sendMessage("§7(§c!§7) §cYou have already started §dGet a Wand");
		     }else{
			$this->getPlugin()->setPermission($player, "getwand.use");
                    	$player->sendMessage("§7(§a!§7) §aYou started the mission §dGet a Wand");
                    	$player->sendPopup("§7(§a!§7) §aYou have received " . $token . " tokens to purchase a basic wand");
                       	$p = $player->getName();
            		TokenAPI::getInstance()->addToken($player, $token);
		     }
	}
	
	public function checkPermission(Player $player, string $permission, string $quest) { 
		     if($player->hasPermission($permission)) { 
			$player->sendMessage("§7(§c!§7) §cYou have already completed this mission");
		     }
		     if($player->hasPermission($permission)) {
                    	$player->sendMessage("§7(§c!§7) §cYou have already started " . $quest);
		     }else{
                    	$player->sendMessage("§7(§a!§7) §aYou started the mission " . $quest);
			$this->getPlugin()->setPermission($player, $permission);
		     }
	}
	
	public function questExplore(Player $player, int $x, int $z) {
	   if($player->hasPermission("complete3.use")) { 
	      $player->sendMessage("§7(§c!§7) §cYou have already completed this mission");
	   }elseif(!$player->hasPermission("explore.use")){
              $player->sendMessage("§7(§c!§7) §aMission has not been started yet");
	   }elseif($player->hasPermission("explore.use")){
	           if ($player->getX() == $x and $player->getZ() == $z) {
		       $this->getPlugin()->setPermission($player, "complete2.use");
               	       $player->addTitle("§aCompleted Mission\n§dExplore");
	 	       $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	 	       $player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
		       $this->sound($player);
		    }else{
              	       $player->sendMessage("§7(§c!§7) §cThese are not the right coordinates");
		   }
	   }
	}
	
	public function questWarp(Player $player) {
			  if($player->hasPermission("complete4.use")) { 
			     $player->sendMessage("§7(§c!§7) §cYou have already completed §dXp");
			  }else{
              		     $player->addTitle("§aCompleted Mission\n§dXpLevel");
		 	     $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	 		     $player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
			     $this->sound($player);
			     $this->getPlugin()->setPermission($player, "complete4.use");
			     }
	}
	
	public function questMp(Player $player) { 
			  if($player->hasPermission("complete5.use")) { 
			     $player->sendMessage("§7(§c!§7) §cYou have already completed §dMagicalPower");
			  }else{
              		     $player->addTitle("§aCompleted Mission\n§dMagicalPower");
		 	     $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	 		     $player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
 			     $this->sound($player);
			     $this->getPlugin()->setPermission($player, "complete5.use");
			     }
	}
	
	public function questUseWand(Player $player) { 
			  if($player->hasPermission("complete6.use")) { 
			     $player->sendMessage("§7(§c!§7) §cYou have already completed §dUsing Wand");
			  }else{
		 	     $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	 		     $player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
			     $this->sound($player);
			     $this->getPlugin()->setPermission($player, "complete6.use");
			     }
	}
	
	public function questHome(Player $player) { 
		       if($player->hasPermission("complete7.use")) { 
			  $player->sendMessage("§7(§c!§7) §cYou have already completed §dSet Home");
		       }else{
			  if($this->getPlugin()->getGroup($player) == "Hufflepuff" or $this->getPlugin()->getGroup($player) == "Slytherin" or $this->getPlugin()->getGroup($player) == "Gryffindor" or $this->getPlugin()->getGroup($player) == "Ravenclaw"){
              		     $player->addTitle("§aCompleted Mission\n§dSet Your Home");
			     $this->sound($player);
			     $this->getPlugin()->setPermission($player, "complete7.use");
			  }else{
			     $player->sendMessage("§7(§c!§7) §cYou have not set your home yet");
			  }
	            }
	}
	
	public function questComplete(Player $player) { 
		          if($this->getPlugin()->isCompleted($player) == true) { 
			     $player->sendMessage("§7(§c!§7) §cYou have already completed this mission");
		          }else{
              		     $player->addTitle("§aCompleted Tutorial");
                   	     $this->getPlugin()->getServer()->broadcastMessage("§7(§a!§7)§f ".$player . " §fhas completed §7[§aTutorial§7]");    
		 	     $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	 		     $player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
			     $this->sound($player);
			     $this->getPlugin()->setTutorial($player, true);
			     }
	}
	
    	public function sound(Player $player) { 
		$pk = new PlaySoundPacket();
		$pk->x = $player->getX();
		$pk->y = $player->getY();
		$pk->z = $player->getZ();
		$pk->volume = 3;
		$pk->pitch = 2;
		$pk->soundName = 'random.explode2';
		$pk2 = new PlaySoundPacket();
		$pk2->x = $player->getX();
		$pk2->y = $player->getY();
		$pk2->z = $player->getZ();
		$pk2->volume = 3;
		$pk2->pitch = 2;
		$pk2->soundName = 'random.use_totem';
		$player->dataPacket($pk);
		$player->dataPacket($pk2);
	}
}
