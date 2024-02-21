<?php 

namespace harrypottercore\task;

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

//mp
use onebone\mpapi\MpAPI; 

//main
use harrypottercore\Main;

use harrypottercore\task\store\StoreTasks;

class AddMp extends PluginTask {

    private $plugin;

    public function __construct(Plugin $plugin){
	$this->plugin = $plugin;
    }

    public function getPlugin(){
	return $this->plugin;
    }
	
    public function getStore() { 
	    return new StoreTasks($this->plugin);
    }

    public function onRun($tick) {
      $this->getStore()->getMpTask(mt_rand(1, 2)); 
    }
}
