<?php

namespace harrypottercore\commands\spawn;

use harrypottercore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;
use pocketmine\level\Location;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\command\ConsoleCommandSender;

use harrypottercore\messages\Translation;

//config
use pocketmine\utils\config;

class Spawn extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("spawn.use");
        $this->setUsage("/spawn");
        $this->setDescription("Teleports to prison spawn");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
		
	   $cord = new Config($this->getPlugin()->cordFolder . "/cords.yml", Config::YAML);
	   $x = $cord->get("spawnx");
	   $y = $cord->get("spawny");
	   $z = $cord->get("spawnz");
	   $worldmade = $cord->get("sworld");
		
	   if($worldmade == null) {
	      $this->getPlugin()->message($sender, Translation::getMessage("spawnNotSet"));
	   }else{
     	      $world = $this->getPlugin()->getServer()->getLevelByName($worldmade);
     	      $sender->teleport($world->getSafeSpawn());
	      $sender->teleport(new Vector3($x, $y, $z, 0, 0));
	      $sender->addTitle(Translation::getMessage("playerWarping"));
	      }
          } else {
	      $this->getPlugin()->message($sender, Translation::getMessage("noPermission"));
	}
    }
}
