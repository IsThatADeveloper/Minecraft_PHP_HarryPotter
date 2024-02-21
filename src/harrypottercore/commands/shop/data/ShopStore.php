<?php

namespace harrypottercore\commands\shop\data;

use harrypottercore\Main;
use harrypottercore\messages\Translation;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use onebone\tokenapi\TokenAPI;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;

use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\ExplodeParticle;

use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI;

use pocketmine\utils\config;

class ShopStore {
	
    	private $plugin;
	
	private $price;
	private $id;
	private $meta;
	private $name;

    	public function __construct(Main $plugin) {
    	    $this->plugin = $plugin;
    	}
	
    	public function getPlugin() {
	    return $this->plugin;
    	}
	
	public function getShop(Player $player, int $id, int $meta, int $price, $name = null) {
		$this->price = $price;
		$this->id = $id;
		$this->meta = $meta;
		$this->name = $name;
   		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
    		$f = $api->createCustomForm(function(Player $player, ?array $data){
    		if(!isset($data)) return;
	  	   if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("TokenAPI")->myToken($player) >= ($this->price * $data[1])){
	  	       $this->plugin->message($player, "§7(§a!§7) §aYou purchased " . $data[1] . $this->name);
	  	       $item = Item::get($this->id, $this->meta, $data[1]);
		       $player->getInventory()->addItem($item);
    		       TokenAPI::getInstance()->reduceToken($player, ($this->price * $data[1]));
		   }else{
	  	       $this->plugin->message($player, "§7(§c!§7) §cYou do not have enough tokens to buy " . $data[1] . " " . $this->name);
		   }
	  });
	  $f->setTitle("§l§a-=" . $name . "=-");
	  $f->addLabel("§bCurrent Token§8:§a ". TokenAPI::getInstance()->myToken($player) . "\n\n§aPrice§7: §a" . $price . "T");
   	  $f->addInput("Amount: ");
	  $f->sendToPlayer($player);
	  }
	
	public function getCustomShop(Player $player, int $id, int $meta, int $price, $name = "Wand") {
	   if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("TokenAPI")->myToken($player) >= ($price)){
	      $wand = Item::get($id, $meta, 1)->setCustomName($name);
	      $player->getInventory()->addItem($wand);
	      $this->getPlugin()->message($player, Translation::getMessage("purchaseWand", ["wand" => ucwords($name), "amount" => $price]));
           }else{
	      $this->getPlugin()->message($player, Translation::getMessage("cantPurchaseWand", ["wand" => ucwords($name)]));
	   }
	}
}

