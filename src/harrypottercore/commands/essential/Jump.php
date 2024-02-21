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

class Jump extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("jump.use");
        $this->setDescription("Activates jump boost");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
                 if($sender->hasEffect(Effect::JUMP)) {
                    $sender->removeEffect(Effect::JUMP);
                    $sender->sendPopup(Translation::getMessage("deactivateBoost", ["boost" => "§aJump"]));
                  }else{
                    $sender->getlevel()->addSound(new PopSound($sender));
                    $sender->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP), (99999999 * 20), (1), (true)));
                    $player->sendPopup(Translation::getMessage("activateBoost", ["boost" => "§aJump"]));
                    }
                  }else{
                    $this->getPlugin()->message($sender, Translation::getMessage("canBeBought"));
        }
    }
}
