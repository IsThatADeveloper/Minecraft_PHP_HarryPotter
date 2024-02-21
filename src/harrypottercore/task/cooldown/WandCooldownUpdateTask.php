<?php 

namespace harrypottercore\task\cooldown;

//math and level
use pocketmine\level\Location;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Level;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\math\Vector2;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\Server;
use pocketmine\plugin\Plugin;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;

//blocks
use pocketmine\block\BlockFactory;
use pocketmine\block\Air;
use pocketmine\block\Brick_Block;
use pocketmine\item\Hoe;
use pocketmine\item\Stick;
use pocketmine\item\SnowBall;
use pocketmine\item\Iron_Ingot;
use pocketmine\item\Dye;
use pocketmine\block\Grass;
use pocketmine\block\BrewingStand;
use pocketmine\block\Brewing_Stand;
use pocketmine\block\Dirt;
use pocketmine\block\Block;
use pocketmine\level\Position;

use pocketmine\utils\config;

//mp
use onebone\mpapi\MpAPI; 

//main
use harrypottercore\Main;

class WandCooldownUpdateTask extends PluginTask {

    private $plugin;
	
    public function __construct(Plugin $plugin){
    	$this->plugin = $plugin;
    }

    public function getPlugin(){
	return $this->plugin;
    }
	
    public function onRun($tick) {
	    foreach($this->plugin->getServer()->getOnlinePlayers() as $player) {
	    if($player instanceof Player) {
	       $cooldown = new Config($this->plugin->userCooldownFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
    	       $cooldown->setAll([
       		 	"elder" => $this->plugin->getElderCooldown($player),
       		 	"basic" => $this->plugin->getBasicCooldown($player),
			"crimson" => $this->plugin->getCrimsonCooldown($player),
			"deatheater" => $this->plugin->getDeathEaterCooldown($player),
			"ron" => $this->plugin->getRonCooldown($player),
			"hermione" => $this->plugin->getHermioneCooldown($player),
			"harrypotter" => $this->plugin->getHarryPotterCooldown($player),
			"pheonix" => $this->plugin->getPheonixCooldown($player),
			"slytherin" => $this->plugin->getSlytherinCooldown($player),
			"gryffindor" => $this->plugin->getGryffindorCooldown($player),
			"hufflepuff" => $this->plugin->getHufflepuffCooldown($player),
			"ravenclaw" => $this->plugin->getRavenclawCooldown($player),
			"harry" => $this->plugin->getHpCooldown($player),
			"death" => $this->plugin->getDeCooldown($player),
			"vold" => $this->plugin->getVoldCooldown($player)
    	      ]);
    	      $cooldown->save();
	      }
	  }
    }
}
