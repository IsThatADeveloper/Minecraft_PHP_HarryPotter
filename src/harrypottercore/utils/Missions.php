<?php

namespace harrypottercore\utils;

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

class Missions {
	
    	private $plugin;
	
	private $mission = null;

    	public function __construct(Main $plugin) {
    	    $this->plugin = $plugin;
    	}
	
    	public function getPlugin() {
	    return $this->plugin;
    	}
	
	/*if(!$this->plugin->isComplete($player) and !$player->hasPermission("getwand.use")) {
	     $this->mission = "Complete Tutorial";
	     return $this->mission;
	*/
	
	public function save(Player $player, string $hasPermission, string $requiredPermission, string $message) {
		$config = new Config($this->plugin->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		$m = $config->get("mission");
		if($m == null) {
		   if($player->hasPermission($hasPermission) and !$player->hasPermission($requiredPermission)) {
		      $config->set("mission", $message);
		   }
		}
		if($player->hasPermission($requiredPermission)) {
		   $config->set("mission", null);
		}
	}
	
	public function Missions(Player $player) { 
		$this->save($player, "getwand.use", "complete2.use", "Complete explore mission §c(§aX§7:§b 81§7, §aY§7:§b 4§7, §aZ§7:§b -443§c)");
	}
}
