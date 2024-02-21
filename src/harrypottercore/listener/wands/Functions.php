<?php

namespace harrypottercore\listener\wands;

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
use pocketmine\item\SnowBall;
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

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;

use harrypottercore\entity\Magic;
use pocketmine\entity\Entity;

class Functions implements Listener{

    private $plugin;
	
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }

    //wands
    public function onWandInteract(PlayerInteractEvent $event): void {
           $player = $event->getPlayer();
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		if ($item->getCustomName() === "§aBasic Wand"){ //Use the staff
		     if(!isset($this->basicwand[$player->getName()])){
			$this->basicwand[$player->getName()] = time() + 2;
			$nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x-0.17),
					new DoubleTag("", $player->y+1.7),
					new DoubleTag("", $player->z) 
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
			] );
			$height = 1.5;
			$snowball = Entity::createEntity("Magic", $player->getlevel(), $nbt, $player);
			$snowball->setMotion($snowball->getMotion()->multiply($height));
			$snowball->spawnToAll();
                        $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'blast1.fsb';
			$player->dataPacket($pk);
		    } else {
			    if(time() < $this->basicwand[$player->getName()]){
			       $remaining = $this->basicwand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->basicwand[$player->getName()]);																				
			    }
			  }
		}elseif ($item->getCustomName() === "§aCrimson Wand"){ //Use the staff
		     if(!isset($this->crimsonwand[$player->getName()])){
			$this->crimsonwand[$player->getName()] = time() + 4;
			$nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x-0.17),
					new DoubleTag("", $player->y+1.7),
					new DoubleTag("", $player->z)  
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
		] );

			$height = 1.5;
			$snowball = Entity::createEntity("Magic", $player->getlevel(), $nbt, $player);
			$snowball->setMotion($snowball->getMotion()->multiply($height));
			$snowball->spawnToAll();
                        $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'fire.fsb';
			$player->dataPacket($pk);
		    } else {
			    if(time() < $this->crimsonwand[$player->getName()]){
			       $remaining = $this->crimsonwand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->crimsonwand[$player->getName()]);																				
			    }
			  }
		}elseif ($item->getCustomName() === "§aDeathEater Wand"){ //Use the staff
		     if(!isset($this->deatheaterwand[$player->getName()])){
			$this->deatheaterwand[$player->getName()] = time() + 8;
			$nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x-0.17),
					new DoubleTag("", $player->y+1.7),
					new DoubleTag("", $player->z) 
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
		] );

			$height = 1.5;
			$snowball = Entity::createEntity("Magic", $player->getlevel(), $nbt, $player);
			$snowball->setMotion($snowball->getMotion()->multiply($height));
			$snowball->spawnToAll();
                        $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'largeBlast.fsb';
			$player->dataPacket($pk);
		    } else {
			    if(time() < $this->deatheaterwand[$player->getName()]){
			       $remaining = $this->deatheaterwand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->deatheaterwand[$player->getName()]);																				
			    }
			  }
		}elseif ($item->getCustomName() === "§aElder Wand"){ //Use the staff
		     if(!isset($this->elderwand[$player->getName()])){
			$this->elderwand[$player->getName()] = time() + 10;
			$nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x-0.17),
					new DoubleTag("", $player->y+1.7),
					new DoubleTag("", $player->z) 
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
		] );

			$height = 1.5;
			$snowball = Entity::createEntity("Magic", $player->getlevel(), $nbt, $player);
			$snowball->setMotion($snowball->getMotion()->multiply($height));
			$snowball->spawnToAll();
                        $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'thunder3.fsb';
			$player->dataPacket($pk);
		    } else {
			    if(time() < $this->elderwand[$player->getName()]){
			       $remaining = $this->elderwand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->elderwand[$player->getName()]);																				
			    }
			  }
		}elseif ($item->getCustomName() === "§aRon's Wand"){ //Use the staff
		     if(!isset($this->ronwand[$player->getName()])){
			$this->ronwand[$player->getName()] = time() + 8;
			$nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x-0.17),
					new DoubleTag("", $player->y+1.7),
					new DoubleTag("", $player->z) 
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
		] );

			$height = 1.5;
			$snowball = Entity::createEntity("Magic", $player->getlevel(), $nbt, $player);
			$snowball->setMotion($snowball->getMotion()->multiply($height));
			$snowball->spawnToAll();
                        $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'lavapop.fsb';
			$player->dataPacket($pk);
		    } else {
			    if(time() < $this->ronwand[$player->getName()]){
			       $remaining = $this->ronwand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->ronwand[$player->getName()]);																				
			    }
			  }
		}elseif ($item->getCustomName() === "§aHermione's Wand"){ //Use the staff
		     if(!isset($this->hermionewand[$player->getName()])){
			$this->hermionewand[$player->getName()] = time() + 6;
			$nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x-0.17),
					new DoubleTag("", $player->y+1.7),
					new DoubleTag("", $player->z) 
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
		] );

			$height = 1.5;
			$snowball = Entity::createEntity("Magic", $player->getlevel(), $nbt, $player);
			$snowball->setMotion($snowball->getMotion()->multiply($height));
			$snowball->spawnToAll();
                        $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'twinkle1.fsb';
			$player->dataPacket($pk);
		     } else {
			    if(time() < $this->hermionewand[$player->getName()]){
			       $remaining = $this->hermionewand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->hermionewand[$player->getName()]);																				
			    }
			  }
		}elseif ($item->getCustomName() === "§aHarryPotter's Wand"){ //Use the staff
		     if(!isset($this->harrypotterwand[$player->getName()])){
			$this->harrypotterwand[$player->getName()] = time() + 9;
			$nbt = new CompoundTag( "", [ 
				"Pos" => new ListTag( 
				"Pos", [ 
					new DoubleTag("", $player->x-0.17),
					new DoubleTag("", $player->y+1.7),
					new DoubleTag("", $player->z) 
				]),
				"Motion" => new ListTag("Motion", [ 
						new DoubleTag("", -\sin ($player->yaw / 180 * M_PI) *\cos ($player->pitch / 180 * M_PI)),
						new DoubleTag ("", -\sin ($player->pitch / 180 * M_PI)),
						new DoubleTag("",\cos ($player->yaw / 180 * M_PI) *\cos ( $player->pitch / 180 * M_PI)) 
				] ),
				"Rotation" => new ListTag("Rotation", [ 
						new FloatTag("", $player->yaw),
						new FloatTag("", $player->pitch) 
				] ) 
		] );

			$height = 1.5;
			$snowball = Entity::createEntity("Magic", $player->getlevel(), $nbt, $player);
			$snowball->setMotion($snowball->getMotion()->multiply($height));
			$snowball->spawnToAll();
                        $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'thunder2.fsb';
			$player->dataPacket($pk);
		    } else {
			    if(time() < $this->harrypotterwand[$player->getName()]){
			       $remaining = $this->harrypotterwand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->harrypotterwand[$player->getName()]);																				
			    }
			  }
		} elseif ($item->getCustomName() === "§aPhoenix Wand"){ // Remove the items
			  if(!isset($this->phoenixwand[$player->getName()])){
			     $this->phoenixwand[$player->getName()] = time() + 12;
			     $amount = mt_rand(2, 20);
			     if($player->getHealth() == (20)){
				$player->sendMessage("§7(§c!§7) §cYou are at max health");
			     }else{
			     $health = $player->getHealth();
			     $player->setHealth($health + $amount);
			     $player->sendTip(Translation::getMessage("healWand", ["amount" => $amount]));
			     $player->setFood(20);
			     }
			//particles
 	     	       	   $player->getLevel()->addParticle(new SmokeParticle(new Vector3($player->getX() + 0.2, $player->getY() + 0.2, $player->getZ())));
 	     	       	   $player->getLevel()->addParticle(new SmokeParticle(new Vector3($player->getX() - 0.2, $player->getY() + 0.2, $player->getZ())));
 	     	       	   $player->getLevel()->addParticle(new SmokeParticle(new Vector3($player->getX() + 0.2, $player->getY() + 0.2, $player->getZ() + 0.2)));
 	     	       	   $player->getLevel()->addParticle(new SmokeParticle(new Vector3($player->getX() + 0.2, $player->getY() + 0.2, $player->getZ() - 0.2)));
	 	     	   $player->getLevel()->addParticle(new HeartParticle(new Vector3($player->getX(), $player->getY() + 0.2, $player->getZ())));
                           $level = $player->getLevel();
			$pk = new PlaySoundPacket();
			$pk->x = $player->getX();
			$pk->y = $player->getY();
			$pk->z = $player->getZ();
			$pk->volume = 1;
			$pk->pitch = 1;
			$pk->soundName = 'use_totem.fsb';
			$player->dataPacket($pk);
			} else {
			    if(time() < $this->phoenixwand[$player->getName()]){
			       $remaining = $this->phoenixwand[$player->getName()] - time();
			       $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $remaining]));
			    } else {
			 	unset($this->phoenixwand[$player->getName()]);																				
			    }
			  }
		} elseif ($item->getCustomName() === "§cBack"){ // Remove the items
		  $player = $event->getPlayer();
          	  $inventory = $player->getInventory();
          	  $player->getInventory()->clearAll();
          }
    }
}
