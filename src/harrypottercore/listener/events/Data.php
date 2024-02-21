<?php

namespace harrypottercore\listener\events;

use harrypottercore\Main;
use harrypottercore\messages\Translation;

use pocketmine\entity\Entity;

//tasks
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

//entities
use harrypottercore\entity\command\Test;
use harrypottercore\entity\Magic;
use harrypottercore\entity\Golden;
use harrypottercore\entity\Bludger;
use harrypottercore\entity\Quaffle;
use harrypottercore\entity\Dragon;

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

//item
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\item\ItemFactory;

//pocketmine
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\utils\Utils;
use pocketmine\plugin\Plugin;

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;

use pocketmine\utils\Config;

class Data implements Listener{

    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function cordConfig(): void {
            if(!file_exists($this->plugin->cordFolder . "cords.yml")) {
		 $cord = new Config($this->plugin->cordFolder . "/cords.yml", Config::YAML);
            	 $xyz = [
      	    		$cord->setNested("spawnx", 0),
      	    		$cord->setNested("spawny", 0),
      	    		$cord->setNested("spawnz", 0),
      	    		$cord->setNested("sworld", 0),
      	    		$cord->setNested("hogwartx", 0),
      	    		$cord->setNested("hogwarty", 0),
      	    		$cord->setNested("hogwartz", 0),
      	    		$cord->setNested("diagonx", 0),
      	    		$cord->setNested("diagony", 0),
      	    		$cord->setNested("diagonz", 0),
      	    		$cord->setNested("woodsx", 0),
      	    		$cord->setNested("woodsy", 0),
      	    		$cord->setNested("woodsz", 0),
      	    		$cord->setNested("hagridx", 0),
      	    		$cord->setNested("hagridy", 0),
      	    		$cord->setNested("hagridz", 0)
      	    	 ];
      	    	 $cord->save();
	    }
    }
	
    public function registerCreativeItems(): void { 
	    //wands
	    $this->addCreativeItem(262, 34, "§aElder Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 10\n§5Attack Speed§8:§c 10");
	    $this->addCreativeItem(262, 7, "§aBasic Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 2\n§5Attack Speed§8:§c 2");
	    $this->addCreativeItem(262, 17, "§aCrimson Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 4\n§5Attack Speed§8:§c 4");
	    $this->addCreativeItem(262, 26, "§aDeathEater Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 5\n§5Attack Speed§8:§c 8");
	    $this->addCreativeItem(262, 10, "§aRon's Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 6\n§5Attack Speed§8:§c 8");
	    $this->addCreativeItem(262, 7, "§aHermione's Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 8\n§5Attack Speed§8:§c 6");
	    $this->addCreativeItem(262, 7, "§aHarryPotter's Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 10\n§5Attack Speed§8:§c 9");
	    $this->addCreativeItem(262, 7, "§aPhoenix Wand", "§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 0\n§5Attack Speed§8:§c 12");
	    
	    //brooms
	    $this->addCreativeItem(290, 0, "Nimbus 2000", "§8[§eRight-Click§8] §aTo use (need to be level 4 wizard)\n§5Health§8:§c 2 per use");
	    $this->addCreativeItem(290, 0, "Nimbus 2001", "§8[§eRight-Click§8] §aTo use (need to be level 4 wizard)\n§5Health§8:§c 3 per use");
	    $this->addCreativeItem(290, 0, "Thunderbolt VII", "§8[§eRight-Click§8] §aTo use (need to be level 4 wizard)\n§5Health§8:§c 0.5 per use");
	    
	    //potions
	    $this->addCreativeItem(373, 27, "§8Skele-Gro §aP§bo§at§bi§ao§bn", "§8Skele-Gro §aP§bo§at§bi§ao§bn");
	    $this->addCreativeItem(373, 36, "§0Draught of Living Death", "§0Draught of Living Death");
	    $this->addCreativeItem(373, 13, "§5Elixir §fof §cLife", "§5Elixir §fof §cLife");
	    $this->addCreativeItem(373, 4, "§dAmortentia §aP§bo§at§bi§ao§bn", "§dAmortentia §aP§bo§at§bi§ao§bn");
    }
	
    public function registerEntities(): void { 
            Entity::registerEntity(Magic::class, true);
            Entity::registerEntity(Golden::class, true);
            Entity::registerEntity(Bludger::class, true);
            Entity::registerEntity(Quaffle::class, true);
    }
	
    public function loadTextures(): void { 
	    $this->plugin->saveResource("Textures/golden.json");
            $this->plugin->saveResource("Textures/golden.png");
	    $this->plugin->saveResource("Textures/bludger.json");
            $this->plugin->saveResource("Textures/bludger.png");
	    $this->plugin->saveResource("Textures/quaffle.json");
            $this->plugin->saveResource("Textures/quaffle.png");
    }
	
    public function loadWorlds(): void { 
	    $this->plugin->getServer()->loadLevel("HogWarts");
    }
	   
    public function addCreativeItem($itemID, $itemMeta, $itemName, String $itemLore) {
	return Item::addCreativeItem(Item::get($itemID, $itemMeta)->setCustomName($itemName)->setLore([$itemLore])); // $this->addCreativeItem(1, 0, "Stone", "Lore");
    }
}
