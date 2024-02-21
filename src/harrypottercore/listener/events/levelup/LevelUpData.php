<?php

namespace harrypottercore\listener\events\levelup;

use harrypottercore\Main;
use harrypottercore\messages\Translation;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use onebone\tokenapi\TokenAPI;
use pocketmine\Player;
use pocketmine\Server;

use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\EnchantParticle;
use pocketmine\level\sound\PopSound;

use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

use pocketmine\utils\config;

class LevelUpData {
	
    	private $plugin;
	
	private $level;
	
	private $unlocked;
	
    	private $title = "§aYour §5wizardry skill Leveled up";
    	private $message = "§7(§a!§7) §3you are now level ";

    	public function __construct(Main $plugin) {
    	    $this->plugin = $plugin;
    	}
	
    	public function getPlugin() {
	    return $this->plugin;
    	}
       
        public function onLevelUp(Player $player, int $level, $unlocked = null) {
		$this->unlocked = $unlocked;
		$config = new Config($this->plugin->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		$xp = ($level * 5);
		$nextXP = ($xp + 1);
        	if($player->getXpLevel() >= $xp && $player->getXpLevel() <= $nextXP && $config->get("level") == ($level - 1)){
	   	   $config->set("level", $this->plugin->getLevel($player) + 1);
	   	   $config->save();
			
		   	$player->addTitle($this->title);
		   	$player->sendMessage($this->message . $level);
	 	  	$this->plugin->getServer()->broadcastMessage(Translation::getMessage("broadcastLevelUp", ["player" => $player->getName(), "nextlevel" => $level]));
			
		   	$this->plugin->command("setxplevel" . $player->getName() . $level);
			
	   	   	$player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY()+0.3, $player->getZ())));	
	   	   	$player->getLevel()->addParticle(new EnchantParticle(new Vector3($player->getX(), $player->getY()+0.3, $player->getZ())));
           	   	$player->getlevel()->addSound(new PopSound($player));
			
            	   	$this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function(int $currentTick) use($player) : void {
		   	$player->sendPopup("§7(§a!§7) " . $this->unlocked);
				
	   	   	$player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY()+0.3, $player->getZ())));	
	   	   	$player->getLevel()->addParticle(new EnchantParticle(new Vector3($player->getX(), $player->getY()+0.3, $player->getZ())));
           	   	$player->getlevel()->addSound(new PopSound($player));
				
	    	   	}), 10);
		}
	}
	
	public function removeXp(Player $player) { 
		$player->setXpLevel(0);
		$player->setXpProgress(0);
	}
}
