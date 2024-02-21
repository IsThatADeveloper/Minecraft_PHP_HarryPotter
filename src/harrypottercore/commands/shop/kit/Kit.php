<?php

namespace harrypottercore\commands\shop\kit;

use harrypottercore\Main;
use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\command\Command;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;
use onebone\tokenapi\TokenAPI;
use onebone\mpapi\MpAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\inventory\Inventory;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\math\Vector3;

//sound
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\protocol\Sound;
use pocketmine\network\mcpe\protocol\LaunchSound;
use pocketmine\network\mcpe\protocol\GhastShootSound;
use pocketmine\network\mcpe\protocol\GhastSound;
use pocketmine\network\mcpe\protocol\GenericSound;
use pocketmine\network\mcpe\protocol\FizzSound;
use pocketmine\network\mcpe\protocol\EndermanTeleportSound;
use pocketmine\network\mcpe\protocol\DoorSound;
use pocketmine\network\mcpe\protocol\DoorCrashSound;
use pocketmine\network\mcpe\protocol\BumpSound;
use pocketmine\network\mcpe\protocol\ClickSound;
use pocketmine\network\mcpe\protocol\BlazeShootSound;
use pocketmine\network\mcpe\protocol\AnvilFallSound;

//particles
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\WaterParticle;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\TarrainParticle;
use pocketmine\level\particle\SporeParticle;
use pocketmine\level\particle\SplashParticle;
use pocketmine\level\particle\SnowballPoofParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\level\particle\RainSplashParticle;
use pocketmine\level\particle\PortalParticle;
use pocketmine\level\particle\Particle;
use pocketmine\level\particle\MobSpawnParticle;
use pocketmine\level\particle\LavaDripParticle;
use pocketmine\level\particle\ItemBreakParticle;
use pocketmine\level\particle\InstantEnchantParticle;
use pocketmine\level\particle\InkParticle;
use pocketmine\level\particle\HugeExplodeSeedParticle;
use pocketmine\level\particle\HugeExplodeParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\GenericParticle;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\particle\ExplodeParticle;
use pocketmine\level\particle\EntityFlameParticle;
use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\level\particle\EnchantParticle;
use pocketmine\level\particle\DestroyBlockParticle;
use pocketmine\level\particle\CriticalParticle;
use pocketmine\level\particle\BubbleParticle;
use pocketmine\level\particle\BlockForceFieldParticle;
use pocketmine\level\particle\AngryVillagerParticle;

use harrypottercore\messages\Translation;

//$sender->getLevel()->addParticle(new ExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));

