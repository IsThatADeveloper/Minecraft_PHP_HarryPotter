<?php

namespace harrypottercore\commands\cmd;

use harrypottercore\Main;
use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
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
use harrypottercore\messages\Translation;

class Tinker extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("tinker.use");
        $this->setDescription("Sells books for tokens");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
	       $item = $sender->getInventory()->getItemInHand();
	       if($item->getId() == 403) {
	          $book = Item::get(Item::ENCHANTED_BOOK);
	          $air = Item::get(Item::AIR);
	          $inv = $sender->getInventory();
	          $inv->setItemInHand($air);
	          $amount = mt_rand(2, 70);
                  TokenAPI::getInstance()->addToken($sender, $amount);
                  $this->getPlugin()->message($sender, Translation::getMessage("soldBook", ["amount" => $amount]));
               }else{
                  $this->getPlugin()->message($sender, Translation::getMessage("notHoldingBook"));
	       }
	   } else {
               $this->getPlugin()->message($sender, Translation::getMessage("noPermission"));
	}
    }
}
