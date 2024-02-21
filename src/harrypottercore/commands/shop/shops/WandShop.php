<?php

namespace harrypottercore\commands\shop\shops;

use harrypottercore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;
use onebone\tokenapi\TokenAPI;
use pocketmine\math\Vector3;

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

class WandShop extends PluginCommand{

    private $owner;
	
    private $price;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("wandshop.use");
        $this->setDescription("Wand Shop");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission($this->getPermission()) and $sender instanceof Player){
	   if($sender->hasPermission("getwand.use")){
	      $this->getPlugin()->setPermission($sender, "getwand.use");
	      $this->getPlugin()->unsetPermission($sender, "complete1.use");
   	      $sender->getInventory()->setItem(1, Item::get(262, 7, 1)->setCustomName("§aBasic Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 2\n§5Attack Speed§8:§c 2"]));
              TokenAPI::getInstance()->reduceToken($sender, $this->getPrice());
              $sender->addTitle("§aCompleted Mission\n§dGet a Wand");   
              $this->getPlugin()->message($sender, Translation::getMessage("purchaseFirstWand", ["amount" => $this->getPrice()]));
	      $this->background($sender);   
	   }elseif(!$sender->hasPermission("getwand.use")){
	   	   if(\pocketmine\Server::getInstance()->getPluginManager()->getPlugin("TokenAPI")->myToken($sender) >= ($this->getPrice())){												
            	      TokenAPI::getInstance()->reduceToken($sender, $this->getPrice());
	    	      $sender->getInventory()->setItem(1, Item::get(262, 7, 1)->setCustomName("§aBasic Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 2\n§5Attack Speed§8:§c 2"]));
	  	      $this->getPlugin()->message($sender, Translation::getMessage("purchaseWand", ["amount" => $this->getPrice()]));
	          } else {
	  	      $this->getPlugin()->message($sender, Translation::getMessage("notEnoughToken"));
            	      }
                  } else {
            	     $sender->sendMessage("§cYou do not have permission to use this command"); //perm
	   }
	}
    }
	
    public function background(Player $player) { 
		$player->getLevel()->addParticle(new ExplodeParticle(new Vector3($player->getX(), $player->getY(), $player->getZ())));
		$player->getLevel()->addParticle(new EnchantmentTableParticle(new Vector3($player->getX(), $player->getY(), $player->getZ())));
		$pk = new PlaySoundPacket();
		$pk->x = $player->getX();
		$pk->y = $player->getY();
		$pk->z = $player->getZ();
		$pk->volume = 3;
		$pk->pitch = 2;
		$pk->soundName = 'random.explode2';
		$pk2 = new PlaySoundPacket();
		$pk2->x = $player->getX();
		$pk2->y = $player->getY();
		$pk2->z = $player->getZ();
		$pk2->volume = 3;
		$pk2->pitch = 2;
		$pk2->soundName = 'random.use_totem';
		$player->dataPacket($pk);
		$player->dataPacket($pk2); 
    }
	
    public function getPrice(): int { 
	$this->price = 5;
	return $this->price;
    }
}
