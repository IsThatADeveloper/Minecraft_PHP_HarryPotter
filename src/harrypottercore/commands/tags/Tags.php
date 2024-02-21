<?php

namespace harrypottercore\commands\tags;

use harrypottercore\Main;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
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

use harrypottercore\messages\Translation;

use harrypottercore\commands\tags\TagFiles;

class Tags extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setDescription("Opens tags UI");
        $this->setAliases(["tag"]);
    }
	
    public function getStore() { 
	    return new TagFiles($this->getPlugin());
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
           //$this->Tags($sender);
	    
	   $this->Tags($sender);
    }
	
    public function Tags(Player $player){
	$prefix = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PureChat");
        $form = new SimpleForm(function (Player $player, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
                case 0:
	    $this->getStore()->setTag($player, "settag.permission.sorcerer", "§k§c;§r§l§5Sorcerer§r§k§c;§r");
                break;
			    
                case 1:
	    $this->getStore()->setTag($player, "settag.permission.goblin", "§k§b;§r§2Goblin§k§b;§r");
                break;
			    
                case 2:
	    $this->getStore()->setTag($player, "settag.permission.witch", "§aW§di§bt§ec§3h");
                break;
			    
                case 3:
	    $this->getStore()->setTag($player, "settag.permission.evil", "§4§l§k;;§r§0EVIL§4§l§k;;§r");
                break;
			    
                case 4:
	    $this->getStore()->setTag($player, "settag.permission.pure", "§b§k;;§r§f§lPURE§r§b§k;;§r§f");
                break;
			    
                case 5:
	    $this->getStore()->setTag($player, "settag.permission.deatheater", "§l§cDeath§0EATER§r");
                break;
			    
                case 6:
	    $this->getStore()->setTag($player, "settag.permission.dementor", "§0§lD§fe§0m§fe§0n§ft§0o§fr");
                break;
			    
                case 7:
	    $this->getStore()->setTag($player, "settag.permission.basilisk", "§k2;;§r§4Basilisk§k2;;§r");
                break;
			    
                case 8:
	    $this->getStore()->setTag($player, "settag.permission.warewolf", "§8§k:§r§3WareWolf§8§k:§r");
                break;
			    
                case 9:
	    $this->getStore()->setTag($player, "settag.permission.thunder", "§eThUnDeR§r");
                break;
			    
                case 10:
	    $this->getStore()->setTag($player, "settag.permission.fluffy", "§f§k;;§r§6FLUFFY§f§k;;§r");
                break;
			    
                case 11:
	    $this->getStore()->setTag($player, "settag.permission.buckbeak", "§f§lBuck§dBeak§r");
                break;
			    
                case 12:
	    $this->getStore()->setTag($player, "settag.permission.unicorn", "§f§lUNICORN");
                break;
			    
                case 13:
	    $this->getPlugin()->setPlayerPrefix($player, null);
                break;
            }
	});
        $form->setTitle("§l-=§aTagsUI§r§l=-");
	$form->setContent("Choose a tag to use");
	$form->addButton($player->hasPermission("settag.permission.sorcerer") === true ? ("§k§c;§r§l§5Sorcerer§r§k§c;§r") . "\n§aAVAILABLE" : ("§k§c;§r§l§5Sorcerer§r§k§c;§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.goblin") === true ? ("§k§b;§r§2Goblin§k§b;§r") . "\n§aAVAILABLE" : ("§k§b;§r§2Goblin§k§b;§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.witch") === true ? ("§aW§di§bt§ec§3h") . "\n§aAVAILABLE" : ("§aW§di§bt§ec§3h") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.evil") === true ? ("§4§l§k;;§r§0EVIL§4§l§k;;§r") . "\n§aAVAILABLE" : ("§4§l§k;;§r§0EVIL§4§l§k;;§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.pure") === true ? ("§b§k;;§r§f§lPURE§r§b§k;;§r§f") . "\n§aAVAILABLE" : ("§b§k;;§r§f§lPURE§r§b§k;;§r§f") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.deatheater") === true ? ("§l§cDeath§0EATER§r") . "\n§aAVAILABLE" : ("§l§cDeath§0EATER§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.dementor") === true ? ("§0§lD§fe§0m§fe§0n§ft§0o§fr") . "\n§aAVAILABLE" : ("§0§lD§fe§0m§fe§0n§ft§0o§fr") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.basilisk") === true ? ("§k2;;§r§4Basilisk§k2;;§r") . "\n§aAVAILABLE" : ("§k2;;§r§4Basilisk§k2;;§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.warewolf") === true ? ("§8§k:§r§3WareWolf§8§k:§r") . "\n§aAVAILABLE" : ("§8§k:§r§3WareWolf§8§k:§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.thunder") === true ? ("§eThUnDeR§r") . "\n§aAVAILABLE" : ("§eThUnDeR§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.fluffy") === true ? ("§f§k;;§r§6FLUFFY§f§k;;§r") . "\n§aAVAILABLE" : ("§f§k;;§r§6FLUFFY§f§k;;§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.buckbeak") === true ? ("§f§lBuck§dBeak§r") . "\n§aAVAILABLE" : ("§f§lBuck§dBeak§r") . "\n§cLOCKED");
	$form->addButton($player->hasPermission("settag.permission.unicorn") === true ? ("§f§lUNICORN") . "\n§aAVAILABLE" : ("§f§lUNICORN") . "\n§cLOCKED");
	$form->addButton("§8Remove Tag");
	$form->addButton("§cEXIT");
        $form->sendToPlayer($player);
        return $form;
    }
}
