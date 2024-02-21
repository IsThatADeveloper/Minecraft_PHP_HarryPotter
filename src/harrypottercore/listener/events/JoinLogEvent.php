<?php

namespace harrypottercore\listener\events;

use harrypottercore\Main;
use harrypottercore\utils\Scoreboard;
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

use harrypottercore\commands\settings\Setting;

//function 
use function time;
use function count;
use function floor;
use function microtime;
use function number_format;
use function round;

class JoinLogEvent implements Listener{
	
    public $welcomepre = "§3Welcome §b ";
    public $welcomesuf = " §eto §l§dWizarding Mania!";
    public $message = "§bWelcome To The §dMagical World Of HogWarts ";
	
    public $spacer = "§7===========================";

    private $plugin;
	
    public $permission;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function onPlayerLogin(PlayerLoginEvent $event){
		$player = $event->getPlayer();
		$event->getPlayer()->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn());
    }
	
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
	$this->plugin->scoreBoard($player);
	$event->setJoinMessage(null);
	$p = $player->getName();
	$xp = $this->plugin->getXpLevel($player);
	$progress = $this->plugin->getXpProgress($player);
	$mp = MpAPI::getInstance()->myMp($player);
	$token = TokenAPI::getInstance()->myToken($player);
	if(!$this->plugin->playerExists($player)) {
	    $this->plugin->getLogger()->info("Creating new player profile");
	    $this->plugin->getLogger()->info("Creating new Wizarding Level profile");
	    $this->plugin->getLogger()->info("Creating new Defense profile");
	    $this->plugin->getLogger()->info("Profile can be found " . $this->getPlugin()->playerFolder . $player->getLowerCaseName() .".yml");
	    $this->plugin->registerPlayer($player);
	}
	if(!file_exists($this->plugin->userCooldownFolder . $player->getLowerCaseName() . ".yml")) {
	   $this->plugin->saveWandCooldown($player);
	}
	if($this->getPlugin()->getSound($player) == false) {
	   $this->getPlugin()->setSound($player, true);
	}
	    
	//gives player book -> make it a book which has stuff in it for magic and instructs to go to olivanders
 	$this->getPlugin()->setSound($player, true);
	if(!$event->getPlayer()->hasPlayedBefore()) {
	   $this->plugin->registerPlayer($player);
	   $this->plugin->getServer()->broadcastMessage($this->welcomepre .$player. $this->welcomesuf);
           $player->sendMessage($this->spacer);	
           $player->sendMessage($this->plugin->getShop());
           $player->sendMessage($this->plugin->getDiscord());
           $player->sendMessage($this->plugin->getVote());
           $player->sendMessage($this->message .$p);
           $player->sendMessage($this->spacer);
		
           $wizardbook = Item::get(403, 0, 1)->setCustomName("$p's §dWizarding Book");
	   $player->getInventory()->addItem($wizardbook);
    	   }elseif(!$this->plugin->isComplete($player)){
                   $player->sendMessage($this->spacer);	
           	   $player->sendMessage($this->plugin->getShop());
           	   $player->sendMessage($this->plugin->getDiscord());
           	   $player->sendMessage($this->plugin->getVote());
           	   $player->sendMessage($this->message .$p);
                   $player->sendMessage($this->spacer);
	   	   }elseif($this->plugin->isComplete($player)){
                   	   $player->sendMessage($this->spacer);	
           		   $player->sendMessage($this->plugin->getShop());
           		   $player->sendMessage($this->plugin->getDiscord());
           		   $player->sendMessage($this->plugin->getVote());
           		   $player->sendMessage($this->message .$p);
                   	   $player->sendMessage($this->spacer);
                   	   $player->sendMessage("§aXp§7: §b".$xp."§7,§b" . round($progress));
                   	   $player->sendMessage("§3Magical Power§7:§5 " . $mp);
                   	   $player->sendMessage("§eTokens§7:§a " . $token);
        		   $player->sendMessage("§cDefense§7:§4 " . $this->plugin->getDefense($player));
        		   $player->sendMessage("§cWizarding Level§7:§4 " . $this->plugin->getLevel($player));
	  		   $player->sendMessage($this->spacer);
        		   $player->sendTip("§cThere are " .$this->plugin->getOnline(). " players online");
	}
    }
	
    public function onQuit(PlayerQuitEvent $event) {
	    $player = $event->getPlayer();
	    $event->setQuitMessage(null);
	    if(!isset($this->plugin->cooldown[$player->getName()])){
	       //exit = perfect;
	    }else{
	    	unset($this->plugin->cooldown[$player->getName()]);
		\harrypottercore\utils\Scoreboard::remove($player);
	    }
    }
}
