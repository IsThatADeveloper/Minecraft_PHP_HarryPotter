<?php

namespace harrypottercore; //HarryPotterCore::getInstance()->getTutorial($player) (example) or Main::getInstance()

//commands
use harrypottercore\commands\essential\Jump;
use harrypottercore\commands\essential\Speed;
use harrypottercore\commands\essential\Heal;
use harrypottercore\commands\essential\NightVision;
use harrypottercore\commands\essential\Feed;
use harrypottercore\commands\essential\Fly;
use harrypottercore\commands\essential\Day;
use harrypottercore\commands\essential\Night;
use harrypottercore\commands\builder\Gmc;
use harrypottercore\commands\builder\Gms;
use harrypottercore\commands\builder\Gma;
use harrypottercore\commands\builder\Gmspc;
use harrypottercore\commands\staff\Ban;
use harrypottercore\commands\staff\Mute;
use harrypottercore\commands\staff\Whitelist;
use harrypottercore\commands\staff\Kick;
use harrypottercore\commands\cmd\Tinker;
use harrypottercore\commands\cmd\Warp;
use harrypottercore\commands\cmd\Sethouse;
use harrypottercore\commands\cmd\Myhouse;
use harrypottercore\commands\cmd\Setxp;
use harrypottercore\commands\spawn\Spawn;
use harrypottercore\commands\spawn\Setspawn;
use harrypottercore\commands\spawn\Setwarps;
use harrypottercore\commands\shop\shops\Shop;
use harrypottercore\commands\shop\shops\WandShop;
use harrypottercore\commands\shop\shops\WandShopOption;
use harrypottercore\commands\shop\kit\Kit;
use harrypottercore\commands\tutorial\Tutorial;
use harrypottercore\commands\settings\Setting;
use harrypottercore\commands\tags\Tags;
use harrypottercore\commands\wandfunctions\Wands;

//utils
use harrypottercore\utils\Facing;
use harrypottercore\utils\Scoreboard;
use harrypottercore\utils\Potions;
use harrypottercore\wand\crafting\ElderWand;
use harrypottercore\entity\command\Test;
use harrypottercore\entity\base\EntityEvent;
use pocketmine\event\Listener;


//listeners
use harrypottercore\listener\events\PotionListener;
use harrypottercore\listener\events\WandDamage;
use harrypottercore\listener\events\levelup\LevelUpSystems;
use harrypottercore\listener\events\DataBackUps;
use harrypottercore\listener\events\JoinLogEvent;
use harrypottercore\listener\events\DeathEvent;
use harrypottercore\listener\events\WallMovementEvent;
use harrypottercore\listener\events\Data;
use harrypottercore\listener\wands\Functions;

//textures
use harrypottercore\texture\Packet;

//particles
use harrypottercore\task\particles\CreateParticleTask;
use harrypottercore\task\RespawnUpdateTask;
use harrypottercore\task\broom\CheckBroomTask;
use harrypottercore\task\cooldown\WandCooldownUpdateTask;
use harrypottercore\task\Tick;
use harrypottercore\task\AddMp;
use harrypottercore\task\ScoreboardUpdate;

use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskScheduler;

use pocketmine\event\player\PlayerChatEvent;

//config
use pocketmine\utils\config;

//pocketmine entities
use pocketmine\entity\Entity;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Zombie;
use pocketmine\entity\Villager;
use pocketmine\entity\Skin;

//item, blocks
use pocketmine\block\BlockFactory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Tool;
use pocketmine\item\ItemFactory;

//pocketmine
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\math\Vector3;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\utils\Utils;

//economy
use onebone\tokenapi\TokenAPI; //used in replacement of coins
use onebone\mpapi\MpAPI; //magical power for wands

//form ui
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

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
use function strtotime; //string to time
use function strtolower; //string lowers all letters
use function strtoupper; //string upper letters all
use function ucwords; //uppercases each word in the string

class Main extends PluginBase implements Listener {
	
    /** @var ProviderInterface */
    private $provider;
	
    /** @var null  */
    private static $instance = null;
	
    public $harrypottertag = "§k§l§f-§r§cWizarding§3Mania§k§f§l-§r§l§f";
	
    public $userCooldownFolder;
    public $playerFolder;
    public $cordFolder;	
    public $textureFolder;
    public $backupDrive;
	
    public $time;
    public $seconds = 0;
	
    public $cooldown = [];
    public $book = [];
    public $elderwand = [];
    public $basicwand = [];
    public $crimsonwand = [];
    public $deatheaterwand = [];
    public $ronwand = [];
    public $hermionewand = [];
    public $harrypotterwand = [];
    public $pheonixwand = [];
    public $potions = [];
    public $players = [];
    public $mute = [];
    public $warps = [];
    private $sound = [];
	
