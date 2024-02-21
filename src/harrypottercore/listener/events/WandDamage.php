<?php

namespace harrypottercore\listener\events;

use harrypottercore\Main;
use harrypottercore\messages\Translation;
//event
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityInventoryChangeEvent;
use pocketmine\event\player\PlayerExperienceChangeEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerDataSaveEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\block\SignChangeEvent;

//tasks
use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

//blocks
use pocketmine\block\BlockFactory;
use pocketmine\block\Air;
use pocketmine\block\Brick_Block;
use pocketmine\item\Hoe;
use pocketmine\item\Stick;
use pocketmine\item\Iron_Ingot;
use pocketmine\item\Dye;
use pocketmine\block\Grass;
use pocketmine\block\BrewingStand;
use pocketmine\block\Brewing_Stand;
use pocketmine\block\Dirt;
use pocketmine\block\Block;

//item
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\item\ItemFactory;

//sound
use pocketmine\level\sound\PopSound;
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
use pocketmine\level\particle\SmokeParticle;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\NoteParticle;
use pocketmine\level\particle\GreenParticle;
use pocketmine\level\particle\RedStoneParticle;
use pocketmine\level\particle\SlimeParticle;
use pocketmine\level\particle\WaterParticle;
use pocketmine\level\particle\WaterDripParticle;
use pocketmine\level\particle\TarrainParticle;
use pocketmine\level\particle\SporeParticle;
use pocketmine\level\particle\SplashParticle;
use pocketmine\level\particle\SnowballPoofParticle;
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

//pocketmine
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\utils\Utils;
use pocketmine\plugin\Plugin;

//economy
use onebone\economyapi\EconomyAPI; //money not really going to be used
use onebone\tokenapi\TokenAPI; //used in replacement of coins
use onebone\mpapi\MpAPI; //magical power for wands

//form ui
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

//form gui
use muqsit\invmenu\inventories\BaseFakeInventory;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\inventories\DoubleChestInventory;
use muqsit\invmenu\inventories\LargeChestInventory;
use muqsit\invmenu\tasks\DelayedFakeBlockDataNotifyTask;
use pocketmine\network\mcpe\protocol\types\WindowTypes;
use pocketmine\inventory\ChestInventory;
use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\inventory\transaction\action\InventoryAction;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\network\mcpe\protocol\InventoryContentPacket;
use pocketmine\network\mcpe\protocol\InventorySlotPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\NBT;

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;

//pocketmine entities
use pocketmine\entity\Entity;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Zombie;
use pocketmine\entity\Villager;
use revivalpmmp\pureentities\entity\BaseEntity;

use pocketmine\entity\Snowball;

//config
use pocketmine\utils\config;

use harrypottercore\commands\settings\Setting;

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;

class WandDamage implements Listener{
	
    public $prefix = "§7(§a!§7) §aYou hit";
	
    public $suffix = " damage using ";

    private $plugin;

    private $defense;
	
