<?php

namespace harrypottercore\commands\tags;

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

class TagFiles {
	
	private $plugin;
	
	private $permission;
	
    	public function __construct(Main $plugin) {
    	    $this->plugin = $plugin;
    	}
	
    	public function getPlugin() {
	    return $this->plugin;
    	}

  	public function setTag(Player $player, $permission, $tag) { 
      	     if($player->hasPermission($permission)){
           	$this->plugin->setPlayerPrefix($player, $tag);
	   	$this->getPlugin()->message($player, Translation::getMessage("claimTag", ["tag" => $tag]));
             }else{ 
	   	$this->getPlugin()->message($player, Translation::getMessage("noPermTag"));
	     }
	}
}
