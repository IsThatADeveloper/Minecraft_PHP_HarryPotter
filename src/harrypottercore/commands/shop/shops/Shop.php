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
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

use harrypottercore\commands\shop\data\ShopStore;

class Shop extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setDescription("Opens shop ui");
    }
	
    public function getStore() { 
	    return new ShopStore($this->getPlugin());
    }
  
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
    	$this->ShopPage($sender);
    }
	
    public function ShopPage(Player $sender) {
    
	$form = new SimpleForm(function (Player $sender, $data){
	if ($data === null) {
            return;
	}
        switch ($data) {
            	case 0: 
	$this->ToolsPage($sender);
                break;
            	case 1: 
	$this->MiscPage($sender);
                break;        
		}
	});
        $form->setTitle("§a§l-=Shop=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Tools§7]");
        $form->addButton("§7[§8miscellaneous§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }

    public function ToolsPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->SwordsPage($sender);
                break;
			    
            	case 1: 
	$this->PickaxePage($sender);
                break;

            	case 2: 
	$this->AxesPage($sender);
                break;
                
            	case 3: 
	$this->ArmorPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=Tools=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Swords§7]");
	$form->addButton("§7[§8Pickaxes§7]");
        $form->addButton("§7[§8Axes§7]");
        $form->addButton("§7[§8Armor§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function SwordsPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->WoodSwordPage($sender);
                break;
			    
            	case 1: 
	$this->StoneSwordPage($sender);
                break;

            	case 2: 
	$this->IronSwordPage($sender);
                break;
                
            	case 3: 
	$this->DiamondSwordPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=Swords=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Wooden Sword§7]");
	$form->addButton("§7[§8Stone Sword§7]");
        $form->addButton("§7[§8Iron Sword§7]");
        $form->addButton("§7[§8Diamond Sword§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function PickaxePage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->WoodPickaxePage($sender);
                break;
			    
            	case 1: 
	$this->StonePickaxePage($sender);
                break;

            	case 2: 
	$this->IronPickaxePage($sender);
                break;
                
            	case 3: 
	$this->DiamondPickaxePage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=Pickaxes=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Wooden Pickaxe§7]");
	$form->addButton("§7[§8Stone Pickaxe§7]");
        $form->addButton("§7[§8Iron Pickaxe§7]");
        $form->addButton("§7[§8Diamond Pickaxe§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function AxesPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->WoodAxePage($sender);
                break;
			    
            	case 1: 
	$this->StoneAxePage($sender);
                break;

            	case 2: 
	$this->IronAxePage($sender);
                break;
                
            	case 3: 
	$this->DiamondAxePage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=Axes=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Wooden Pickaxe§7]");
	$form->addButton("§7[§8Stone Pickaxe§7]");
        $form->addButton("§7[§8Iron Pickaxe§7]");
        $form->addButton("§7[§8Diamond Pickaxe§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function ArmorPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->LeatherArmorPage($sender);
                break;
			    
            	case 1: 
	$this->GoldArmorPage($sender);
                break;

            	case 2: 
	$this->IronArmorPage($sender);
                break;
                
            	case 3: 
	$this->DiamondArmorPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=DiamondArmor=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Leather Armor§7]");
	$form->addButton("§7[§8Gold Armor§7]");
        $form->addButton("§7[§8Iron Armor§7]");
        $form->addButton("§7[§8Diamond Armor§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function LeatherArmorPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->LeatherHelmetPage($sender);
                break;
			    
            	case 1: 
	$this->LeatherChestplatePage($sender);
                break;

            	case 2: 
	$this->LeatherLeggingsPage($sender);
                break;
                
            	case 3: 
	$this->LeatherBootsPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=LeatherArmor=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Leather Helmet§7]");
	$form->addButton("§7[§8Leather Chestplate§7]");
        $form->addButton("§7[§8Leather Leggings§7]");
        $form->addButton("§7[§8Leather Boots§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function GoldArmorPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->GoldHelmetPage($sender);
                break;
			    
            	case 1: 
	$this->GoldChestplatePage($sender);
                break;

            	case 2: 
	$this->GoldLeggingsPage($sender);
                break;
                
            	case 3: 
	$this->GoldBootsPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=GoldenArmor=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Golden Helmet§7]");
	$form->addButton("§7[§8Golden Chestplate§7]");
        $form->addButton("§7[§8Golden Leggings§7]");
        $form->addButton("§7[§8Golden Boots§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function IronArmorPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->IronHelmetPage($sender);
                break;
			    
            	case 1: 
	$this->IronChestplatePage($sender);
                break;

            	case 2: 
	$this->IronLeggingsPage($sender);
                break;
                
            	case 3: 
	$this->IronBootsPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=IronArmor=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Iron Helmet§7]");
	$form->addButton("§7[§8Iron Chestplate§7]");
        $form->addButton("§7[§8Iron Leggings§7]");
        $form->addButton("§7[§8Iron Boots§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function DiamondArmorPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->DiamondHelmetPage($sender);
                break;
			    
            	case 1: 
	$this->DiamondChestplatePage($sender);
                break;

            	case 2: 
	$this->DiamondLeggingsPage($sender);
                break;
                
            	case 3: 
	$this->DiamondBootsPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=DiamondArmor=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8Diamond Helmet§7]");
	$form->addButton("§7[§8Diamond Chestplate§7]");
        $form->addButton("§7[§8Diamond Leggings§7]");
        $form->addButton("§7[§8Diamond Boots§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
  
    public function LeatherHelmetPage(CommandSender $sender) {
	  $this->getStore()->getShop($sender, 298, 0, 0.5, "Leather Hat");
    }
//leather chestplate
    public function LeatherChestplatePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 299, 0, 0.5, "Leather Chestplate");
    }
