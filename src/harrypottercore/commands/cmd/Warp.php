<?php

namespace harrypottercore\commands\cmd;

use harrypottercore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI;
use pocketmine\math\Vector3;
use pocketmine\utils\config;

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;

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

use harrypottercore\messages\Translation;

class Warp extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setDescription("Opens Warps");
    }
//includes levelup system 
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
    if($this->getPlugin()->isComplete($sender)) {
       $this->warpmagicform($sender);
    }else{
       $this->getPlugin()->message($sender, Translation::getMessage("tutorialNotCompleted"));
       }
    }
	
    public function warpmagicform(Player $player){
            $api = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("FormAPI");
	    $form = $api->createCustomForm(function(Player $player, ?array $data){
            	if(!isset($data)) return;
		    
		 	$cord = new Config($this->getPlugin()->cordFolder . "/cords.yml", Config::YAML);
	   		$worldmade = $cord->get("sworld");
		    
                	$index = $data[0];
			$arrayName = array("diagon alley", "hogwarts", "woods", "hagrid");
		    	$arrayValue = $arrayName[$index];
		    	
		    	if($arrayValue == "diagon alley") {
	   		   $x = $cord->get("diagonx");
	   		   $y = $cord->get("diagony");
	   		   $z = $cord->get("diagonz");
	   		   if($worldmade == null) {
			      $this->getPlugin()->message($player, Translation::getMessage("notCreated"));
	   		   }else{
     	      		      $world = $this->getPlugin()->getServer()->getLevelByName($worldmade);
     	     		      $player->teleport($world->getSafeSpawn());
	   		      $x = $cord->get("diagonx");
	   		      $y = $cord->get("diagony");
	   		      $z = $cord->get("diagonz");   
			      $player->teleport(new Vector3($x, $y, $z));
			      $player->addTitle(Translation::getMessage("playerWarping"));
			      $this->particle($player);
			   }
			}
			if($arrayValue == "hagrid") {
	   		   if($worldmade == null) {
			      $this->getPlugin()->message($player, Translation::getMessage("notCreated"));
	   		   }else{
     	      		      $world = $this->getPlugin()->getServer()->getLevelByName($worldmade);
     	     		      $player->teleport($world->getSafeSpawn());
	   		      $x = $cord->get("hagridx");
	   		      $y = $cord->get("hagridy");
	   		      $z = $cord->get("hagridz");
			      $player->teleport(new Vector3($x, $y, $z));
			      $player->addTitle(Translation::getMessage("playerWarping"));
			      $this->particle($player);
			   }
			}
			if($arrayValue == "hogwarts") {
	   		   if($worldmade == null) {
			      $this->getPlugin()->message($player, Translation::getMessage("notCreated"));
	   		   }else{
     	      		      $world = $this->getPlugin()->getServer()->getLevelByName($worldmade);
     	     		      $player->teleport($world->getSafeSpawn());
	   		      $x = $cord->get("hogwartx");
	   		      $y = $cord->get("hogwarty");
	   		      $z = $cord->get("hogwartz");
			      $player->teleport(new Vector3($x, $y, $z));
			      $player->addTitle(Translation::getMessage("playerWarping"));
			      $this->particle($player);
			   }
			}
			if($arrayValue == "woods") {
	   		   if($worldmade == null) {
			      $this->getPlugin()->message($player, Translation::getMessage("notCreated"));
	   		   }else{
     	      		      $world = $this->getPlugin()->getServer()->getLevelByName($worldmade);
     	     		      $player->teleport($world->getSafeSpawn());
	   		      $x = $cord->get("woodsx");
	   		      $y = $cord->get("woodsy");
	   		      $z = $cord->get("woodsz");   
			      $player->teleport(new Vector3($x, $y, $z));
			      $player->addTitle(Translation::getMessage("playerWarping"));
			      $this->particle($player);
			   }
			}
	    });
	    $form->setTitle("§l§a-=WarpUI=-");
	    if($this->getPlugin()->isComplete($player) and $this->getPlugin()->getLevel($player) <= 0){
	    $array = array("hogwarts");
	    $form->addDropdown("§8Warps", $array);
	    }elseif($this->getPlugin()->getLevel($player) >= 0 and $this->getPlugin()->getLevel($player) <= 1) {
	    	    $array = array("hogwarts", "diagon alley");
		    $form->addDropdown("§8Warps", $array);
	    }elseif($this->getPlugin()->getLevel($player) >= 2 and $this->getPlugin()->getLevel($player) <= 3) {
	    	    $array = array("hogwarts", "diagon alley", "woods");
		    $form->addDropdown("§8Warps", $array);
	    }elseif($this->getPlugin()->getLevel($player) >= 3 or $player->isOp()) {
	    	    $array = array("hogwarts", "diagon alley", "woods", "hagrid");
		    $form->addDropdown("§8Warps", $array);
	    }
	    $form->sendToPlayer($player);
    }
	
    public function particle(Player $player) {
	   if($player instanceof Player) {
	      $player->getLevel()->addParticle(new SmokeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	      $player->getLevel()->addParticle(new CriticalParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	      $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	      }
    }
}


