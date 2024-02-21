<?php

namespace harrypottercore\task\store;

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

use onebone\mpapi\MpAPI; 

class StoreTasks {
	
    	private $plugin;

    	public function __construct(Main $plugin) {
    	    $this->plugin = $plugin;
    	}
	
    	public function getPlugin() {
	    return $this->plugin;
    	}
	
	public function getMpTask(int $magic) { 
	  	foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $players) {
	     	     MpAPI::getInstance()->addMp($players, ($magic));
	     	     $this->getPlugin()->getServer()->broadcastMessage("§7(§a!§7) §aYou gained $magic magical point");
	  	}
	}
	
	public function getBackupTask() { 
	    foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $player) {
	    if($player instanceof Player) {
     	       if($this->plugin->isComplete($player)) {
	     	  $xp = $player->getXpLevel();
		  $xpprogress = $player->getXpProgress();
	   	  $config = new Config($this->getPlugin()->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
	   	  $config->set("xpprogress", $xpprogress);
	   	  $config->set("xplevel", $xp);
	   	  $config->save();
	          $player->sendPopup("§7(§a!§7) §aYour data has been saved");
		  $this->getPlugin()->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), "save-all");
		       
		  $xp = $config->get("xplevel");
		  if($xp >= 5 and $xp <= 10) {
		     $config->set("level", 1);
		  }elseif($xp >= 10 and $xp <= 15) {
		          $config->set("level", 2);
		  }elseif($xp >= 15 and $xp <= 20) {
		          $config->set("level", 3);
		  }elseif($xp >= 25 and $xp <= 35) {
		          $config->set("level", 4);
		  }elseif($xp >= 35 and $xp <= 45) {
		          $config->set("level", 5);
		  }elseif($xp >= 45 and $xp <= 55) {
		          $config->set("level", 6);
		  }elseif($xp >= 55 and $xp <= 65) {
		          $config->set("level", 7);
		  }elseif($xp >= 65 and $xp <= 75) {
		          $config->set("level", 8);
		  }elseif($xp >= 75 and $xp <= 85) {
		          $config->set("level", 9);
		  }elseif($xp >= 85 and $xp <= 90) {
		          $config->set("level", 10);
		  }elseif($xp == 90) {
		          $config->set("level", 11);
		  }elseif($xp == 91) {
		          $config->set("level", 12);
		  }elseif($xp == 92) {
		          $config->set("level", 13);
		  }elseif($xp == 93) {
		          $config->set("level", 14);
		  }elseif($xp == 94) {
		          $config->set("level", 15);
		  }elseif($xp == 95) {
		          $config->set("level", 16);
		  }elseif($xp == 96) {
		          $config->set("level", 17);
		  }elseif($xp == 97) {
		          $config->set("level", 18);
		  }elseif($xp == 98) {
		          $config->set("level", 19);
		  }elseif($xp == 99) {
		          $config->set("level", 20);
		  }elseif($xp == 100) {
		          $config->set("level", 21);
		  }elseif($xp == 101) {
		          $config->set("level", 22);
		  }elseif($xp >= 101) {
		          $config->set("level", 23);  
		  }
	       }
	    }
	    }
	}
}
