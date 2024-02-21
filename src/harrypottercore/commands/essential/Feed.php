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

class Feed extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("feed.use");
        $this->setDescription("Fills your hunger");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
                    $sender->getlevel()->addSound(new PopSound($sender));
                    $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::SATURATION), (60 * 1), (1), (false)));
                    $sender->setFood(20);
                    $sender->sendPopup(Translation::getMessage("setHunger"));
                } else {
                    $this->getPlugin()->message($sender, Translation::getMessage("canBeBought"));
        }
    }
}
