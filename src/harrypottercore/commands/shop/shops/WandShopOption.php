<?php

namespace harrypottercore\commands\shop\shops;

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

use harrypottercore\messages\Translation;
use harrypottercore\commands\shop\data\ShopStore;

//arrow ids / for wands 
//order|Basic|Clasic|Extra ->

class WandShopOption extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->setPermission("shop.use");
        $this->owner = $owner;
    }
	
    public function getStore() { 
	    return new ShopStore($this->getPlugin());
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {  
       $this->optionform($sender);
    }
	
    public function optionform(Player $player){
            $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[0];
			$arrayName = array("§8Basic Wand\n§a5 Tokens", "§8Clasic Wands", "§8Extra Wands");
		    	$arrayValue = $arrayName[$index];
		    	
		    	if($arrayValue == "§8Basic Wand\n§a5 Tokens") {
	   		   $this->getPlugin()->setPermission($player, "wandshop.use");
		           $this->getPlugin()->getServer()->dispatchCommand($player, "wandshop");
	   		   $this->getPlugin()->unsetPermission($player, "wandshop.use");
			}elseif($arrayValue == "§8Clasic Wands") {
                    		if($this->getPlugin()->isComplete($player)) {
                        	$this->clasic($player);
                    	     }else{ 
	      			$this->getPlugin()->message($player, Translation::getMessage("basicTutorial"));
				}
			}elseif($arrayValue == "§8Extra Wands") {
                    		if($this->getPlugin()->isComplete($player)) {
                        	$this->extra($player);
                    	     }else{ 
	      			$this->getPlugin()->message($player, Translation::getMessage("basicTutorial"));
				}
	    		}
	    });
	    $form->setTitle("§l§a-=WandShop=-");
	    $array = array("§8Basic Wand\n§a5 Tokens", "§8Clasic Wands", "§8Extra Wands");
	    $form->addDropdown("§8Wands", $array);	    
	    $form->sendToPlayer($player);
    }
	
    //wand types and shop for wands

    public function clasic(Player $sender) { 
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
	   $this->getStore()->getCustomShop($sender, 262, 6, 15, "§aRon's Wand");
                        break;
					
                        case 1:
	   $this->getStore()->getCustomShop($sender, 262, 22, 15, "§aHermione's Wand");
                        break;
					
                        case 2:
	   $this->getStore()->getCustomShop($sender, 262, 8, 20, "§aHarryPotter's Wand");
                        break;
					
                        case 3:
	   $this->getStore()->getCustomShop($sender, 262, 34, 25, "§aElder Wand");
                        break;
					
                        case 4:
           $this->classicinfo($sender);
                        break;
			}
    });
    $form->setTitle("§l§a-=WandShop=-");
    $form->setContent("§aTokens§8->§a". TokenAPI::getInstance()->myToken($sender));
    $form->addButton("§8Ron's Wand\n§a15 Tokens");
    $form->addButton("§8Hermione's Wand\n§a15 Tokens");
    $form->addButton("§8Harry Potter's Wand\n§a20 Tokens");
    $form->addButton("§8Elder Wand\n§a25 Tokens");
    $form->addButton("§8Wand Info");
    $form->sendToPlayer($sender);
    }
                       
    public function extra(Player $sender) { 
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
	   $this->getStore()->getCustomShop($sender, 262, 17, 6, "§aCrimson Wand");
                        break;
					
                        case 1:
	   $this->getStore()->getCustomShop($sender, 262, 36, 10, "§aDeathEater Wand");
                        break;
					
                        case 2:
	   $this->getStore()->getCustomShop($sender, 262, 37, 15, "§aPhoenix Wand");
                        break;
					
                        case 3:
            $this->extrainfo($sender);
                        break;
			}
    });
    $form->setTitle("§l§a-=WandShop=-");
    $form->setContent("§aTokens§8->§a". TokenAPI::getInstance()->myToken($sender));
    $form->addButton("§8Crimson Wand\n§a6 Tokens");
    $form->addButton("§8Death Eater Wand\n§a10 Tokens");
    $form->addButton("§8Phoenix Wand\n§a15 Tokens");
    $form->addButton("§8Wand Info");
    $form->sendToPlayer($sender);
    }
	
    public function classicinfo(Player $sender) {
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
		$this->ron($sender);
                        break;
                        case 1:
		$this->hermione($sender);
                        break;
                        case 2:
		$this->harry($sender);
                        break;
                        case 3:
		$this->elder($sender);
                        break;
      }
    });
    $form->setTitle("§l§a-=ClassicInfo=-");
    $form->setContent("§aPick a wand name to get information about it!");
    $form->addButton("§6Ron's §bWand");
    $form->addButton("§6Hermione's §bWand");
    $form->addButton("§6HarryPotter's §bWand");
    $form->addButton("§6Elder §aWand");
    $form->sendToPlayer($sender);
    }
	
    public function extrainfo(Player $sender) {
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
		$this->crimson($sender);
                        break;
                        case 1:
		$this->deatheater($sender);
                        break;
                        case 2:
		$this->phoenix($sender);
                        break;
      }
    });
    $form->setTitle("§l§a-=ExtraInfo=-");
    $form->setContent("§aPick a wand name to get information about it!");
    $form->addButton("§6Crimson §bWand");
    $form->addButton("§6Death Eater §bWand");
    $form->addButton("§6Phoenix §bWand");
    $form->sendToPlayer($sender);
    }

    //classic's wand function
	
    //extra's wand function
	
    public function crimson(Player $sender) {
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                        break;
      }
    });
    $form->setTitle("§l§a-=Crimson=-");
    $form->setContent("§aYour Tokens§8->§a". TokenAPI::getInstance()->myToken($sender) . ("\n§7Name: §bCrimson Wand\n§7Damage: 4\n§7Effects:§bWeakness\n§7Craftable: §bNo\n§7Mp: §bUsage[0.1]\n§7Cost: §b6t\n§7Description:§b This wand is made out of Crimson Wood, which tends to favor bookworms. The handle is made out of Birch Wood, which in turn usually prefers a rich owner. However, the combination of this strand of Crimson Wood and Birch Wood means the wand will seek out somebody with a talent for the most powerful magics./n/nA wand usually has 1 or 2 cores, but some have 3, this wand has 2 cores. A core of gargoyle dust which greatly increases magic transmission and goblin hair is added to boost the power of the gargoyle dust core./n/nThe wand measures 11 inches/28 cm and has a refined look to it. The particular strand of Crimson Wood used in this wand is common, which means the price of the wand won't be too high and gargoyle dust is common as well, resulting in a fairly cheap wand."));
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
    }
	
    public function deatheater(Player $sender) {
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                        break;
      }
    });
    $form->setTitle("§l§a-=DeathEater=-");
    $form->setContent("§aYour Tokens§8->§a". TokenAPI::getInstance()->myToken($sender) . ("\n§7Name: §bDeath Eater Wand\n§7Damage: 5\n§7Effects:§bHunger, Blindness\n§7Craftable: §bNo\n§7Mp: §bUsage[0.2]\n§7Cost: §b10t\n§7Description:§bThis wand is made out of Blackwood, which mostly seeks out those who tend to make the right choice. The handle is made out of Fiddlewood, which in turn usually favors those with a love of all creatures. However, the combination of this strand of Blackwood and Fiddlewood means the wand will seek out somebody with a vicious mind.\n\nA wand usually has 1 or 2 cores, but some have 3, this wand has 2 cores. A core of hippogriff claw which strengthens the wand and protects against magical damage and volcanic ash is added to constrain the power of the hippogriff claw core.\n\nThe wand measures 9 inches/23 cm and has a fairly plain look. The particular strand of Blackwood used in this wand is quite rare, which increases the production cost of the wand and hippogriff claw is quite rare as well, resulting in a wand exclusively for the rich or fortunate."));
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
    }
	
    public function pheonix(Player $sender) {
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                        break;
      }
    });
    $form->setTitle("§l§a-=Phoenix=-");
    $form->setContent("§aYour Tokens§8->§a". TokenAPI::getInstance()->myToken($sender) . ("\n§7Name: §bPhoenix Wand\n§7Damage: 0\n§7Effects:§bHealing\n§7Craftable: §bNo\n§7Mp: §bUsage[0.1]\n§7Cost: §b15t\n§7Description:§b This wand is made out of Cherry Wood, which usually prefers those who tend to follow instead of lead. The handle is made out of Spruce Wood, which in turn strongly prefers those with a wandering mind. However, the combination of this strand of Cherry Wood and Spruce Wood means the wand will seek out somebody who tends to follow instead of lead. A wand usually has 1 or 2 cores, but some have 3, this wand has 2 cores. A core of phoenix feather which has the ability to calm its owner in dire situations and hell hound tail hair is added to augment the power of the phoenix feather core. The wand measures 15 inches/38 cm and was clearly made by a professional. The particular strand of Cherry Wood used in this wand is incredibly rare, which increases the price of the wand and phoenix feather is quite rare as well, resulting in a pricey and healing wand."));
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
    }
	
    public function ron(Player $sender) {
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                        break;
      }
    });
    $form->setTitle("§l§a-=Ron=-");
    $form->setContent("§aYour Tokens§8->§a". TokenAPI::getInstance()->myToken($sender) . ("\n§7Name: §bRon's Wand\n§7Damage: 6\n§7Effects:§bslowness, blind, hunger\n§7Craftable: §bNo\n§7Mp: §bUsage[0.2]\n§7Cost: §b15 Tokens\n§7Description:§b This 14 inch wand was made of Willow and had a core of unicorn hair. Manufactured by Garrick Ollivander"));
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
    }
	
    public function hermione(Player $sender) {
	    $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                        break;
      }
    });
    $form->setTitle("§l§a-=Hermione=-");
    $form->setContent("§aYour Tokens§8->§a". TokenAPI::getInstance()->myToken($sender) . ("\n§7Name: §bHermione's Wand\n§7Damage: 8\n§7Effects:§bWither\n§7Craftable: §bNo\n§7Mp: §bUsage[0.2]\n§7Cost: §b15 Tokens\n§7Description:§b Hermione's wand was 10 3/4 inches long made of vine wood, and possessed a dragon heartstring core. The wand was manufactured by Garrick Ollivander sometime before Hermione's education at Hogwarts School of Witchcraft and Wizardry."));
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
    }
	
    public function harry(Player $sender) {
	    $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                        break;
      }
    });
    $form->setTitle("§l§a-=Harry=-");
    $form->setContent("§aYour Tokens§8->§a". TokenAPI::getInstance()->myToken($sender) . ("\n§7§7Name: §bHarry's Wand\n§7Damage: 10\n§7Effects:§bhunger, poison\n§7Craftable: §bNo\n§7Mp: §bUsage[0.5]\n§7Cost: §b20 Tokens\n§7Description:§b Harry Potter's wand was 11 inch long, made of holly, and possessed a phoenix feather core. Harry's wand was described as being nice and supple"));
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
    }
	
    public function elder(Player $sender) {
	    $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
                        case 0:
                        break;
      }
    });
    $form->setTitle("§l§a-=Elder=-");
    $form->setContent("§aYour Tokens§8->§a". TokenAPI::getInstance()->myToken($sender) . ("\n§7Name: §bElder Wand\n§7Damage: 10\n§7Effects:§bpoison, wither\n§7Craftable: §bYes\n§7Mp: §bUsage[0.5]\n§7Cost: §b25 Tokens\n§7Description:§b The Elder Wand is one of three objects that make up the fabled Deathly Hallows. It is said to be one of the most powerful wands that has ever existed, able to perform feats of magic that would normally be impossible even for the most skilled wizards"));
    $form->addButton("§cEXIT");
    $form->sendToPlayer($sender);
    }
}
