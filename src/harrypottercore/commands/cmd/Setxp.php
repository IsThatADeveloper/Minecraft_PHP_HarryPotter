<?php

namespace harrypottercore\commands\cmd;

use harrypottercore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\level\sound\PopSound;
use onebone\tokenapi\TokenAPI;
use harrypottercore\messages\Translation;

//config
use pocketmine\utils\config;

class Setxp extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("setxp.use");
        $this->setDescription("Set your xp");
    }
	
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender->hasPermission("setxp.use")) {
            if (!isset($args[0])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§cxp §7{§cadd§7/§cremove/§clevel§7} §7{§cplayername§7} §7{§camount§7}");
                return false;
            }
            if (!isset($args[1])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§cxp §7{§cadd§7/§cremove/§clevel§7} §7{§cplayername§7} §7{§camount§7}");
                return false;
            }
            if (!isset($args[2])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§cxp §7{§cadd§7/§cremove/§clevel§7} §7{§cplayername§7} §7{§camount§7}");
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'add':
                        $target = $this->getPlugin()->getServer()->getPlayer($args[1]);
                        if ($target->isOnline()) {
                            $amount = $args[2];
           		    $target->setXpProgress(0);
                            $target->addXpLevels((int)$amount, true);
			    $p = $sender->getName();
			    $this->getPlugin()->message($target, Translation::getMessage("xpSet", ["player" => $target->getName(), "amount" => $amount]));
			    $this->getPlugin()->message($sender, Translation::getMessage("xpSetTarget", ["player" => $p, "amount" => $amount]));
                        } else {
                            $sender->sendMessage("§7(§c!§7) §c$args[1] is not online");
			}
                        break;
                    case 'remove':
                        $target = $this->getPlugin()->getServer()->getPlayer($args[1]);
                        if ($target->isOnline()) {
                            $amount = $args[2];
                            $target->subtractXpLevels((int)$amount);
			    $p = $sender->getName();
			    $this->getPlugin()->message($target, Translation::getMessage("xpRemoved", ["player" => $target->getName(), "amount" => $amount]));
			    $this->getPlugin()->message($sender, Translation::getMessage("xpRemovedTarget", ["player" => $p, "amount" => $amount]));
                        } else {
                            $sender->sendMessage("§7(§c!§7) §c$args[1] is not online");
                        }
                        break;	
                    case 'level':
                        $target = $this->getPlugin()->getServer()->getPlayer($args[1]);
                        if ($target->isOnline()) {
			    $config = new Config($this->getPlugin()->playerFolder . $target->getLowerCaseName() . ".yml", Config::YAML);
		 	    $config->setLevel($args[2]);
			    $this->getPlugin()->message($target, Translation::getMessage("xpRemovedTarget", ["player" => $target->getName(), "amount" => $args[1]]));
			    $this->getPlugin()->message($sender, Translation::getMessage("levelRemovedTarget", ["player" => $p, "amount" => $args[2]]));
                        } else {
                            $sender->sendMessage("§7(§c!§7) §c$args[1] is not online");
                        }
                        break;
                }
            }
        } else {
            $sender->sendMessage("§7(§c!§7) §cYou do not have permission to use this command");
            return false;
        }
        return false;
    }
}
