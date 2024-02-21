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

class Heal extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("heal.use");
        $this->setDescription("fills your health");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
                    $sender->setHealth(20);
                    $sender->setSaturation(20);
                    $sender->getlevel()->addSound(new PopSound($sender));
                    $player->sendPopup(Translation::getMessage("setHealth"));
                } else {
                    $this->getPlugin()->message($sender, Translation::getMessage("canBeBought"));
        }
    }
}