    public $mission;
	
    public $group;
    public $prefix;
    public $suffix;
    public $permission;
    public $elder;
    public $basic;
    public $crimson;
    public $deatheater;
    public $ron;
    public $hermione;
    public $harrypotter;
    public $pheonix;
    public $defensemultiplier;
    public $kb;
    public $online;
    public $discord;
    public $vote;
    public $shop;
    public $item;
    public $tutorial;
    public $mutetime;
	
    private $wizard;
    private $level;
    private $defense;
	
    public function onEnable()
    {
        self::$instance = $this;
	    //command map
        Main::getInstance()->getServer()->getPluginManager()->registerEvents($this, $this);
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new PotionListener($this), $this); //done
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new WandDamage($this), $this); //done
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new LevelUpSystems($this), $this); //done
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new DataBackUps($this), $this); //done
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new JoinLogEvent($this), $this); //done
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new DeathEvent($this), $this); //done
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new WallMovementEvent($this), $this); //done
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new Functions($this), $this);
        Main::getInstance()->getServer()->getPluginManager()->registerEvents(new Data($this), $this);
        $commandMap = Main::getInstance()->getServer()->getCommandMap();
        $commandMap->register("hpcore", new Jump("jump", $this)); //done
        $commandMap->register("hpcore", new Speed("speed", $this)); //done
        $commandMap->register("hpcore", new Heal("heal", $this)); //done
        $commandMap->register("hpcore", new Feed("feed", $this)); //done
        $commandMap->register("hpcore", new Nightvision("nv", $this)); //done
        $commandMap->register("hpcore", new Gmc("gmc", $this)); //done
        $commandMap->register("hpcore", new Gms("gms", $this)); //done
        $commandMap->register("hpcore", new Gma("gma", $this)); //done
        $commandMap->register("hpcore", new Gmspc("gmspc", $this)); //done
        $commandMap->register("hpcore", new Day("day", $this)); //done
        $commandMap->register("hpcore", new Night("night", $this)); //done
        $commandMap->register("hpcore", new Fly("fly", $this)); //done
        $commandMap->register("hpcore", new Tinker("tinker", $this)); //done
        $commandMap->register("hpcore", new Ban("banui", $this)); //done
        $commandMap->register("hpcore", new Mute("muteui", $this)); //done
        $commandMap->register("hpcore", new Whitelist("staffwhitelist", $this)); //done
        $commandMap->register("hpcore", new Kick("kickui", $this)); //done
        $commandMap->register("hpcore", new Sethouse("sethome", $this)); //done
        $commandMap->register("hpcore", new Myhouse("myhouse", $this)); //done
        $commandMap->register("hpcore", new Setxp("setxp", $this)); //done
        $commandMap->register("hpcore", new Setspawn("setspawn", $this)); //done
        $commandMap->register("hpcore", new Spawn("spawn", $this)); //done
        $commandMap->register("hpcore", new Tutorial("tutorial", $this)); //done
        $commandMap->register("hpcore", new Kit("kit", $this)); //done
        $commandMap->register("hpcore", new Wands("wands", $this)); //done
        $commandMap->register("hpcore", new Setting("settings", $this)); //done
        $commandMap->register("hpcore", new WandShopOption("shopoption", $this)); //done
        $commandMap->register("hpcore", new WandShop("wandshop", $this)); //done
        $commandMap->register("hpcore", new Tags("tags", $this)); //done
        $commandMap->register("hpcore", new Shop("shop", $this)); //done
        $commandMap->register("hpcore", new Warp("warps", $this)); //done
        $commandMap->register("hpcore", new Setwarps("setwarp", $this)); //done
        $commandMap->register("hpcore", new Test("test", $this)); //adding
	    
            if(!file_exists($this->userCooldownFolder)) {
                $this->userCooldownFolder = $this->getDataFolder() . "Cooldowns/";
                @mkdir($this->userCooldownFolder, 0777, true);
	    }
            if(!file_exists($this->playerFolder)) {
                $this->playerFolder = $this->getDataFolder() . "Players/";
                @mkdir($this->playerFolder, 0777, true);
	    }
            if(!file_exists($this->cordFolder)) {
                $this->cordFolder = $this->getDataFolder() . "Coordinates/";
                @mkdir($this->cordFolder, 0777, true);
	    }
            if(!file_exists($this->textureFolder)) {
                $this->textureFolder = $this->getDataFolder() . "Textures/";
                @mkdir($this->textureFolder, 0777, true);
	    }
            if(!file_exists($this->backupDrive)) {
                $this->backupDrive = $this->getDataFolder() . "BackupDrive/";
                @mkdir($this->backupDrive, 0777, true);
	    }
	    
	    $this->getScheduler()->scheduleRepeatingTask(new Tick($this), 1200);
	    $this->getScheduler()->scheduleRepeatingTask(new WandCooldownUpdateTask($this), 1);
	    $this->getScheduler()->scheduleRepeatingTask(new CreateParticleTask($this), 2);
	    $this->getScheduler()->scheduleRepeatingTask(new AddMp($this), 2 * 60 * 20);
	    $this->getScheduler()->scheduleRepeatingTask(new ScoreboardUpdate($this), 2 * 20);
	    
	    $texture = new Packet($this);
	    $texture->enablePackets();
	    
	    $data = new Data($this);
	    $data->cordConfig();
	    $data->registerCreativeItems();
	    $data->registerEntities();
	    $data->loadTextures();
	    $data->loadWorlds();
	    
	    $this->getServer()->getNetwork()->setName($this->harrypottertag); 
    }
	
    public function onMute(PlayerChatEvent $event) { 
	    $player = $event->getPlayer();
	    if(!isset($this->mute[$player->getName()])){
	       //chat normal
	    }elseif(time() < $this->mute[$player->getName()]){
	       $event->setCancelled();
	       $player->sendMessage("§7(§c!§7) §cYou are muted, you cannot speak.");
	    }
   }
	
   /**
   * @param Player $player
   */
    public function registerPlayer(Player $player): void{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		if((!$config->exists("mined")) && (!$config->exists("tutorial")) && (!$config->exists("defense")) && (!$config->exists("level")) && (!$config->exists("death")) && (!$config->exists("playerkilled")) && (!$config->exists("mobkilled")) && (!$config->exists("xplevel")) && (!$config->exists("xpprogress")) && (!$config->exists("mission")) && (!$config->exists("sound"))){
			$config->setAll([
				"player" => $player->getName(), 
				"ip" => $player->getAddress(), 
				"defense" => 0, 
				"xplevel" => 0,
				"level" => 0, 
				"mined" => 0, 
				"death" => 0, 
				"playerkilled" => 0, 
				"mobkilled" => 0, 
				"xpprogress" => 0,
				"tutorial" => false,
				"mission" => $this->mission,
				"sound" => false
			]);
			$this->tutorial = (int) $config->get("tutorial");
			$config->save();
		}
   }
	
   public function useWand(Player $player, string $magic) { 
	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("MpAPI")->myMp($player) <= ($magic)) {
	   $player->sendMessage("§7(§c!§7) §cYou do not have enough magic to use your wand");
	}else{
	   MpAPI::getInstance()->reduceToken($player, $magic);
	}
   }
	
   public function getWandAbility(Player $player) : bool{
	if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("MpAPI")->myMp($player) >= ($magic)) {
	   return true;
	}else{
	   return false;
	}
   }
	
   public function isAbleToUseWand(Player $player) : bool{
        return $this->getWandAbility($player) ? true : false;
   }
	
   /**
   * @param Player $player
   * @return bool
   */
   public function playerExists(Player $player): bool{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (($config->exists("mined")) && ($config->exists("defense")) && ($config->exists("tutorial")) && ($config->exists("level")) && ($config->exists("death")) && ($config->exists("playerkilled")) && ($config->exists("mobkilled")) && ($config->exists("xplevel")) && ($config->exists("xpprogress")) && ($config->exists("mission")) && ($config->exists("sound"))) ? true : false;
   }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getMission(Player $player): bool{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return $config->get("mission");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getTutorial(Player $player): bool{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return $config->get("tutorial");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getMined(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("mined");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getDefense(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("defense");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getDeath(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("death");
    }

    /**
    * @param Player $player
    * @return string
    */
    public function getPlayerKilled(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("playerkilled");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getMobKilled(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("mobkilled");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getXpLevel(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("xplevel");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getLevel(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("level");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getNextXpLevel(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("xplevel") + 1;
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getOldXpLevel(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("xplevel") - 1;
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getNextLevel(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("level") + 1;
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getOldLevel(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("level") - 1;
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getXpProgress(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("xpprogress");
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getIp(Player $player): int{
		$config = new Config($this->playerFolder . $player->getLowerCaseName() . ".yml", Config::YAML);
		return (int) $config->get("ip");
    }
	
    //pureperms
	
    /**
    * @param Player $player
    * @return string
    */
    public function setPermission(Player $player, $permission) {
    	 return $this->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->setPermission($player, $permission);
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function getGroup(Player $player) {
	 $this->group = $this->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->getGroup($player)->getName();	    
    	 return $this->group;
    }
	
    /**
    * @param Player $player
    * @return string
    */
    public function unsetPermission(Player $player, $permission) {
    	 return $this->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->unsetPermission($player, $permission);
    }
	
    public function setPlayerPrefix(Player $player, $prefix) { 
	$levelname = $player->getLevel()->getName();
	$purechat = $this->getServer()->getPluginManager()->getPlugin("HarryPotterPureChat");
	return $purechat->setPrefix($prefix, $player, $levelname);
    }
	
    public function setTutorial(Player $player, $bool = false) {
	    $config = new Config($this->getPlugin()->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
	    return $config->set("tutorial", $bool);
    }
	
    //about
	
    public function getDiscord(): string{    
	$this->discord = "§b§lDiscord§r §7:: §1https://discord.gg/98M86vV/";
	return $this->discord;
    }
	
    public function getVote(): string{    
	$this->vote = "§l§aVote §r§7:: ";
	return $this->vote;
    }
	
    public function getShop(): string{    
	$this->shop = "§l§dShop§r §7:: ";
	return $this->shop;
    }
	
    public function getKb(): int{
	return (int) $this->kb;
    }
	
    public function getOnline(): int{    
	$this->online = count($this->getServer()->getOnlinePlayers());
	return (int) $this->online;
    }

    //wands

    public function getElder(): int{
	return (int) $this->elder;
    }
	
    public function getBasic(): int{
	return (int) $this->basic;
    }
	
    public function getCrimson(): int{
	return (int) $this->crimson;
    }
	
    public function getDeathEater(): int{
	return (int) $this->deatheater;
    }
	
    public function getHarryPotter(): int{
	return (int) $this->harrypotter;
    }
	
    public function getHermione(): int{
	return (int) $this->hermione;
    }
	
    public function getElderCooldown(Player $player): int{    
	return (int) strtotime(isset($this->elderwand[$player->getName()]));
    }
	
    public function getBasicCooldown(Player $player): int{    
	return (int) strtotime(isset($this->basicwand[$player->getName()]));
    }
	
    public function getCrimsonCooldown(Player $player): int{    
	return (int) strtotime(isset($this->crimsonwand[$player->getName()]));
    }
	
    public function getDeathEaterCooldown(Player $player): int{    
	return (int) strtotime(isset($this->deatheaterwand[$player->getName()]));
    }
	
    public function getRonCooldown(Player $player): int{    
	return (int) strtotime(isset($this->ronwand[$player->getName()]));
    }
	
    public function getHermioneCooldown(Player $player): int{    
	return (int) strtotime(isset($this->hermionewand[$player->getName()]));
    }
	
    public function getHarryPotterCooldown(Player $player): int{    
	return (int) strtotime(isset($this->harrypotterwand[$player->getName()]));
    }
	
    public function getPheonixCooldown(Player $player): int{    
	return (int) strtotime(isset($this->pheonixwand[$player->getName()]));
    }
	
    public function getSlytherinCooldown(Player $player): int{    
	return (int) strtotime(isset($this->skit[$player->getName()]));
    }
	
    public function getGryffindorCooldown(Player $player): int{    
	return (int) strtotime(isset($this->gkit[$player->getName()]));
    }

    public function getHufflepuffCooldown(Player $player): int{    
	return (int) strtotime(isset($this->hkit[$player->getName()]));
    }
	
    public function getRavenclawCooldown(Player $player): int{    
	return (int) strtotime(isset($this->rkit[$player->getName()]));
    }
	
    public function getDeCooldown(Player $player): int{    
	return (int) strtotime(isset($this->dekit[$player->getName()]));
    }
	
    public function getVoldCooldown(Player $player): int{    
	return (int) strtotime(isset($this->voldkit[$player->getName()]));
    }
	
    public function getHpCooldown(Player $player): int{    
	return (int) strtotime(isset($this->hpkit[$player->getName()]));
    }
	
    public function getRon(Player $player): int{
	return (int) strtotime(isset($this->ron[$player->getName()]));
    }
	
    public function getPlayers(): int{
	foreach($this->getServer()->getOnlinePlayers() as $this->players) {
	return (int) $this->players;
	}
    }
	
    public function getMuteTime(): int{
	return (int) $this->mutetime;
    }
	
    /**
    * @return static
    */
    public static function getInstance() : self {
        return self::$instance;
    }
	
    public function isComplete(Player $player) : bool{
	return $this->getTutorial($player) ? true : false;
    }
	
    public function message(Player $player, string $message) { 
	    return $player->sendMessage($message);
    }
	
    public function command($command) { 
	return $this->getServer()->dispatchCommand(new \pocketmine\command\ConsoleCommandSender(), $command);
    }
	
    //items
	
    public function getItem(): Item{
	return $this->item;
    }
	
    public function addItem(Player $player, $itemID, $itemMeta, $itemCount, $itemName = null, $itemLore = null) {
	      return $player->getInventory()->addItem(Item::get($itemID, $itemMeta, $itemCount))->setCustomName($itemName)->setLore([$itemLore]);
    }
	
    public function itemLore(Player $player): string {
	return $player->getInventory()->getItemInHand()->getLore();
    }
	
    public function itemName(Player $player): string {
	return $player->getInventory()->getItemInHand()->getName();
    }
	
    public function setSound(Player $player, $string) { 
	$config = new Config($this->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
	if($this->getSound($player) == true) { 
	   return $config->set("sound", false);
	}elseif($this->getSound($player) == false) { 
	   return $config->set("sound", true);
	}
    }

    public function getSound(Player $player) { 
	$config = new Config($this->playerFolder . strtolower($player->getName()) . ".yml", Config::YAML);
	return $config->get("sound");
    }  
	
    public function scoreBoard(Player $player) {   
	$guest = "Guest";
	$slytherin = "Slytherin";
	$gryffindor = "Gryffindor";
	$hufflepuff = "Hufflepuff";
	$ravenclaw = "Ravenclaw";
        \harrypottercore\utils\Scoreboard::new($player, 'harrypottercore', "§k§l§f-§r§cWizarding§3Mania§k§f§l-§r§l§f");
        \harrypottercore\utils\Scoreboard::setLine($player, 1, " " . "§r§7[§3§lHogWarts Home§r§7]§1:"); //group 
	if($this->getGroup($player) == $guest) {
        \harrypottercore\utils\Scoreboard::setLine($player, 2, " " . "§7» §7" . $this->getGroup($player));
	}elseif($this->getGroup($player) == $slytherin) {
        \harrypottercore\utils\Scoreboard::setLine($player, 2, " " . "§7» §a" . $this->getGroup($player));
	}elseif($this->group == $gryffindor) {
        \harrypottercore\utils\Scoreboard::setLine($player, 2, " " . "§7» §6" . $this->getGroup($player));
	}elseif($this->getGroup($player) == $hufflepuff) {
        \harrypottercore\utils\Scoreboard::setLine($player, 2, " " . "§7» §e" . $this->getGroup($player));
	}elseif($this->getGroup($player) == $ravenclaw) {
        \harrypottercore\utils\Scoreboard::setLine($player, 2, " " . "§7» §b" . $this->getGroup($player));
	}
        \harrypottercore\utils\Scoreboard::setLine($player, 3, " " . "§8§l» ---- ");
        \harrypottercore\utils\Scoreboard::setLine($player, 4, " " . "§7[§l§aWizarding Stats§r§7]§1:");
        \harrypottercore\utils\Scoreboard::setLine($player, 5, " " . "§7» §aLevel§7: §a" . $this->getLevel($player));
        \harrypottercore\utils\Scoreboard::setLine($player, 6, " " . "§7» §aDefense§7: §a" . $this->getDefense($player));
        \harrypottercore\utils\Scoreboard::setLine($player, 7, " " . "§8§l» ----");
        \harrypottercore\utils\Scoreboard::setLine($player, 8, " " . "§7[§l§eEconomy Stats§r§7]§1:");
        \harrypottercore\utils\Scoreboard::setLine($player, 9, " " . "§7» §5MagicalPower§7: §5" . MpAPI::getInstance()->myMp($player));
        \harrypottercore\utils\Scoreboard::setLine($player, 10, " " . "§7» §aToken§7: §2" . TokenAPI::getInstance()->myToken($player));
        \harrypottercore\utils\Scoreboard::setLine($player, 11, " " . "§8§l» ---- ");
	if($this->getMission($player) == null) {
           \harrypottercore\utils\Scoreboard::setLine($player, 12, " " . "§7» §3No Active Mission");
	}else{
           \harrypottercore\utils\Scoreboard::setLine($player, 12, " " . "§7» §3Mission§7: §2" . $this->getMission($player));
	}
        \harrypottercore\utils\Scoreboard::setLine($player, 13, " " . "§8§l» ---- ");
        \harrypottercore\utils\Scoreboard::setLine($player, 14, " " . "§dplay.§cWizarding§3Mania.§dtk");
    }
}
