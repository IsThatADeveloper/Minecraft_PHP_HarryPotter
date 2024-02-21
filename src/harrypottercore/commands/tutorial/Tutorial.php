<?php

namespace harrypottercore\commands\tutorial;

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
use onebone\tokenapi\TokenAPI;
use pocketmine\level\Position;
use pocketmine\level\Level;
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

//config
use pocketmine\utils\config;

// Perms used in this
// getwand.use
// tutorial = true ? false
// complete1.use
// explore.use
// complete2.use
// complete3.use
// complete4.use
// complete5.use
// complete6.use
// complete7.use
// $player starts with 0 perms 
// requires no perms aside from guest.use so $player can sethome and progress

class Tutorial extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
    }

    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
	 if($this->getPlugin()->isComplete($player) == true){
	    $this->getPlugin()->message($player, Translation::getMessage("tutorialCompleted"));
	 }else{
            $this->TutorialPage($player);
	 }
    }
	
    public function getStore() { 
	    return new TutorialFiles($this->getPlugin());
    }
	
    public function TutorialPage(Player $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
            	  case 0: 
            $this->WandPage($player);
                break;    
            	  case 1:
	    if($player->hasPermission("complete1.use")){
            $this->ExplorePage($player);
	 }else{
	    $this->getPlugin()->message($player, Translation::getMessage("notCompleted", ["level" => 1]));
	    }
                break; 
            	  case 2: 
	    if($player->hasPermission("complete2.use")){
            $this->WarpPage($player);
	 }else{
	    $this->getPlugin()->message($player, Translation::getMessage("notCompleted", ["level" => 2]));
	    }
                break; 
            	  case 3: 
	    if($player->hasPermission("complete3.use")){
            $this->XpLevelPage($player);
	 }else{
	    $this->getPlugin()->message($player, Translation::getMessage("notCompleted", ["level" => 3]));
	    }
                break;
            	  case 4: 
	    if($player->hasPermission("complete4.use")){
            $this->MagicalPowerPage($player);
	 }else{
	    $this->getPlugin()->message($player, Translation::getMessage("notCompleted", ["level" => 4]));
	    }
                break; 
            	  case 5: 
	    if($player->hasPermission("complete5.use")){
            $this->UseWandPage($player);
	 }else{
	    $this->getPlugin()->message($player, Translation::getMessage("notCompleted", ["level" => 5]));
	    }
                break; 
            	  case 6: 
	    if($player->hasPermission("complete6.use")){
            $this->HomePage($player);
	 }else{
	    $this->getPlugin()->message($player, Translation::getMessage("notCompleted", ["level" => 6]));
	    }
                break; 
            	  case 7: 
	    if($player->hasPermission("complete7.use")){
            $this->CompletePage($player);
	 }else{
	    $this->getPlugin()->message($player, Translation::getMessage("notCompleted", ["level" => 7]));
	    }
                break; 
            }
	});
        $form->setTitle("§a§l-=Tutorial=-");
	$p = $player->getName();
	$form->setContent("§5Welcome to HogWarts§7: §b$p\n\nnselect below to start your wizarding experiance");
	$form->addButton($player->hasPermission("complete1.use") === true ? "§7[§8Get a Wand§7]\n§aCOMPLETED" : "§7[§8Get a Wand§7]\n§cINCOMPLETE");
	$form->addButton($player->hasPermission("complete2.use") === true ? "§7[§8Explore Hogwarts§7]\n§aCOMPLETED" : "§7[§8Explore Hogwarts§7]\n§cINCOMPLETE");
	$form->addButton($player->hasPermission("complete3.use") === true ? "§7[§8Warp§7]\n§aCOMPLETED" : "§7[§8Warp§7]\n§cINCOMPLETE");
	$form->addButton($player->hasPermission("complete4.use") === true ? "§7[§8Xp Level§7]\n§aCOMPLETED" : "§7[§8Xp Level§7]\n§cINCOMPLETE");
	$form->addButton($player->hasPermission("complete5.use") === true ? "§7[§8Magical Power§7]\n§aCOMPLETED" : "§7[§8Magical Power§7]\n§cINCOMPLETE");
	$form->addButton($player->hasPermission("complete6.use") === true ? "§7[§8Use Your Wand§7]\n§aCOMPLETED" : "§7[§8Use Your Wand§7]\n§cINCOMPLETE");
	$form->addButton($player->hasPermission("complete7.use") === true ? "§7[§8Set Home§7]\n§aCOMPLETED" : "§7[§8Set Home§7]\n§cINCOMPLETE");
	$form->addButton($player->hasPermission("complete8.use") === true ? "§7[§8Complete§7]\n§aCOMPLETED" : "§7[§8Complete§7]\n§cINCOMPLETE");
        $form->sendToPlayer($player);
    }

    public function WandPage(CommandSender $player) {
            $form = new SimpleForm(function (Player $player, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
               case 0: 
	    $this->getStore()->questGainWand($player, 5);
               break; 
            }
	});
        $form->setTitle("§a§l-=Wand=-");
	$form->setContent("§8To complete this mission you need to find Ollivanders wand shop in §bDiagon Alley§r\n\n§5Location of §bDiagon Ally§8(§lx:-332, y:4, z:103§r)");
        $form->addButton("§7[§aStart§7]");
        $form->sendToPlayer($player);
    }
