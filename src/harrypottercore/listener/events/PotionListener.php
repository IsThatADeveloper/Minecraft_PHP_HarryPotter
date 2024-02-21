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

class PotionListener implements Listener{

    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function onInteract(PlayerInteractEvent $event): void {
      		$player = $event->getPlayer();
		$name = $player->getName();
		$item = $player->getInventory()->getItemInHand();
	   	if($item->getCustomName() === "$name's §dWizarding Book") {
	           if(!isset($this->plugin->book[$player->getName()])){
	              $this->plugin->book[$player->getName()] = time() + 5; //[5 seconds]
       		      $this->bookpage1form($player);
	  	  } else {
	       	      if(time() < $this->plugin->book[$player->getName()]){
	      		 $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->plugin->book[$player->getName()] - time()]));
	   	     } else {
	       		 unset($this->plugin->book[$player->getName()]);	
		      }
		   }
		}
    } 
    
    public function onPotionTouch(PlayerInteractEvent $event) {
       $sender = $event->getPlayer();
       $block = $event->getBlock();
       $blockID = $block->getId();
       $x = $block->getX();
       $y = $block->getY();
       $z = $block->getZ();
       $level = $block->getLevel();
       if($block->getId() === Block::BREWING_STAND_BLOCK || $block->getId() === Block::BREWING_STAND_BLOCK) {
          if($event->getPlayer()->isSneaking() === false) {
             $bottle = $event->getItem();
             $this->potionform($event->getPlayer(), $bottle, $block);
          }
       }
    }
    
    public function potionform(Player $player) { 
        $form = new SimpleForm(function (Player $player, $data){
            if ($data === null) {
                return;
            		}
			switch($data){
              case 0:
	  if($this->plugin->isComplete($player)) {
	     $bottle = Item::get(373,0,1);
	     $inv = $player->getInventory();
	     $potion = "brewable potion";
	     $awkward = Item::get(373,4,1)->setCustomName("Brewable Potion");
	     if($inv->contains(Item::get(373,0,1))) {
	        $inv->removeItem($bottle);
          	$inv->addItem($awkward);
		$this->plugin->message($player, Translation::getMessage("craftPotion", ["potion" => $potion]));
	     }else{
		$this->plugin->message($player, Translation::getMessage("notEnoughMaterials", ["potion" => $potion]));
	     }
	   }else{
	     $this->plugin->message($player, Translation::getMessage("notCompletedTutorial", ["potion" => $potion]));
	  }
          break;
              case 1:
	  if($player->hasPermission("magic1.use")) {
	     $inv = $player->getInventory();
	     $potion = "§dAmortentia §aP§bo§at§bi§ao§bn";
	     $awkward = Item::get(373,4,1)->getCustomName("Brewable Potion");
	     $bone = Item::get(352,0,1);
	     $rdye = Item::get(351,1,1); //red dye
	     $amortentia = Item::get(373,28,1)->setCustomName("§dAmortentia §aP§bo§at§bi§ao§bn")->setLore(["§dAmortentia §aP§bo§at§bi§ao§bn"]); //regen
	     if($inv->contains(Item::get(373,4,3)) /*awkward*/ and $inv->contains(Item::get(352,0,3)) /*bone*/ and $inv->contains(Item::get(351,1,3)) /*rdye*/) {
	        $inv->removeItem($awkward);
	        $inv->removeItem($bone);
	        $inv->removeItem($rdye);
          	$inv->addItem($amortentia);
		$this->plugin->message($player, Translation::getMessage("craftPotion", ["potion" => $potion]));
	     }else{
		$this->plugin->message($player, Translation::getMessage("notEnoughMaterials", ["potion" => $potion]));
	     }
	   }else{
	     $this->plugin->message($player, Translation::getMessage("notCompletedTutorial", ["potion" => $potion]));
	  }
          break;
              case 2:
	  if($player->hasPermission("magic2.use")) {
	     $potion = "§5Elixir §fof §cLife";
	     $inv = $player->getInventory();			
	     $awkward = Item::get(373,4,1)->getCustomName("Brewable Potion");
	     $diamond = Item::get(364,0,1);
	     $gunpowder = Item::get(289,0,1);
	     $pdye = Item::get(351,9,1); //pink dye
	     $elixir = Item::get(373,13,1)->setCustomName("§5Elixir §fof §cLife")->setLore(["§5Elixir §fof §cLife"]); //fire res
	     if($inv->contains(Item::get(373,4,3)) and $inv->contains(Item::get(364,0,1)) and $inv->contains(Item::get(351,9,1)) and $inv->contains(Item::get(289,0,1))) {
	        $inv->removeItem($awkward);
	        $inv->removeItem($diamond);
	        $inv->removeItem($gunpowder);
	        $inv->removeItem($pdye);
          	$inv->addItem($elixir);
		$this->plugin->message($player, Translation::getMessage("craftPotion", ["potion" => $potion]));
	     }else{
		$this->plugin->message($player, Translation::getMessage("notEnoughMaterials", ["potion" => $potion]));
	     }
	   }else{
	     $this->plugin->message($player, Translation::getMessage("notCompletedTutorial", ["potion" => $potion]));
	  }
          break;
              case 3:
	  if($player->hasPermission("magic5.use")) {
	     $potion = "§0Draught of Living Death";
	     $inv = $player->getInventory();			
	     $awkward = Item::get(373,4,1)->getCustomName("Brewable Potion");
	     $diamond = Item::get(364,0,1);
	     $gunpowder = Item::get(289,0,1);
	     $ink = Item::get(351,0,1); //ink dye
	     $bone = Item::get(352,0,1);
	     $elixir = Item::get(373,36,1)->setCustomName("§0Draught of Living Death")->setLore(["§0Draught of Living Death"]); //decay
	     if($inv->contains(Item::get(373,27,1)) and $inv->contains(Item::get(364,0,1)) and $inv->contains(Item::get(351,0,1)) and $inv->contains(Item::get(289,0,1)) and $inv->contains(Item::get(352,0,1))) {
	        $inv->removeItem($awkward);
	        $inv->removeItem($diamond);
	        $inv->removeItem($gunpowder);
	        $inv->removeItem($bone);
	        $inv->removeItem($ink);
          	$inv->addItem($elixir);
		$this->plugin->message($player, Translation::getMessage("craftPotion", ["potion" => $potion]));
	     }else{
		$this->plugin->message($player, Translation::getMessage("notEnoughMaterials", ["potion" => $potion]));
	     }
	   }else{
	     $this->plugin->message($player, Translation::getMessage("notCompletedTutorial", ["potion" => $potion]));
	  }
          break;
              case 4:
	  if($player->hasPermission("magic6.use")) {
	     $potion = "§8Skele-Gro §aP§bo§at§bi§ao§bn";
	     $inv = $player->getInventory();				
	     $awkward = Item::get(373,4,1)->getCustomName("Brewable Potion");
	     $diamond = Item::get(364,0,3);
	     $gnugget = Item::get(371,0,1);
	     $leather = Item::get(334,0,1); //leather
	     $bone = Item::get(352,0,2);
	     $skele = Item::get(373,27,1)->setCustomName("§8Skele-Gro §aP§bo§at§bi§ao§bn")->setLore(["§8Skele-Gro §aP§bo§at§bi§ao§bn"]); //poison
	     if($inv->contains(Item::get(373,4,3)) /*awkward*/ and $inv->contains(Item::get(364,0,3)) /*diamond*/ and $inv->contains(Item::get(371,0,1)) /*nugget*/ and $inv->contains(Item::get(334,0,1)) /*leather*/ and $inv->contains(Item::get(352,0,2)) /*bone*/) {
	        $inv->removeItem($awkward);
	        $inv->removeItem($diamond);
	        $inv->removeItem($gnugget);
	        $inv->removeItem($bone);
	        $inv->removeItem($leather);
          	$inv->addItem($skele);
		$this->plugin->message($player, Translation::getMessage("craftPotion", ["potion" => $potion]));
	     }else{
		$this->plugin->message($player, Translation::getMessage("notEnoughMaterials", ["potion" => $potion]));
	     }
	   }else{
	     $this->plugin->message($player, Translation::getMessage("notCompletedTutorial", ["potion" => $potion]));
	  }
          break;
	}
    });
    $xp = $player->getXpLevel();
    $form->setTitle("§a§l-=Potions=-");
    $form->setContent("§aTokens§8->§a". TokenAPI::getInstance()->myToken($player). "\n§aLevel§8->§a". $xp);
    $form->addButton("§bCraft\n§dBrewable Potion");
    $form->addButton("§bCraft\n§dAmortentia §aP§bo§at§bi§ao§bn");
    $form->addButton("§bCraft\n§5Elixir §fof §cLife");
    $form->addButton("§bCraft\n§0Draught of Living Death");
    $form->addButton("§bCraft\n§8Skele-Gro §aP§bo§at§bi§ao§bn");
    $form->sendToPlayer($player);
    }
	
    public function onConsume(PlayerItemConsumeEvent $event){
        $potion = $event->getItem();
        $player = $event->getPlayer();
            if($potion->getName() === "§dAmortentia §aP§bo§at§bi§ao§bn"){
            $player->getInventory()->removeItem($potion);
            $absortion = Effect::getEffect(Effect::ABSORTION);
            $saturation = Effect::getEffect(Effect::SATURATION);
            $time = 600;
            $amp = 1;
            $player->addEffect(new EffectInstance($absortion,$time,$amp,true));
            $player->addEffect(new EffectInstance($saturation,$time,$amp,true));
            $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function(int $currentTick) use($player) : void{
            $player->removeEffect(Effect::WITHER);
            $player->removeEffect(Effect::NAUSEA);
            $player->removeEffect(Effect::POISON);
            $player->removeEffect(Effect::SLOWNESS);
	    }), 10);
	    //tick / 2 = 10 ticks = 1/2 second (1)
	    $this->plugin->message($player, Translation::getMessage("consumed", ["potion" => $potion->getName()]));
	}elseif($potion->getName() === "§8Skele-Gro §aP§bo§at§bi§ao§bn"){
            $player->getInventory()->removeItem($potion);
            $speed = Effect::getEffect(Effect::SPEED);
            $regeneration = Effect::getEffect(Effect::REGENERATION);
            $time = 600;
            $amp = 1;
            $player->addEffect(new EffectInstance($speed,$time,$amp,true));
            $player->addEffect(new EffectInstance($regeneration,$time,$amp,true));
            $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function(int $currentTick) use($player) : void{
            $player->removeEffect(Effect::WITHER);
            $player->removeEffect(Effect::NAUSEA);
            $player->removeEffect(Effect::POISON);
            $player->removeEffect(Effect::SLOWNESS);
	    }), 10);
	    //tick / 2 = 10 ticks = 1/2 second (1)
	    $this->plugin->message($player, Translation::getMessage("consumed", ["potion" => $potion->getName()]));
	}elseif($potion->getName() === "§5Elixir §fof §cLife"){
            $player->getInventory()->removeItem($potion);
            $strength = Effect::getEffect(Effect::STRENGTH);
            $resistance = Effect::getEffect(Effect::RESISTANCE);
            $regeneration = Effect::getEffect(Effect::REGENERATION);
            $time = 600;
            $amp = 1;
            $player->addEffect(new EffectInstance($strength,$time,$amp,true));
            $player->addEffect(new EffectInstance($resistance,$time,$amp,true));
            $player->addEffect(new EffectInstance($regeneration,$time,$amp,true));
            $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function(int $currentTick) use($player) : void{
            $player->removeEffect(Effect::WITHER);
            $player->removeEffect(Effect::NAUSEA);
            $player->removeEffect(Effect::POISON);
            $player->removeEffect(Effect::SLOWNESS);
	    }), 10);
	    //tick / 2 = 10 ticks = 1/2 second (1)
	    $this->plugin->message($player, Translation::getMessage("consumed", ["potion" => $potion->getName()]));
	}elseif($potion->getName() === "§0Draught of Living Death"){
            $player->getInventory()->removeItem($potion);
            $slowness = Effect::getEffect(Effect::SLOWNESS);
            $nausea = Effect::getEffect(Effect::NAUSEA);
            $poison = Effect::getEffect(Effect::POISON);
            $time = 300;
            $amp = 1;
            $player->addEffect(new EffectInstance($slowness,$time,$amp,true));
            $player->addEffect(new EffectInstance($nausea,$time,$amp,true));
            $player->addEffect(new EffectInstance($poison,$time,$amp,true));
            $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function(int $currentTick) use($player) : void{
            $player->removeEffect(Effect::WITHER);
            $player->removeEffect(Effect::NAUSEA);
            $player->removeEffect(Effect::POISON);
            $player->removeEffect(Effect::SLOWNESS);
	    }), 10);
	    //tick / 2 = 10 ticks = 1/2 second (1)
	    $this->plugin->message($player, Translation::getMessage("consumed", ["potion" => $potion->getName()]));
	    }
	}
	
        public function bookpage1form(Player $sender){
        $form = new SimpleForm(function (Player $sender, $data){
            	if ($data === null) {
                	return;
            			}
				switch($data){
                        	case 0:
                            	$this->page2($sender);
                            	break;
      		}
    	});
    	$form->setTitle("§l§a-=WizardingBook=-");
    	$form->setContent("§aTokens§8->§a". TokenAPI::getInstance()->myToken($sender) ."\n§9Magical Points§8->§9". MpAPI::getInstance()->myMp($sender). "\n\n§aUse §8/§atutorial to get started with your wizarding experiance");
    	$form->addButton("§8Next Page");
    	$form->sendToPlayer($sender);
    }
	
    public function page2(Player $player){
            $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[1];
			$arrayName = array("§8[§aBrewable §aP§bo§at§bi§ao§bn§8]", "§8[§dAmortentia §aP§bo§at§bi§ao§bn§8]", "§8[§8Skele-Gro §aP§bo§at§bi§ao§bn§8]", "§8[§5Elixir §fof §cLife§8]", "§8[§0Draught of Living Death§8]");
		    	$arrayValue = $arrayName[$index];

		    	if($arrayValue == "§8[§aBrewable §aP§bo§at§bi§ao§bn§8]") {
			   $this->Brew($player);
			}elseif($arrayValue == "§8[§dAmortentia §aP§bo§at§bi§ao§bn§8]") {
			        $this->Amortentia($player);
			}elseif($arrayValue == "§8[§8Skele-Gro §aP§bo§at§bi§ao§bn§8]") {
				$this->Skel($player);
			}elseif($arrayValue == "§8[§5Elixir §fof §cLife§8]") {
				$this->Elixir($player);
			}elseif($arrayValue == "§8[§0Draught of Living Death§8]") {
				$this->Draught($player);
	    		}
	    });
	    $form->setTitle("§l§a-=WizardingBook=-");
	    $form->addLabel("§aChoose a potion you would like to learn about");
	    $array = array("§8[§aBrewable §aP§bo§at§bi§ao§bn§8]", "§8[§dAmortentia §aP§bo§at§bi§ao§bn§8]", "§8[§8Skele-Gro §aP§bo§at§bi§ao§bn§8]", "§8[§5Elixir §fof §cLife§8]", "§8[§0Draught of Living Death§8]");
	    $form->addDropdown("§8Potions", $array);
	    $form->sendToPlayer($player);
    }
	
    public function Brew(Player $player) { 
            $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[0];
			$arrayName = $this->getIngredients("brew");
		    	$arrayValue = $arrayName[$index];

		  	if($arrayValue == "§8[§bWater §3Bottle §8(§c1§8)§8]") {
		     	   $player->sendMessage("§7(§c!§7) §cCan be found from killing witches or by talking to the shop keeper");
			}
	    });
	    $form->setTitle("§l§a-=WizardingBook=-");
	    $form->addDropdown("§cBrew: ", $this->getIngredients("brew"));
	    $form->sendToPlayer($player);
    }
	
    public function Amortentia(Player $player) { 
            $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[0];
			$arrayName = $this->getIngredients("amortentia");
		    	$arrayValue = $arrayName[$index];

		  	if($arrayValue == "§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]") {
		     	   $player->sendMessage("§7(§c!§7) §cYou can brew this potion your WizardingBook");
		  	}elseif($arrayValue == "§8[§fBone §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing skeletons");
		  	}elseif($arrayValue == "§8[§cRed Dye §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing skeletons or by talking to the shop keeper");
	    		}
	    });
	    $form->setTitle("§l§a-=WizardingBook=-");
	    $form->addDropdown("§cBrew: ", $this->getIngredients("amortentia"));
	    $form->sendToPlayer($player);
    }
	
    public function Skel(Player $player) { 
            $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[0];
			$arrayName = $this->getIngredients("skele");
		    	$arrayValue = $arrayName[$index];

		  	if($arrayValue == "§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]") {
		     	   $player->sendMessage("§7(§c!§7) §cYou can brew this potion your WizardingBook");
		  	}elseif($arrayValue == "§8[§bDiamond §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing zombies or by talking to the shop keeper");
		  	}elseif($arrayValue == "§8[§3Leather §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from talking to the shop keeper");
		  	}elseif($arrayValue == "§8[§6Golden Nugget §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from talking to the shop keeper");
		  	}elseif($arrayValue == "§8[§fBone §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing skeletons or by talking to the shop keeper");
	    		}
	    });
	    $form->setTitle("§l§a-=WizardingBook=-");
	    $form->addDropdown("§cBrew: ", $this->getIngredients("draught"));
	    $form->sendToPlayer($player);
    }
	
    public function Elixir(Player $player) { 
            $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[0];
			$arrayName = $this->getIngredients("elixir");
		    	$arrayValue = $arrayName[$index];

		  	if($arrayValue == "§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]") {
		     	   $player->sendMessage("§7(§c!§7) §cYou can brew this potion your WizardingBook");
		  	}elseif($arrayValue == "§8[§bDiamond §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing zombies or by talking to the shop keeper");
		  	}elseif($arrayValue == "§8[§dPink Dye §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing zombies or by talking to the shop keeper");
		  	}elseif($arrayValue == "§8[§cGun §0Powder §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing witchs or by talking to the shop keeper");
	    		}
	    });
	    $form->setTitle("§l§a-=WizardingBook=-");
	    $form->addDropdown("§cBrew: ", $this->getIngredients("elixir"));
	    $form->sendToPlayer($player);
    }
	
    public function Draught(Player $player) { 
            $api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            if(!isset($data)) return;
		    
                	$index = $data[0];
			$arrayName = $this->getIngredients("draught");
		    	$arrayValue = $arrayName[$index];

		  	if($arrayValue == "§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]") {
		     	   $player->sendMessage("§7(§c!§7) §cYou can brew this potion your WizardingBook");
		  	}elseif($arrayValue == "§8[§fBone §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing skeletons");
		  	}elseif($arrayValue == "§8[§dInk §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing spiders or by talking to the shop keeper");
		  	}elseif($arrayValue == "§8[§bDiamond §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing zombies or by talking to the shop keeper");
		  	}elseif($arrayValue == "§8[§cGun §0Powder §8(§c1§8)§8]") {
		     		$player->sendMessage("§7(§c!§7) §cCan be found from killing witches or by talking to the shop keeper");
	    		}
	    });
	    $form->setTitle("§l§a-=WizardingBook=-");
	    $form->addDropdown("§cBrew: ", $this->getIngredients("draught"));
	    $form->sendToPlayer($player);
    }
	
    public function getPotions(): array { 
	$array = array("§8[§aBrewable §aP§bo§at§bi§ao§bn§8]", "§8[§dAmortentia §aP§bo§at§bi§ao§bn§8]", "§8[§8Skele-Gro §aP§bo§at§bi§ao§bn§8]", "§8[§5Elixir §fof §cLife§8]", "§8[§0Draught of Living Death§8]");
	return $array;
    }

    public function getIngredients(string $name): array { 
	if($name == "brew") { 
	   return array("§8[§bWater §3Bottle §8(§c1§8)§8]");
	}elseif($name == "amortentia") { 
	   return array("§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]", "§8[§fBone §8(§c1§8)§8]", "§8[§cRed Dye §8(§c1§8)§8]");
	}elseif($name == "skele") { 
	   return array("§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]", "§8[§bDiamond §8(§c1§8)§8]", "§8[§3Leather §8(§c1§8)§8]", "§8[§6Golden Nugget §8(§c1§8)§8]", "§8[§fBone §8(§c1§8)§8]");
	}elseif($name == "elixir") { 
	   return array("§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]", "§8[§bDiamond §8(§c1§8)§8]", "§8[§dPink Dye §8(§c1§8)§8]", "§8[§cGun §0Powder §8(§c1§8)§8]");
	}elseif($name == "draught") { 
	   return array("§8[§cBrewable §aP§bo§at§bi§ao§bn §8(§c1§8)§8]", "§8[§bDiamond §8(§c1§8)§8]", "§8[§dInk §8(§c1§8)§8]", "§8[§cGun §0Powder §8(§c1§8)§8]", "§8[§fBone §8(§c1§8)§8]");
	}
    }
}
