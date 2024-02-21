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

class NightVision extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("nv.use");
        $this->setDescription("Activates night vision boost");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
                 if($sender->hasEffect(Effect::NIGHT_VISION)) {
                    $sender->removeEffect(Effect::NIGHT_VISION);
                    $sender->sendPopup(Translation::getMessage("deactivateBoost", ["boost" => "§1Night Vision"]));
                  }else{
                    $sender->getlevel()->addSound(new PopSound($sender));
                    $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), (99999999 * 20), (1), (true)));
                    $sender->sendPopup(Translation::getMessage("activateBoost", ["boost" => "§1Night Vision"]));
                    }
                  }else{
                    $this->getPlugin()->message($sender, Translation::getMessage("canBeBought"));
        }
    }
}

