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

//config
use pocketmine\utils\config;

use harrypottercore\messages\Translation;

use function strtolower;

class Ban extends PluginCommand{
	
    public $playerList = [];

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("ban.use");
        $this->setDescription("Opens ban UI");
    }   
   
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
           $this->banuiform($sender);
       } else {
           $sender->sendMessage("§cYou do not have permission to use this command");
	    }
    }
	
    public function banuiform(Player $player){
	    $list = [];
	    foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $p) {
		    $list[] = $p->getName();
	    }
				
	    $this->playerList[$player->getName()] = $list;
	    
            $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
		    	$indexlist = $data[1];
		    	$playername = $this->playerList[$player->getName()][$indexlist];
		    
                	$index = $data[0];
			$arrayName = array("§8[§8Ban Player]", "§8[§8IPBan Player]");
		    	$arrayValue = $arrayName[$index];
		    	
		    	if($arrayValue == "§8[§8Ban Player]") {
				   $this->getPlugin()->getServer()->getNameBans()->addBan($playername, $data[2]);
				   $this->getPlugin()->message($player, Translation::getMessage("broadcastBan", ["type" => "banned", "target" => $playername, "reason" => ($data[2])]));
				   $this->getPlugin()->getServer()->broadcastMessage(Translation::getMessage("broadcastBan", ["player" => $player->getName(), "type" => "banned", "target" => $playername, "reason" => ($data[2])]));
			}elseif($arrayValue == "§8[§8IPBan Player]") {
				$config = new Config($this->getPlugin()->playerFolder . strtolower($playername) . ".yml", Config::YAML);
				$ip = $config->get("ip");
				$this->getPlugin()->message($player, Translation::getMessage("broadcastBan", ["type" => "Ip banned", "target" => $playername, "reason" => ($data[2])]));
				$this->getPlugin()->getServer()->broadcastMessage(Translation::getMessage("broadcastBan", ["player" => $player->getName(), "type" => "Ip banned", "target" => $playername, "reason" => ($data[2])]));
				$this->getPlugin()->getServer()->getIPBans()->addBan($ip, $data[2]);
	    		}
	    });
	    $form->setTitle("§l§a-=BanUI=-");
	    $array = array("§8[§8Ban Player]", "§8[§8IPBan Player]");
	    $form->addDropdown("§8Ban Options", $array);
	    $form->addDropdown("PlayerName: ", $this->playerList[$player->getName()]);
	    $form->addInput("Reason: ");
	    $form->sendToPlayer($player);
    }
}
