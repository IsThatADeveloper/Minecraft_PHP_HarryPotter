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

class Mute extends PluginCommand{

    private $owner;
	
    public $playerList = [];

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("mute.use");
        $this->setDescription("Opens mute UI");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
           $this->muteuiform($sender);
       } else {
           $sender->sendMessage("§cYou do not have permission to use this command");
	    }
    }
	
    public function muteuiform(Player $player){
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
		    
		     $indextime = $data[2];
		     $arrayName = array("§8[§330 Minutes§8]", "§8[§8§360 Minutes§8]", "§8[§3UnMute§8]");
		     $timing = $arrayName[$indextime];
		    
		     $indexmute = $data[0];
		     $arraymName = array("§8[§bMute§8]", "§8[§bUnMute§8]");
		     $timeMute = $arraymName[$indexmute];
		    
		     if($timing == "§8[§3UnMute§8]") {
			$this->getPlugin()->mutetime = 0;
		     }elseif($timing == "§8[§8§360 Minutes§8]") {
			$this->getPlugin()->mutetime = 60 * 60;
		     }elseif($timing == "§8[§330 Minutes§8]") {
			$this->getPlugin()->mutetime = 30 * 60;
		     }
		    
	    	     foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $target) {
			     if($target->getName() == $playername) {
				     
		     if($timeMute == "§8[§bUnMute§8]") {
		        if(!isset($this->getPlugin()->mute[$target->getName()])){
			   $this->getPlugin()->message($player, Translation::getMessage("userNotMuted", ["target" => $playername]));
		        }elseif(time() < $this->getPlugin()->mute[$target->getName()]){
				$this->getPlugin()->message($player, Translation::getMessage("unmutePlayer", ["target" => $playername]));
				$this->getPlugin()->message($player, Translation::getMessage("unmuteTarget"));
			        unset($this->getPlugin()->mute[$target->getName()]);	
			}
		    
		     }elseif($timeMute == "§8[§bMute§8]") {
		     if(!isset($this->getPlugin()->mute[$target->getName()])){
			$this->getPlugin()->mute[$target->getName()] = time() + $this->getPlugin()->mutetime;
			$this->getPlugin()->message($player, Translation::getMessage("mutePlayer", ["time" => ($this->getPlugin()->getMuteTime() / 60), "target" => $playername]));
			$this->getPlugin()->message($target, Translation::getMessage("muteTarget", ["time" => ($this->getPlugin()->getMuteTime() / 60), "player" => $player->getName()]));
		     	}
		     }
		 }
		 }
	    });
	    $form->setTitle("§l§a-=MuteUI=-");
	    $array = array("§8[§bMute§8]", "§8[§bUnMute§8]");
	    $form->addDropdown("Mute: ", $array);
	    $form->addDropdown("PlayerName: ", $this->playerList[$player->getName()]);
	    $array2 = array("§8[§330 Minutes§8]", "§8[§8§360 Minutes§8]", "§8[§3UnMute§8]");
	    $form->addDropdown("Time (minutes): ", $array2);
	    $form->sendToPlayer($player);
    }
}	
