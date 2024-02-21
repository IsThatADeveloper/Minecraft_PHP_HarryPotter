<?php

namespace harrypottercore\listener\events\levelup;

use harrypottercore\Main;
use harrypottercore\messages\Translation;
use harrypottercore\listener\events\levelup\LevelUpData;

//event
use pocketmine\event\player\PlayerExperienceChangeEvent;
use pocketmine\event\player\PlayerMoveEvent;

//tasks
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

//pocketmine
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;

use pocketmine\entity\Human;

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;

use pocketmine\utils\Config;

class LevelUpSystems implements Listener{
	
    public $title = "§aYour §5wizardry skill Leveled up";
    public $message = "§7(§a!§7) §3you are now level ";

    private $plugin;
	
    public $permission;
	
    public $defense;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function getStore() { 
	    return new LevelUpData($this->plugin);
    }

    public function playerGainWizardLevel(PlayerExperienceChangeEvent $event){
	$player = $event->getEntity();
	if($player instanceof Player and $player instanceof Human) {
	   if(!$this->plugin->isComplete($player)){
	      $event->setCancelled(true);
	      $player->sendMessage("§aYou need to complete the tutorial to start leveling your magic");
	      }
	      $this->getStore()->onLevelUp($player, 1, "§aLeveling up to level 1 unlocked you new warp");
	      $this->getStore()->onLevelUp($player, 2, null);
	      $this->getStore()->onLevelUp($player, 3, "§aLeveling up to level 3 unlocked you new warp");
	      $this->getStore()->onLevelUp($player, 4, "§aLeveling up to level 4 unlocked you new warp");
	      $this->getStore()->onLevelUp($player, 5, null);
	      $this->getStore()->onLevelUp($player, 6, null);
	      $this->getStore()->onLevelUp($player, 7, null);
	      $this->getStore()->onLevelUp($player, 8, null);
	      $this->getStore()->onLevelUp($player, 9, null);
	      $this->getStore()->onLevelUp($player, 10, null);
	      $this->getStore()->onLevelUp($player, 11, null);
	      $this->getStore()->onLevelUp($player, 12, null);
	      $this->getStore()->onLevelUp($player, 13, null);
	      $this->getStore()->onLevelUp($player, 14, null);
	      $this->getStore()->onLevelUp($player, 15, null);
	      $this->getStore()->onLevelUp($player, 16, null);
	      $this->getStore()->onLevelUp($player, 17, null);
	      $this->getStore()->onLevelUp($player, 18, null);
	      $this->getStore()->onLevelUp($player, 19, null);
	      $this->getStore()->onLevelUp($player, 20, null);
	}
    }
	
    public function playerDefenseUpgrade(PlayerMoveEvent $event) {
	$player = $event->getPlayer();
	$config = new Config($this->plugin->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
	$p = $player->getName();
       	if(mt_rand(1, 100000) == 25) {
	   $config->set("defense", $this->plugin->getDefense($player) + 1);
	   $config->save();
	   $this->defense = (int) $config->get("defense");
	   if($this->defense == 0) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 1) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 2) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 3) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 4) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 5) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 6) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 7) {
	      $player->sendMessage(Translation::getMessage("defenseUpgrade", ["defense" => $this->defense + 1]));
	   }elseif($this->defense == 8) {
	      $player->sendMessage(Translation::getMessage("defenseMax"));
	   }
	}
    }
}

