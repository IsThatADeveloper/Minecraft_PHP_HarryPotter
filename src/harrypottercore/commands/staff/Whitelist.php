<?php

namespace harrypottercore\commands\staff;

use harrypottercore\Main;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;

use harrypottercore\messages\Translation;

class Whitelist extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("whitelist.use");
        $this->setDescription("Opens whitelist add UI");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
           $this->whitelistuiform($sender);
       } else {
           $sender->sendMessage("§cYou do not have permission to use this command");
	    }
        }
	
    public function whitelistuiform(Player $player){
            $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[0];
			$arrayName = array("§8[§8Whitelist Add]", "§8[§8Whitelist Remove]");
		    	$arrayValue = $arrayName[$index];
		    	
		    	if($arrayValue == "§8[§8Whitelist Add]") {
				$this->getPlugin()->getServer()->addWhitelist($data[1]);
				$this->getPlugin()->message($player, Translation::getMessage("whitelist", ["player" => ($data[1]), "type" => "Added"]));
			}elseif($arrayValue == "§8[§8Whitelist Remove]") {
				$this->getPlugin()->message($player, Translation::getMessage("whitelist", ["player" => ($data[1]), "type" => "Removed"]));
				$this->getPlugin()->getServer()->removeWhitelist($data[1]);
	    		}
	    });
	    $form->setTitle("§l§a-=WizardWhitelist=-");
	    $array = array("§8[§8Whitelist Add]", "§8[§8Whitelist Remove]");
	    $form->addDropdown("§8Whitelist Options", $array);
	    $form->addInput("PlayerName: ");
	    $form->sendToPlayer($player);
    }
}
