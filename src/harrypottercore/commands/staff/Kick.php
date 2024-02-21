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

class Kick extends PluginCommand{
	
    public $playerList = [];

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("kick.use");
        $this->setDescription("Opens kick UI");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
           $this->kickuiform($sender);
       } else {
           $sender->sendMessage("§cYou do not have permission to use this command");
	    }
    }
	
    public function kickuiform(Player $player){
	    $list = [];
	    foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $p) {
		    $list[] = $p->getName();
	    }
				
	    $this->playerList[$player->getName()] = $list;
	    
            $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
		    	$indexlist = $data[0];
		    	$playername = $this->playerList[$player->getName()][$indexlist];
		    
	    		foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $target) {
				if($target->getName() == $playername) {
		    
			$target->kick($data[1]);
			$this->getPlugin()->message($player, Translation::getMessage("messageBan", ["type" => "kicked", "target" => $playername, "reason" => ($data[1])]));
			$this->getPlugin()->getServer()->broadcastMessage(Translation::getMessage("broadcastBan", ["player" => $player->getName(), "type" => "kicked", "target" => $playername, "reason" => ($data[1])]));
			}
		   }
	    });
	    $form->setTitle("§l§a-=KickUI=-");
	    $form->addDropdown("PlayerName: ", $this->playerList[$player->getName()]);
	    $form->addInput("Reason: ");
	    $form->sendToPlayer($player);
    }
}