//leather leggings
    public function LeatherLeggingsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 300, 0, 0.5, "Leather Leggings");
    }
//leather boots
    public function LeatherBootsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 301, 0, 0.5, "Leather Boots");
    }
//leather armor UI finished
//gold armor ui
//gold helmet
    public function GoldHelmetPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 314, 0, 0.5, "Golden Helmet");
    }
//gold chestplate
    public function GoldChestplatePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 315, 0, 0.5, "Golden Chestplate");
    }
//gold leggings
    public function GoldLeggingsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 316, 0, 0.5, "Golden Leggings");
    }
//gold boots
    public function GoldBootsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 317, 0, 0.5, "Golden Boots");
    }
//gold armor UI finished
//iron armor ui
//iron helmet
    public function IronHelmetPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 306, 0, 1, "Iron Helmet");
    }
//iron chestplate
    public function IronChestplatePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 307, 0, 1, "Iron Chestplate");
    }
//iron leggings
    public function IronLeggingsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 308, 0, 1, "Iron leggings");
    }
//iron boots
    public function IronBootsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 309, 0, 1, "Iron Boots");
    }
//iron armor UI finished
//diamond armor ui
//diamond helmet
    public function DiamondHelmetPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 310, 0, 2, "Diamond Helmet");
    }
//diamond chestplate
    public function DiamondChestplatePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 311, 0, 2, "Diamond Chestplate");
    }
//diamond leggings
    public function DiamondLeggingsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 312, 0, 2, "Diamond leggings");
    }
//diamond boots
    public function DiamondBootsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 313, 0, 2, "Diamond Boots");
    }
//armor all done
    public function WoodSwordPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 268, 0, 0.5, "Wooden Sword");
    }
//stone		       
    public function StoneSwordPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 272, 0, 1, "Stone Sword");
    }
//iron
    public function IronSwordPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 267, 0, 1.5, "Iron Sword");
    }
//diamond
    public function DiamondSwordPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 276, 0, 2, "Diamond Sword");
    }
