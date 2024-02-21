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

use harrypottercore\task\blocks\AddBlocksStageOneTask;
use harrypottercore\task\blocks\AddBlocksStageTwoTask;
use harrypottercore\task\blocks\AddBlocksStageThreeTask;
use harrypottercore\task\blocks\AddBlocksStageFourTask;
use harrypottercore\task\blocks\AddBlocksStageFiveTask;
use harrypottercore\task\blocks\AddBlocksStageSixTask;
use harrypottercore\task\blocks\AddBlocksStageSevenTask;

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

class WallMovementEvent implements Listener{

    private $plugin;
	
    public $wall = [];

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
	
    public function AddBlocks(Player $player) {
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageSixTask($this->plugin, $player), 10 * 20);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageFiveTask($this->plugin, $player), (10 * 20) + 5);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageFourTask($this->plugin, $player), (10 * 20) + 10);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageThreeTask($this->plugin, $player), (10 * 20) + 15);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageTwoTask($this->plugin, $player), 11 * 20);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageOneTask($this->plugin, $player), (11 * 20) + 5);
    }
	
    public function RemoveBlocks(Player $player) {
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageOneTask($this->plugin, $player), 10);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageTwoTask($this->plugin, $player), 15);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageThreeTask($this->plugin, $player), 20);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageFourTask($this->plugin, $player), 25);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageFiveTask($this->plugin, $player), 30);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageSixTask($this->plugin, $player), 45);
           $this->plugin->getScheduler()->scheduleDelayedTask(new AddBlocksStageSevenTask($this->plugin, $player), 50);
    }
	
    public function onBlockTouch(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
  	$block = $event->getBlock();
        $blockID = $block->getId();
	$brick = BlockFactory::get(Block::BRICK_BLOCK);
	$x = $block->getX();
	$y = $block->getY();
	$z = $block->getZ();
	if($x == ("-330") and $y == ("4") and $z == ("117")) {
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
	      $seconds = ($this->wall[$player->getName()] - time());
	      $player->sendTip("§7(§c!§7) §cCooldown §5" . $seconds . " §cseconds remaining");
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-330") and $y == ("5") and $z == ("117")) {
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-330") and $y == ("6") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-330") and $y == ("8") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-331") and $y == ("4") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-331") and $y == ("5") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-331") and $y == ("6") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-331") and $y == ("7") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-331") and $y == ("8") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	    //next #3
	if($x == ("-332") and $y == ("4") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-332") and $y == ("5") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-332") and $y == ("6") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-332") and $y == ("7") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-332") and $y == ("8") and $z == ("117")) { 
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	   //next #4
	if($x == ("-333") and $y == ("4") and $z == ("117")) {
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-333") and $y == ("5") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-333") and $y == ("6") and $z == ("117")) { 
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-333") and $y == ("7") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-333") and $y == ("8") and $z == ("117")) { 
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	   //next #5
	if($x == ("-334") and $y == ("4") and $z == ("117")) { 
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-334") and $y == ("5") and $z == ("117")) { 
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-334") and $y == ("6") and $z == ("117")) {
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-334") and $y == ("7") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-334") and $y == ("8") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	    //next #6
	if($x == ("-335") and $y == ("4") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-335") and $y == ("5") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-335") and $y == ("6") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-335") and $y == ("7") and $z == ("117")) {  
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
	if($x == ("-335") and $y == ("8") and $z == ("117")) { 
	   if(!isset($this->wall[$player->getName()])){
	   $this->wall[$player->getName()] = time() + 11.25;
	   //remove
	   $this->RemoveBlocks($player);
           //add
	   $this->AddBlocks($player);
	}else{
	   if(time() < $this->wall[$player->getName()]){
    	      $player->sendTip(Translation::getMessage("cooldown", ["seconds" => $this->wall[$player->getName()] - time()]));
	   }else{
	      unset($this->wall[$player->getName()]);
	   }
	   }
	}
    }
}
