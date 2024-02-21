<?php

namespace harrypottercore\commands\spawn;

use harrypottercore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI;

use pocketmine\utils\config;

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;

use harrypottercore\messages\Translation;

class Setwarps extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("setwarp.use");
        $this->setDescription("Sets Warps");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
         if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
	    $cord = new Config($this->getPlugin()->cordFolder . "/cords.yml", Config::YAML);
	    $level = $sender->getLevel()->getFolderName();
            if (!isset($args[0])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§csetwarp §7{§cdiagon§7/§chogwarts§7/§cwoods§7/§chagrid§7}");
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'diagon':
                            $x = $sender->getX();
                            $y = $sender->getY();
                            $z = $sender->getZ();
	   		    $cord->set("diagonx", $x);
	   		    $cord->set("diagony", $y);
	   		    $cord->set("diagonz", $z);
			    $this->getPlugin()->message($sender, Translation::getMessage("setLocation", ["area" => ucwords("diagon alley"), "x" => $x, "y" => $y, "z" => $z]));
			    $cord->save();
                        break;
                    case 'hogwarts':
                            $x = $sender->getX();
                            $y = $sender->getY();
                            $z = $sender->getZ();
	   		    $cord->set("hogwartx", $x);
	   		    $cord->set("hogwarty", $y);
	   		    $cord->set("hogwartz", $z);
			    $this->getPlugin()->message($sender, Translation::getMessage("setLocation", ["area" => ucwords("hogwarts"), "x" => $x, "y" => $y, "z" => $z]));
			    $cord->save();
                        break;
                    case 'woods':
                            $x = $sender->getX();
                            $y = $sender->getY();
                            $z = $sender->getZ();
	   		    $cord->set("woodsx", $x);
	   		    $cord->set("woodsy", $y);
	   		    $cord->set("woodsz", $z);
			    $this->getPlugin()->message($sender, Translation::getMessage("setLocation", ["area" => ucwords("woods"), "x" => $x, "y" => $y, "z" => $z]));
			    $cord->save();
                        break;
                    case 'hagrid':
                            $x = $sender->getX();
                            $y = $sender->getY();
                            $z = $sender->getZ();
	   		    $cord->set("hagridx", $x);
	   		    $cord->set("hagridy", $y);
	   		    $cord->set("hagridz", $z);
			    $this->getPlugin()->message($sender, Translation::getMessage("setLocation", ["area" => ucwords("hagrid"), "x" => $x, "y" => $y, "z" => $z]));
			    $cord->save();
                        break;
                }
            }
        } else {
	    $this->getPlugin()->message($sender, Translation::getMessage("noPermission"));
            return false;
        }
        return false;
    }
}