//sword ui done
//pickaxe ui
//wood pickaxe
    public function WoodPickaxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 270, 0, 0.5, "Wooden Pickaxe");
    }
//stone pickaxe
    public function StonePickaxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 274, 0, 1, "Stone Pickaxe");
    }
//iron pickaxe
    public function IronPickaxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 257, 0, 1.5, "Iron Pickaxe");
    }
//diamond pickaxe
    public function DiamondPickaxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 278, 0, 2, "Diamond Pickaxe");
    }
//pickaxe UI complete
//axe ui
//wooden axe
    public function WoodAxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 271, 0, 0.5, "Wooden Axe");
    }
//stone axe
    public function StoneAxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 275, 0, 1, "Stone Axe");
    }
//iron axe
    public function IronAxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 258, 0, 1.5, "Iron Axe");
    }
//diamond axe
    public function DiamondAxePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 279, 0, 2, "Diamond Axe");
    }
//axe UI finished
//tools ui all done
//Misc UI
//harrypottercore\potions\Potions depend on this
	
    public function MiscPage(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
	$this->PufferfishPage($sender);
                break;
			    
            	case 1: 
	$this->RosesPage($sender);
                break;

            	case 2: 
	$this->InkSacPage($sender);
                break;
                
            	case 3: 
	$this->GhastTearPage($sender);
                break;
			    
            	case 4: 
	$this->SpiderEyePage($sender);
                break;
			    
            	case 5: 
	$this->BreadPage($sender);
                break;
			    
            	case 6: 
	$this->NetherWartsPage($sender);
                break;
			    
            	case 7: 
	$this->MushroomRedPage($sender);
                break;
			    
            	case 7: 
	$this->MushroomBrownPage($sender);
                break;
			    
            	case 8: 
	$this->GoldenApplePage($sender);
                break;
			    
            	case 9: 
	$this->MelonPage($sender);
                break;
            }
	});
        $form->setTitle("§a§l-=Miscellaneous=-");
	$form->setContent("§bCurrent §aTokens§8:§a ". TokenAPI::getInstance()->myToken($sender));
        $form->addButton("§7[§8PufferFish§7]");
        $form->addButton("§7[§8Roses§7]");
        $form->addButton("§7[§8Ink-Sacs§7]");
        $form->addButton("§7[§8Ghast-Tear§7]");
        $form->addButton("§7[§8Spider-Eye§7]");
        $form->addButton("§7[§8Bread§7]");
        $form->addButton("§7[§8NetherWarts§7]");
        $form->addButton("§7[§8Red-Mushroom§7]");
        $form->addButton("§7[§8Brown-Mushroom§7]");
        $form->addButton("§7[§8Golden Apple§7]");
        $form->addButton("§7[§8Melon§7]");
        $form->addButton("§cExit");
        $form->sendToPlayer($sender);
    }
	
    public function PufferfishPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 462, 0, 1, "PufferFish");
    }
	
    public function RosesPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 174, 4, 0.5, "Rose");
    }

    public function InkSacPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 351, 0, 0.5, "Inc-Sac");
    }
	
    public function GhastTearPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 370, 0, 1, "Ghast Tear");
    }
	
    public function SpiderEyePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 375, 0, 2, "SpiderEye");
    }
	
    public function BreadPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 297, 0, 1, "Bread");
    }
	
    public function NetherWartsPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 372, 0, 0.5, "Nether Wart");
    }
	
    public function MushroomRedPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 40, 0, 0.3, "Red Mushroom");
    }
	
    public function MushroomBrownPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 39, 0, 0.3, "Brown Mushroom");
    }
	
    public function GoldenApplePage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 322, 0, 2, "Golden Apple");
    }

    public function MelonPage(CommandSender $sender)
    {
	  $this->getStore()->getShop($sender, 360, 0, 0.2, "Melon");
    }
} 