//wand done
	
    public function ExplorePage(CommandSender $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
               case 0: 
	    $this->getStore()->checkPermission($player, "complete3.use", "§dExplore Howarts");
               break;
               case 1: 
	    $this->getStore()->questExplore($player, 81, -443);
               break; 
             }
	});
        $form->setTitle("§a§l-=Explore=-");
	$form->setContent("§7Travel to HogWarts\n\n§aStand on location §8(x:81, y:39, z:-443)§a and click on complete to finish");
        $form->addButton("§7[§aStart§7]");
        $form->addButton("§7[§cComplete§7]");
        $form->sendToPlayer($player);
    }
// explore done
	
    public function WarpPage(CommandSender $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
               case 0: 
			  if($player->hasPermission("complete3.use")) { 
			     $player->sendMessage("§7(§c!§7) §cYou have already completed §dWarp");
			  }else{
              		     $player->addTitle("§aCompleted Mission\n§dWarp");
			     $this->getPlugin()->setPermission($player, "complete3.use");
	 		     $player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
	 		     $player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY() + 0.5, $player->getZ())));
			     $this->sound($player);
    	 	    }
               break; 
	       }	
	});
        $form->setTitle("§a§l-=Warp=-");
	$form->setContent("§8To complete this mission just read the following\n\n§aTo gain warps you need to level up using xp\n\n §aWarps allow you to teleport to already learned locations. They are acquired from leveling up your wizarding skill");
        $form->addButton("§7[§aComplete§7]");
        $form->sendToPlayer($player);
    }
//warp done

    public function XpLevelPage(CommandSender $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
               case 0: 
	    $this->getStore()->questWarp($player);
               break;
	    }
        });
        $form->setTitle("§a§l-=XpLevel=-");
	$form->setContent("§8To complete this mission just read the following\n\n§aXp is also known as your wizarding skill as you levelup you gain more magical skills allowing you to become the best\n\n§8Gaining Xp: §aBy using your wand to fight off other wizards or evil creatures which lurk the magical world");
        $form->addButton("§7[§aComplete§7]");
        $form->sendToPlayer($player);
    }
//xplevel done
			       
    public function MagicalPowerPage(CommandSender $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
               case 0:  
	    $this->getStore()->questMp($player);
               break;
	    }
	});
        $form->setTitle("§a§l-=MagicalPower=-");
	$form->setContent("§8To complete this mission just read the following\n\n§aMp is known as your magical power it is how you cast spells with your wand\n\n§8Gaining Mp: §cMagical power is acquired from saving power");
        $form->addButton("§7[§aComplete§7]");
        $form->sendToPlayer($player);
    }
//mp done
			       
    public function UseWandPage(CommandSender $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
               case 0: 
	    $this->getStore()->questUseWand($player);
               break; 
	    }
	});
        $form->setTitle("§a§l-=UseWand=-");
	$form->setContent("§8To complete this mission just read the following and try out your wand\n\n§aMake sure to have mp it will be used according to what kind of wand you have\n\n§cMagical power is acquired from saving power, more power the wand the more power it requires");
        $form->addButton("§7[§aComplete§7]");
        $form->sendToPlayer($player);
    }
//use wand done
			       
    public function HomePage(CommandSender $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
               case 0: 
	    $this->getStore()->questHome($player);
               break; 
	       }		       
	});
        $form->setTitle("§a§l-=YourHome=-");
	$form->setContent("§8To complete this mission use the command §c/§7sethome and set your home to §c{§7slytherin§c}§c, §c{§7gryffindor§c}§c, §c{§7hufflepuff§c}§c, §c{§7ravenclaw§c}§c");
        $form->addButton("§7[§aComplete§7]");
        $form->sendToPlayer($player);
    }		       
    //set home done
	
    public function CompletePage(CommandSender $player) {
        $form = new SimpleForm(function (Player $player, $data){
        if ($data === null) {
            return;
            }
            switch ($data) {
               case 0: 
	    $this->getStore()->questComplete($player);
               break; 
            }
	});
        $form->setTitle("§a§l-=Complete=-");
	$form->setContent("§aYou have completed the tutorial\n\n§bYou can now start to level up your §dwizardry level §bnow good luck wizard enjoy your adventure");
        $form->addButton("§7[§aComplete§7]");
        $form->sendToPlayer($player);
    }
}