    private $itemCooldown = [];
	
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    } 
	
    public function Particle(Entity $player) { 
	   if($player instanceof Entity) {
	      $player->getLevel()->addParticle(new SmokeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	      $player->getLevel()->addParticle(new CriticalParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	      }
    }
	
    public function entityChangeNameTag(PlayerInteractEvent $event) {
	    $player = $event->getPlayer();
	    $this->plugin->item = $event->getItem()->getCustomName();
	    if(!isset($this->itemCooldown[$player->getName()])){
	    //cancel = false
	    }else{
	       if(time() < $this->itemCooldown[$player->getName()]){
		  $event->setCancelled(true);
	      	  $seconds = ($this->itemCooldown[$player->getName()] - time());
    	      	  $player->sendTip(Translation::getMessage("cannotInteract"));
	       }else{
	       	  unset($this->itemCooldown[$player->getName()]);	
	       }
	    }
    }
	
    public function onHitHuman(EntityDamageByEntityEvent $event){
	 if ($event->getCause() === EntityDamageByEntityEvent::CAUSE_PROJECTILE){
		 
    	     $this->plugin->elder = mt_rand(8,10);
	     $this->plugin->basic = mt_rand(1,2);
    	     $this->plugin->crimson = mt_rand(2,4);
    	     $this->plugin->deatheater = mt_rand(3,5);
    	     $this->plugin->ron = mt_rand(7,9);
    	     $this->plugin->hermione = mt_rand(6,7);
    	     $this->plugin->harrypotter = mt_rand(4,6);
	     $this->plugin->kb = 0.30;
	     $this->plugin->defensemultiplier = 10;
		 
	     //users
	     $player = $event->getDamager();
	     $entity = $event->getEntity();
	     $projectile = $event->getEntity();
	     $human = $event->getEntity();
	     if($player instanceof Player and $entity instanceof Entity and $human instanceof Human){
	     $level = $player->getLevel();
	     $inv = $player->getInventory();
	     $hand = $inv->getItemInHand();
	     $itemname = $this->plugin->item;
	     $config = new Config($this->plugin->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
	     $defense = $this->plugin->getDefense($player, (int) $config->get("defense"));
	     //effects
	     $blind = Effect::getEffect(Effect::BLINDNESS);
	     $hunger = Effect::getEffect(Effect::HUNGER);
	     $slow = Effect::getEffect(Effect::SLOWNESS);
	     $poison = Effect::getEffect(Effect::POISON);
	     $wither = Effect::getEffect(Effect::WITHER);
	     $weak = Effect::getEffect(Effect::WEAKNESS);
	     //health and about
	     $health = $entity->getHealth();
	     $entityname = $entity->getNameTag();
	     //multipliers
	     if($itemname == "§aBasic Wand" or $itemname == "§aRon's Wand" or $itemname == "§aHermione's Wand" or $itemname == "§aHarryPotter's Wand" or $itemname == "§aCrimson Wand" or $itemname == "§aDeathEater Wand") {
	        if(!isset($this->itemCooldown[$player->getName()])){
	        $this->itemCooldown[$player->getName()] = time() + 4.5; //[4.5 seconds]
	        $kb = $event->getKnockback();
	        $multiplier = $this->plugin->getKb();
 	        $event->setKnockBack($kb * $multiplier);
	        //sound
	        $pk = new PlaySoundPacket();
	        $pk->x = $entity->getX();
	        $pk->y = $entity->getY();
	        $pk->z = $entity->getZ();
	        $pk->volume = 1;
	        $pk->pitch = 1;
	        $pk->soundName = 'random.toast';
		//particles
		$this->Particle($entity);
		//sound
	        if($human->hasPermission($this->getPlugin()->getSound($player) == true)) {
		   $human->dataPacket($pk);
	     	   }
		}
	     }
				  
	     if($itemname == "§aBasic Wand") {
		     	if($defense >= $this->plugin->getBasic()) {
		           $entity->setHealth($health - 1);
		      	   $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			}else{
		           $entity->setHealth($health - ($this->plugin->getBasic() - $defense));
		      	   $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getBasic() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			}
		 	//effects
              		$time1 = 10 + ($defense * $this->plugin->defensemultiplier);
             		$amp1 = 2;
              		$entity->addEffect(new EffectInstance($hunger,$time1,$amp1,false));
		     }elseif($itemname == "§aElder Wand") {
		     	  if($defense >= $this->plugin->getElder()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getElder() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getElder() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			     //effects
              		     $time1 = 140 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $time2 = 80 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $entity->addEffect(new EffectInstance($poison,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($wither,$time2,$amp2,false));
		     }elseif($itemname == "§aRon's Wand") {
		     	  if($defense >= $this->plugin->getRon()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getRon() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getRon() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			     //effects
              		     $time1 = 100 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 10;
              		     $time2 = 140 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $time3 = 80 + ($defense * $this->plugin->defensemultiplier);
             		     $amp3 = 1;
              		     $entity->addEffect(new EffectInstance($slow,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($hunger,$time2,$amp2,false));
              		     $entity->addEffect(new EffectInstance($blind,$time3,$amp3,false));
		     }elseif($itemname == "§aHermione's Wand") {
		     	  if($defense >= $this->plugin->getHermione()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->getHermione() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getHermione() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			     //effects
              		     $time1 = 100 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $entity->addEffect(new EffectInstance($wither,$time1,$amp1,false));
		     }elseif($itemname == "§aHarryPotter's Wand") {
		     	  if($defense >= $this->plugin->getHarryPotter()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getHarryPotter() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getHarryPotter() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 160 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $time2 = 200 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $entity->addEffect(new EffectInstance($poison,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($hunger,$time2,$amp2,false));
		     }elseif($itemname == "§aCrimson Wand") {
		     	  if($defense >= $this->plugin->getCrimson()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getCrimson() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getCrimson() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 160 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $entity->addEffect(new EffectInstance($weak,$time1,$amp1,false));
		     }elseif($itemname == "§aDeathEater Wand") {
		     	  if($defense >= $this->plugin->getDeathEater()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getDeathEater() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getDeathEater() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 100 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $time2 = 140 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $entity->addEffect(new EffectInstance($blind,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($hunger,$time2,$amp2,false));
	     	 }
	     }
	 }
    }
	
    public function onHitMob(EntityDamageByEntityEvent $event){
	 if ($event->getCause() === EntityDamageByEntityEvent::CAUSE_PROJECTILE){
	     //users
	     $player = $event->getDamager();
	     $entity = $event->getEntity();
	     if($player instanceof Player and $entity instanceof Entity){
		//about
	        $config = new Config($this->plugin->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
	        $defense = $this->plugin->getDefense($player, (int) $config->get("defense"));
	     	$health = $entity->getHealth();
		$entityname = $entity->getNameTag();
	        $level = $player->getLevel();
	     	$inv = $player->getInventory();
	     	$hand = $inv->getItemInHand();
	     	$itemname = $this->plugin->item;
	        //effects
	        $blind = Effect::getEffect(Effect::BLINDNESS);
	        $hunger = Effect::getEffect(Effect::HUNGER);
	        $slow = Effect::getEffect(Effect::SLOWNESS);
	        $poison = Effect::getEffect(Effect::POISON);
	        $wither = Effect::getEffect(Effect::WITHER);
	        $weak = Effect::getEffect(Effect::WEAKNESS); 
	          if($itemname == "§aBasic Wand" or $itemname == "§aRon's Wand" or $itemname == "§aHermione's Wand" or $itemname == "§aHarryPotter's Wand" or $itemname == "§aCrimson Wand" or $itemname == "§aDeathEater Wand") {
	             if(!isset($this->itemCooldown[$player->getName()])){
	             $this->itemCooldown[$player->getName()] = time() + 4.5; //[4.5 seconds]
		     //multipliers
		     $kb = $event->getKnockback();
		     $multiplier = $this->plugin->getKb();
		     $event->setKnockBack($kb * $multiplier);
		     //particles
		     $this->Particle($entity);
		     }
		     }
		     
		     if($itemname == "§aBasic Wand") {
		     	  if($defense >= $this->plugin->getBasic()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getBasic() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getBasic() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 10 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 2;
              		     $entity->addEffect(new EffectInstance($hunger,$time1,$amp1,false));
		     }elseif($itemname == "§aElder Wand") {
		     	  if($defense >= $this->plugin->getElder()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getElder() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getElder() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 140 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $time2 = 80 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $entity->addEffect(new EffectInstance($poison,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($wither,$time2,$amp2,false));
		     }elseif($itemname == "§aRon's Wand") {
		     	  if($defense >= $this->plugin->getRon()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getRon() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getRon() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 100 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 10;
              		     $time2 = 140 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $time3 = 80 + ($defense * $this->plugin->defensemultiplier);
             		     $amp3 = 1;
              		     $entity->addEffect(new EffectInstance($slow,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($hunger,$time2,$amp2,false));
              		     $entity->addEffect(new EffectInstance($blind,$time3,$amp3,false));
		     }elseif($itemname == "§aHermione's Wand") {
		     	  if($defense >= $this->plugin->getHermione()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getHermione() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getHermione() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 100 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $entity->addEffect(new EffectInstance($wither,$time1,$amp1,false));
		     }elseif($itemname == "§aHarryPotter's Wand") {
		     	  if($defense >= $this->plugin->getHarryPotter()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getHarryPotter() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getHarryPotter() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 160 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $time2 = 200 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $entity->addEffect(new EffectInstance($poison,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($hunger,$time2,$amp2,false));
		     }elseif($itemname == "§aCrimson Wand") {
		     	  if($defense >= $this->plugin->getCrimson()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getCrimson() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getCrimson() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }  
			//effects
              		     $time1 = 160 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $entity->addEffect(new EffectInstance($weak,$time1,$amp1,false));
		     }elseif($itemname == "§aDeathEater Wand") {
		     	  if($defense >= $this->plugin->getDeathEater()) {
		             $entity->setHealth($health - 1);
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "suffix" => $this->suffix, "item" => $itemname]));
			   }else{
		             $entity->setHealth($health - ($this->plugin->getDeathEater() - $defense));
		      	     $player->sendTip(Translation::getMessage("noDefense", ["prefix" => $this->prefix, "entityname" => $entityname, "damage" => ($this->plugin->getElder() - $defense), "suffix" => $this->suffix, "item" => $itemname]));
			     }
			//effects
              		     $time1 = 100 + ($defense * $this->plugin->defensemultiplier);
             		     $amp1 = 1;
              		     $time2 = 140 + ($defense * $this->plugin->defensemultiplier);
             		     $amp2 = 2;
              		     $entity->addEffect(new EffectInstance($blind,$time1,$amp1,false));
              		     $entity->addEffect(new EffectInstance($hunger,$time2,$amp2,false));
		     }
	     }
	 }
    }
}
