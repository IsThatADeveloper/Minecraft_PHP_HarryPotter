<?php

namespace harrypottercore\commands\builder;

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

class Gmc extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("gmc.use");
        $this->setDescription("Change your gamemode to creative");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
                    $sender->getlevel()->addSound(new PopSound($sender));
                    $sender->setGamemode(1);
                    $sender->addTitle(Translation::getMessage("gamemode", ["type" => $sender->getGamemode()]));
                } else {
                    $this->getPlugin()->message($sender, (Translation::getMessage("noPermission")));
        }
    }
}