class Kit extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setAliases(["kits"]);
    }
	

    public function execute(CommandSender $sender, string $commandLabel, array $args) {      
       $guest = "Guest";
       $slytherin = "Slytherin";
       $gryffindor = "Gryffindor";
       $hufflepuff = "Hufflepuff";
       $ravenclaw = "Ravenclaw";
    if($this->getPlugin()->getGroup($sender) === $guest){
       $this->getPlugin()->message($sender, Translation::getMessage("noHome"));
    }
    if($this->getPlugin()->getGroup($sender) === $slytherin){
            $this->sKitform($sender);
    }
    if($this->getPlugin()->getGroup($sender) === $gryffindor){
       	    $this->gKitform($sender);
    }
    if($this->getPlugin()->getGroup($sender) === $hufflepuff){
      	    $this->hKitform($sender);
    }
    if($this->getPlugin()->getGroup($sender) === $ravenclaw){
       	    $this->rKitform($sender);
    	}	
    }
    
    public function sKitform(Player $sender) {
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			 switch($result){
                case 0:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("slytherin.use") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->skit[$sender->getName()])){
	       $this->getPlugin()->skit[$sender->getName()] = time() + 600; //[600 second] [0 hours] [10 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§r§2Slytherin§7]"]));
	       $sender->getLevel()->addParticle(new BubbleParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(298, 0, 1);
	       $helmet->setCustomName("§2Slytherin Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 1));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(299, 0, 1);
	       $chest->setCustomName("§2Slytherin ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 1));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(300, 0, 1);
	       $legs->setCustomName("§2Slytherin Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 1));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(301, 0, 1);
	       $boots->setCustomName("§2Slytherin Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 1));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(272, 0, 1);
	       $sword->setCustomName("§2Slytherin Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 1));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(274, 0, 1);
	       $pickaxe->setCustomName("§2Slytherin Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(275, 0, 1);
	       $axe->setCustomName("§2Slytherin Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->skit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->skit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->skit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->skit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 1:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("harrypotter.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	       $this->getPlugin()->hpkit[$sender->getName()] = time() + 1800; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§fHarryPotter§r§7]"]));
	       $sender->getLevel()->addParticle(new SnowballPoofParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§f§lHarryPotter Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(307, 0, 1);
	       $chest->setCustomName("§f§lHarryPotter ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(308, 0, 1);
	       $legs->setCustomName("§f§lHarryPotter Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§f§lHarryPotter Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§f§lHarryPotter Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(257, 0, 1);
	       $pickaxe->setCustomName("§f§lHarryPotter Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(258, 0, 1);
	       $axe->setCustomName("§f§lHarryPotter Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->hpkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->hpkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 2:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("deatheater.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	       $this->getPlugin()->dekit[$sender->getName()] = time() + 2400; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§k§c--§r§cDeathEater§r§k§c--§r§7]"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§c§lDeathEater Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§c§lDeathEater ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§c§lDeathEater Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§c§lDeathEater Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§c§lDeathEater Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§c§lDeathEater Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§c§lDeathEater Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->dekit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->dekit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 3:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("voldemort.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	       $this->getPlugin()->voldkit[$sender->getName()] = time() + 3600; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(310, 0, 1);
	       $helmet->setCustomName("§l§4Voldemort Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 2));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§l§4Voldemort ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 2));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§l§4Voldemort Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 2));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(313, 0, 1);
	       $boots->setCustomName("§l§4Voldemort Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 2));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(276, 0, 1);
	       $sword->setCustomName("§l§4Voldemort Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§l§4Voldemort Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§l§4Voldemort Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->voldkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->voldkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;			 
 	    }
	});
	$xp = $sender->getXpLevel();
        $form->setTitle("§l§a-=Kits§l=-");
	$form->setContent("§8You are given §2Slytherin§8 Kit by default. To get better kits you need to level up your wizardry\n\n§bYour level§8:§a $xp");
	if(!isset($this->getPlugin()->skit[$sender->getName()])){
	$form->addButton($sender->hasPermission("slytherin.use") === true ? "§8[§r§2Slytherin§8]§r\n§aUNLOCKED" : "§8[§r§2Slytherin§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->skit[$sender->getName()] >= 0) and ($sender->hasPermission("slytherin.kit"))){
	    $form->addButton("§8[§r§2Slytherin§8]§r\n§c ". (round(($this->getPlugin()->skit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	   $form->addButton($sender->hasPermission("harrypotter.kit") === true ? "§8[§fHarryPotter§r§8]§r\n§aUNLOCKED" : "§8[§fHarryPotter§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->hpkit[$sender->getName()] >= 0) and ($sender->hasPermission("harrypotter.kit"))){
	    $form->addButton("§8[§fHarryPotter§r§8]§r\n§c ". (round(($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	$form->addButton($sender->hasPermission("deatheater.kit") === true ? "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->dekit[$sender->getName()] >= 0) and ($sender->hasPermission("deatheater.kit"))){
	    $form->addButton("§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->dekit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("voldemort.kit") === true ? "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->voldkit[$sender->getName()] >= 0) and ($sender->hasPermission("voldemort.kit"))){
	    $form->addButton("§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
        $form->sendToPlayer($sender);
        return $form;
    }
	
    public function gKitform(Player $sender) {
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			 switch($result){
                case 0:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("gryffindor.use") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->gkit[$sender->getName()])){
	       $this->getPlugin()->gkit[$sender->getName()] = time() + 600; //[600 second] [0 hours] [10 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§r§6Gryffindor§7]"]));
	       $sender->getLevel()->addParticle(new FlameParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(298, 0, 1);
	       $helmet->setCustomName("§6Gryffindor Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 1));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(299, 0, 1);
	       $chest->setCustomName("§6Gryffindor ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 1));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(300, 0, 1);
	       $legs->setCustomName("§6Gryffindor Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 1));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(301, 0, 1);
	       $boots->setCustomName("§6Gryffindor Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 1));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(272, 0, 1);
	       $sword->setCustomName("§6Gryffindor Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 1));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(274, 0, 1);
	       $pickaxe->setCustomName("§6Gryffindor Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(275, 0, 1);
	       $axe->setCustomName("§6Gryffindor Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->gkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->gkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->gkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->gkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 1:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("harrypotter.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	       $this->getPlugin()->hpkit[$sender->getName()] = time() + 1800; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§fHarryPotter§r§7]"]));
	       $sender->getLevel()->addParticle(new SnowballPoofParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§f§lHarryPotter Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(307, 0, 1);
	       $chest->setCustomName("§f§lHarryPotter ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(308, 0, 1);
	       $legs->setCustomName("§f§lHarryPotter Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§f§lHarryPotter Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§f§lHarryPotter Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(257, 0, 1);
	       $pickaxe->setCustomName("§f§lHarryPotter Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(258, 0, 1);
	       $axe->setCustomName("§f§lHarryPotter Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->hpkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->hpkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 2:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("deatheater.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	       $this->getPlugin()->dekit[$sender->getName()] = time() + 2400; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§k§c--§r§cDeathEater§r§k§c--§r§7]"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§c§lDeathEater Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§c§lDeathEater ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§c§lDeathEater Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§c§lDeathEater Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§c§lDeathEater Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§c§lDeathEater Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§c§lDeathEater Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->dekit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->dekit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 3:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("voldemort.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	       $this->getPlugin()->voldkit[$sender->getName()] = time() + 3600; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(310, 0, 1);
	       $helmet->setCustomName("§l§4Voldemort Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 2));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§l§4Voldemort ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 2));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§l§4Voldemort Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 2));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(313, 0, 1);
	       $boots->setCustomName("§l§4Voldemort Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 2));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(276, 0, 1);
	       $sword->setCustomName("§l§4Voldemort Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§l§4Voldemort Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§l§4Voldemort Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->voldkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->voldkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;			 
 	    }
	});
	$xp = $sender->getXpLevel();
        $form->setTitle("§l§a-=Kits§l=-");
	$form->setContent("§8You are given §6Gryffindor§8 Kit by default. To get better kits you need to level up your wizardry\n\n§bYour level§8:§a $xp");
	if(!isset($this->getPlugin()->gkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("gryffindor.use") === true ? "§8[§r§6Gryffindor§8]§r\n§aUNLOCKED" : "§8[§r§6Gryffindor§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->gkit[$sender->getName()] >= 0) and ($sender->hasPermission("gryffindor.kit"))){
	    $form->addButton("§8[§r§6Gryffindor§8]§r\n§c ". (round(($this->getPlugin()->gkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	   $form->addButton($sender->hasPermission("harrypotter.kit") === true ? "§8[§fHarryPotter§r§8]§r\n§aUNLOCKED" : "§8[§fHarryPotter§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->hpkit[$sender->getName()] >= 0) and ($sender->hasPermission("harrypotter.kit"))){
	    $form->addButton("§8[§fHarryPotter§r§8]§r\n§c ". (round(($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	$form->addButton($sender->hasPermission("deatheater.kit") === true ? "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->dekit[$sender->getName()] >= 0) and ($sender->hasPermission("deatheater.kit"))){
	    $form->addButton("§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->dekit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("voldemort.kit") === true ? "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->voldkit[$sender->getName()] >= 0) and ($sender->hasPermission("voldemort.kit"))){
	    $form->addButton("§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
        $form->sendToPlayer($sender);
        return $form;
   }
	
   public function hKitform(Player $sender) {
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			 switch($result){
                case 0:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("hufflepuff.use") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->hkit[$sender->getName()])){
	       $this->getPlugin()->hkit[$sender->getName()] = time() + 600; //[600 second] [0 hours] [10 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§r§eHufflePuff§7]"]));
	       $sender->getLevel()->addParticle(new LavaDripParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(298, 0, 1);
	       $helmet->setCustomName("§eHufflePuff Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 1));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(299, 0, 1);
	       $chest->setCustomName("§eHufflePuff ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 1));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(300, 0, 1);
	       $legs->setCustomName("§eHufflePuff Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 1));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(301, 0, 1);
	       $boots->setCustomName("§eHufflePuff Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 1));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(272, 0, 1);
	       $sword->setCustomName("§eHufflePuff Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 1));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(274, 0, 1);
	       $pickaxe->setCustomName("§eHufflePuff Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(275, 0, 1);
	       $axe->setCustomName("§eHufflePuff Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->hkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->hkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->hkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->hkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 1:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("harrypotter.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	       $this->getPlugin()->hpkit[$sender->getName()] = time() + 1800; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§fHarryPotter§r§7]"]));
	       $sender->getLevel()->addParticle(new SnowballPoofParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§f§lHarryPotter Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(307, 0, 1);
	       $chest->setCustomName("§f§lHarryPotter ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(308, 0, 1);
	       $legs->setCustomName("§f§lHarryPotter Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§f§lHarryPotter Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§f§lHarryPotter Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(257, 0, 1);
	       $pickaxe->setCustomName("§f§lHarryPotter Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(258, 0, 1);
	       $axe->setCustomName("§f§lHarryPotter Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->hpkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->hpkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 2:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("deatheater.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	       $this->getPlugin()->dekit[$sender->getName()] = time() + 2400; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§k§c--§r§cDeathEater§r§k§c--§r§7]"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§c§lDeathEater Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§c§lDeathEater ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§c§lDeathEater Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§c§lDeathEater Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§c§lDeathEater Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§c§lDeathEater Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§c§lDeathEater Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->dekit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->dekit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 3:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("voldemort.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	       $this->getPlugin()->voldkit[$sender->getName()] = time() + 3600; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(310, 0, 1);
	       $helmet->setCustomName("§l§4Voldemort Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 2));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§l§4Voldemort ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 2));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§l§4Voldemort Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 2));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(313, 0, 1);
	       $boots->setCustomName("§l§4Voldemort Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 2));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(276, 0, 1);
	       $sword->setCustomName("§l§4Voldemort Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§l§4Voldemort Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§l§4Voldemort Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->voldkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->voldkit[$sender->getName()]);																				
	       }
	       }
	    }
            break; 
 	    }
	});
	$xp = $sender->getXpLevel();
        $form->setTitle("§l§a-=Kits§l=-");
	$form->setContent("§8You are given §eHufflePuff§8 Kit by default. To get better kits you need to level up your wizardry\n\n§bYour level§8:§a $xp");
	if(!isset($this->getPlugin()->hkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("hufflepuff.use") === true ? "§8[§r§eHufflePuff§8]§r\n§aUNLOCKED" : "§8[§r§eHufflePuff§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->hkit[$sender->getName()] >= 0) and ($sender->hasPermission("hufflepuff.kit"))){
	    $form->addButton("§8[§r§eHufflePuff§8]§r\n§c ". (round(($this->getPlugin()->hkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	   $form->addButton($sender->hasPermission("harrypotter.kit") === true ? "§8[§fHarryPotter§r§8]§r\n§aUNLOCKED" : "§8[§fHarryPotter§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->hpkit[$sender->getName()] >= 0) and ($sender->hasPermission("harrypotter.kit"))){
	    $form->addButton("§8[§fHarryPotter§r§8]§r\n§c ". (round(($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	$form->addButton($sender->hasPermission("deatheater.kit") === true ? "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->dekit[$sender->getName()] >= 0) and ($sender->hasPermission("deatheater.kit"))){
	    $form->addButton("§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->dekit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("voldemort.kit") === true ? "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->voldkit[$sender->getName()] >= 0) and ($sender->hasPermission("voldemort.kit"))){
	    $form->addButton("§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
        $form->sendToPlayer($sender);
        return $form;
   }
	
   public function rKitform(Player $sender) {
		$api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
		$form = $api->createSimpleForm(function (Player $sender, int $data = null){
		$result = $data;
		if($result === null){
			return true;
			}
			 switch($result){
                case 0:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("ravenclaw.use") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->rkit[$sender->getName()])){
	       $this->getPlugin()->rkit[$sender->getName()] = time() + 600; //[600 second] [0 hours] [10 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§r§bRavenClaw§7] "]));
	       $sender->getLevel()->addParticle(new RainSplashParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(298, 0, 1);
	       $helmet->setCustomName("§bRavenClaw Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 1));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(299, 0, 1);
	       $chest->setCustomName("§bRavenClaw ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 1));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(300, 0, 1);
	       $legs->setCustomName("§bRavenClaw Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 1));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(301, 0, 1);
	       $boots->setCustomName("§bRavenClaw Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 1));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(272, 0, 1);
	       $sword->setCustomName("§bRavenClaw Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 1));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(274, 0, 1);
	       $pickaxe->setCustomName("§bRavenClaw Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(275, 0, 1);
	       $axe->setCustomName("§bRavenClaw Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 1));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 1));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->rkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->rkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->rkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->rkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 1:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("harrypotter.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	       $this->getPlugin()->hpkit[$sender->getName()] = time() + 1800; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§fHarryPotter§r§7]"]));
	       $sender->getLevel()->addParticle(new SnowballPoofParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§f§lHarryPotter Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(307, 0, 1);
	       $chest->setCustomName("§f§lHarryPotter ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(308, 0, 1);
	       $legs->setCustomName("§f§lHarryPotter Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§f§lHarryPotter Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§f§lHarryPotter Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(257, 0, 1);
	       $pickaxe->setCustomName("§f§lHarryPotter Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(258, 0, 1);
	       $axe->setCustomName("§f§lHarryPotter Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->hpkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->hpkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 2:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("deatheater.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	       $this->getPlugin()->dekit[$sender->getName()] = time() + 2400; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§7[§k§c--§r§cDeathEater§r§k§c--§r§7]"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(306, 0, 1);
	       $helmet->setCustomName("§c§lDeathEater Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 3));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§c§lDeathEater ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 3));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§c§lDeathEater Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 3));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(309, 0, 1);
	       $boots->setCustomName("§c§lDeathEater Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 3));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(267, 0, 1);
	       $sword->setCustomName("§c§lDeathEater Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 3));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§c§lDeathEater Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§c§lDeathEater Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 3));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 3));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->dekit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->dekit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->dekit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
                case 3:
	$protection = Enchantment::getEnchantment(0);
	$sharpness = Enchantment::getEnchantment(9);
	$efficiency = Enchantment::getEnchantment(15);
	$silktouch = Enchantment::getEnchantment(16);
	$unbreaking = Enchantment::getEnchantment(17);
            if($sender->hasPermission("voldemort.kit") === false){
               $this->getPlugin()->message($sender, Translation::getMessage("noPermKit"));
            }else{
	       if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	       $this->getPlugin()->voldkit[$sender->getName()] = time() + 3600; //[600 second] [0 hours] [30 minute] cool down to caim the kit
	       $this->getPlugin()->message($sender, Translation::getMessage("claimKit", ["kit" => "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r"]));
	       $sender->getLevel()->addParticle(new HugeExplodeParticle(new Vector3($sender->getX(), $sender->getY(), $sender->getZ())));
                //helmet
	       $helmet = Item::get(310, 0, 1);
	       $helmet->setCustomName("§l§4Voldemort Helmet");
	       $helmet->addEnchantment(new EnchantmentInstance($protection, 2));
	       $helmet->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($helmet);
                //chestplate
	       $chest = Item::get(311, 0, 1);
	       $chest->setCustomName("§l§4Voldemort ChestPlate");
	       $chest->addEnchantment(new EnchantmentInstance($protection, 2));
	       $chest->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($chest);
                //leggings
	       $legs = Item::get(312, 0, 1);
	       $legs->setCustomName("§l§4Voldemort Leggings");
	       $legs->addEnchantment(new EnchantmentInstance($protection, 2));
	       $legs->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($legs);
                //boots
	       $boots = Item::get(313, 0, 1);
	       $boots->setCustomName("§l§4Voldemort Boots");
	       $boots->addEnchantment(new EnchantmentInstance($protection, 2));
	       $boots->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($boots);
	       $boots = Item::get(301, 0, 1);
		//sword
	       $sword = Item::get(276, 0, 1);
	       $sword->setCustomName("§l§4Voldemort Sword");
	       $sword->addEnchantment(new EnchantmentInstance($sharpness, 2));
	       $sword->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($sword);
		//pickaxe
	       $pickaxe = Item::get(278, 0, 1);
	       $pickaxe->setCustomName("§l§4Voldemort Pickaxe");
	       $pickaxe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $pickaxe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($pickaxe);
		//pickaxe
	       $axe = Item::get(279, 0, 1);
	       $axe->setCustomName("§l§4Voldemort Axe");
	       $axe->addEnchantment(new EnchantmentInstance($efficiency, 2));
	       $axe->addEnchantment(new EnchantmentInstance($unbreaking, 2));
               $sender->getInventory()->addItem($axe);
		//steak
	       $steak = Item::get(364, 0, 64);
               $sender->getInventory()->addItem($steak);
	  } else {
	       if(time() < $this->getPlugin()->voldkit[$sender->getName()]){
	       $minutes = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60;
	       $hours = ($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60 * 60;
	       $sender->sendPopup(Translation::getMessage("cooldown", ["seconds" => round($minutes)]));
	   } else {
	       unset($this->getPlugin()->voldkit[$sender->getName()]);																				
	       }
	       }
	    }
            break;
 	    }
	});
	$xp = $sender->getXpLevel();
        $form->setTitle("§l§a-=Kits§l=-");
	$form->setContent("§8You are given §bRavenClaw§8 Kit by default. To get better kits you need to level up your wizardry\n\n§bYour level§8:§a $xp");
	if(!isset($this->getPlugin()->rkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("ravenclaw.use") === true ? "§8[§r§bRaveClaw§8]§r\n§aUNLOCKED" : "§8[§r§bRaveClaw§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->rkit[$sender->getName()] >= 0) and ($sender->hasPermission("ravenclaw.kit"))){
	    $form->addButton("§8[§r§bRaveClaw§8]§r\n§c ". (($this->getPlugin()->rkit[$sender->getName()] - time()) / 60). "Minutes");
	}
	if(!isset($this->getPlugin()->hpkit[$sender->getName()])){
	   $form->addButton($sender->hasPermission("harrypotter.kit") === true ? "§8[§fHarryPotter§r§8]§r\n§aUNLOCKED" : "§8[§fHarryPotter§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->hpkit[$sender->getName()] >= 0) and ($sender->hasPermission("harrypotter.kit"))){
	    $form->addButton("§8[§fHarryPotter§r§8]§r\n§c ". (round(($this->getPlugin()->hpkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->dekit[$sender->getName()])){
	$form->addButton($sender->hasPermission("deatheater.kit") === true ? "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->dekit[$sender->getName()] >= 0) and ($sender->hasPermission("deatheater.kit"))){
	    $form->addButton("§8[§k§c--§r§cDeathEater§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->dekit[$sender->getName()] - time()) / 60)). "Minutes");
	}
	if(!isset($this->getPlugin()->voldkit[$sender->getName()])){
	$form->addButton($sender->hasPermission("voldemort.kit") === true ? "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§aUNLOCKED" : "§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§cLOCKED");
	}elseif(($this->getPlugin()->voldkit[$sender->getName()] >= 0) and ($sender->hasPermission("voldemort.kit"))){
	    $form->addButton("§8[§k§c--§r§4Voldemort§r§k§c--§r§8]§r\n§c ". (round(($this->getPlugin()->voldkit[$sender->getName()] - time()) / 60)). "Minutes");
	}
        $form->sendToPlayer($sender);
        return $form;
	}
}
