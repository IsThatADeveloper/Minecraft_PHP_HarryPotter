<?php

namespace harrypottercore\commands\settings;

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
use onebone\tokenapi\TokenAPI;
use onebone\mpapi\MpAPI;
use muqsit\invmenu\inventories\BaseFakeInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\inventories\DoubleChestInventory;
use muqsit\invmenu\inventories\SingleBlockInventory;
use muqsit\invmenu\tasks\DelayedFakeBlockDataNotifyTask;
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use muqsit\invmenu\inventories\ChestInventory;
use pocketmine\event\inventory\InventoryCloseEvent;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use harrypottercore\utils\Scoreboard;

use harrypottercore\messages\Translation;

class Setting extends PluginCommand{

    private $owner;
    public $group;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args) {  
       $this->settingform($player);
    }
    
    public function settingform(Player $sender) {
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                $this->getPlugin()->message($sender, $this->getPlugin()->getDiscord());
                        break;
                        case 1:
		if($this->getPlugin()->getSound($sender) == false) { 
		   $this->getPlugin()->setSound($sender, true);
		   $this->getPlugin()->message($sender, Translation::getMessage("setSound", ["type" => "on"]));
		}elseif($this->getPlugin()->getSound($sender) == true) { 
		   $this->getPlugin()->setSound($sender, false);
		   $this->getPlugin()->message($sender, Translation::getMessage("setSound", ["type" => "off"]));
		}
			break;
                        case 2:
		if($sender->hasPermission("scoreboard.use")){
		   \harrypottercore\utils\Scoreboard::remove($sender);
	           $this->getPlugin()->unsetPermission($sender, "scoreboard.use");
		   $this->getPlugin()->message($sender, Translation::getMessage("scoreboardRemoved"));
	        }elseif(!$sender->hasPermission("scoreboard.use")){
			\harrypottercore\utils\Scoreboard::add($player, 'harrypottercore', "§k§l§f-§r§cWizarding§3Mania§k§f§l-§r§l§f");
	                $this->getPlugin()->setPermission($sender, "scoreboard.use");
		        $this->getPlugin()->message($sender, Translation::getMessage("scoreboardAdded"));
		}
                        break;
                        case 3:
                $sender->getInventory()->clearAll();
		$this->getPlugin()->message($sender, Translation::getMessage("clearedInventory"));
                            break;
                        case 4:
	        $purePerms = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PurePerms");
	        $group = $purePerms->getGroup("Guest");
	        $purePerms->setGroup($sender, $group);
		if($this->getPlugin()->getGroup($sender) == "Slytherin"){
	           $this->getPlugin()->unsetPermission($sender, "slytherin.use");
	  	   $this->getPlugin()->message($sender, Translation::getMessage("setDefaultWizard"));
	  	}elseif($this->getPlugin()->getGroup($sender) == "Gryffindor"){
	           	$this->getPlugin()->unsetPermission($sender, "gryffindor.use");
			$this->getPlugin()->message($sender, Translation::getMessage("setDefaultWizard"));
		}elseif($this->getPlugin()->getGroup($sender) == "Ravenclaw"){
	           	$this->getPlugin()->unsetPermission($sender, "ravenclaw.use");
			$this->getPlugin()->message($sender, Translation::getMessage("setDefaultWizard"));
		}elseif($this->getPlugin()->getGroup($sender) == "Hufflepuff"){
	           	$this->getPlugin()->unsetPermission($sender, "hufflepuff.use");
			$this->getPlugin()->message($sender, Translation::getMessage("setDefaultWizard"));
		}
                            break;
                        case 5:
                $sender->setXpLevel(0);
		$sender->setXpProgress(0);
		$config = new Config($this->getPlugin()->playerFolder . $sender->getLowerCaseName() . ".yml", Config::YAML);
		$config->setAll(["xplevel" => 0, "level" => 0]);
		$config->save();
		$this->getPlugin()->message($sender, Translation::getMessage("wizardReset"));
                            break;
                        case 6:
                $name = $sender->getName();
		MpAPI::getInstance()->setMp($sender, 0);
		$this->getPlugin()->message($sender, Translation::getMessage("mpReset"));
                            break;
                        case 7:
                $name = $sender->getName();
		TokenAPI::getInstance()->setToken($sender, 0);
		$this->getPlugin()->message($sender, Translation::getMessage("tokenReset"));
                            break;
			}
    });
    $form->setTitle("§l§a-=Settings=-");
    $form->setContent("§8Game settings");
    $form->addButton("§3Contact Staff");
    $form->addButton("§3Sound on/off");
    $form->addButton("§3ScoreBoard add/remove");
    $form->addButton("§3Clear Inventory");
    $form->addButton("§3Reset Home");
    $form->addButton("§3Reset XP");
    $form->addButton("§3Reset Magical Power");
    $form->addButton("§3Reset Tokens");
    $form->sendToPlayer($sender);
    }
}
