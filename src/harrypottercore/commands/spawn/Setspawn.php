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
use onebone\tokenapi\TokenAPI;
use pocketmine\utils\config;

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;

use harrypottercore\messages\Translation;

class Setspawn extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("setspawn.use");
        $this->setDescription("Sets spawn");
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player->hasPermission($this->getPermission()) and $player instanceof Player){
	   $cord = new Config($this->getPlugin()->cordFolder . "/cords.yml", Config::YAML);
	   $level = $player->getLevel()->getFolderName();
	   $x = $player->getX();
	   $y = $player->getY();
	   $z = $player->getZ();
		
	   $cord->set("spawnx", $x);
	   $cord->set("spawny", $y);
	   $cord->set("spawnz", $z);
	   $cord->set("sworld", $level);
		
	   $this->getPlugin()->message($player, Translation::getMessage("setSpawn", ["level" => $level, "x" => $x, "y" => $y, "z" => $z]));
	   $cord->save();
	}
    }
}
