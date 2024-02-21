<?php

namespace harrypottercore\commands\essential;

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
use harrypottercore\messages\Translation;

class Fly extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("fly.use");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
   	 if ($sender->hasPermission("fly.command")) {
            if (!isset($args[0])) {
                $sender->sendMessage("§7(§c!§7) §cUsage /§cfly {on/off} {playername}");
                return false;
            }
            if (!isset($args[1])) {
                $sender->sendMessage("§7(§c!§7) §cUsage /§cfly {on/off} {playername}");
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'on':
                      $target = $this->getPlugin()->getServer()->getPlayer($args[1]);
                      if ($target->isOnline() and $target !== null) {
			  $p = $sender->getName();
			  $tname = $target->getName();
			  $target->setAllowFlight(true);
                          $sender->sendPopup(Translation::getMessage("flySet"));
 			  $this->getPlugin()->message($target, Translation::getMessage("flySetTarget", ["player" => $p]));
                        } else {
                          $this->getPlugin()->message($sender, Translation::getMessage("notOnline", ["player" => ($args[1])]));
                        }
                        break;
                    case 'off':
                        $target = $this->getPlugin()->getServer()->getPlayer($args[1]);
                        if ($target->isOnline() and $target !== null) {
			    $p = $sender->getName();
			    $tname = $target->getName();
			    $target->setAllowFlight(false);
                            $sender->sendPopup(Translation::getMessage("flyRemoved"));
                            $this->getPlugin()->message($target, Translation::getMessage("flyRemovedTarget", ["player" => $p]));
                        } else {
                            $this->getPlugin()->message($sender, Translation::getMessage("notOnline", ["player" => ($args[1])]));
                        }
                        break;
                }
            }
        } else {
	    $this->getPlugin()->message($sender, Translation::getMessage("canBeBought"));
            return false;
            }
     return false;
     }
}
