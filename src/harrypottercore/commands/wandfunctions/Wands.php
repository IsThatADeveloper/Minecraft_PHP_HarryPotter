<?php

namespace harrypottercore\commands\wandfunctions;

use harrypottercore\Main;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
//item
use pocketmine\item\Item;
//events
use pocketmine\event\player\PlayerInteractEvent;
//nbts
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
//level
use pocketmine\level\Position\getLevel;
use pocketmine\level\Level;
//Others
use pocketmine\math\Vector3;
use pocketmine\command\PluginCommand;

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

class Wands extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("wands.use");
    }
    
  public function execute(CommandSender $player, string $commandLabel, array $args)
  {
    if($player->hasPermission("wands.use")) {
    $this->giveItems($player);
    }else{ 
        $this->getPlugin()->message($player, Translation::getMessage("noPermission"));
    }
  }
    
  public function giveItems($player) {
    $player->sendPopup(Translation::getMessage("allIngameItems"));
    $p = $player->getName();
    $player->getInventory()->clearAll();
    $player->getInventory()->setItem(0, Item::get(262, 34, 1)->setCustomName("§aElder Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 10\n§5Attack Speed§8:§c 10"]));
    $player->getInventory()->setItem(1, Item::get(262, 7, 1)->setCustomName("§aBasic Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 2\n§5Attack Speed§8:§c 2"]));
    $player->getInventory()->setItem(2, Item::get(262, 17, 1)->setCustomName("§aCrimson Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 4\n§5Attack Speed§8:§c 4"]));
    $player->getInventory()->setItem(3, Item::get(262, 26, 1)->setCustomName("§aDeathEater Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 5\n§5Attack Speed§8:§c 8"]));
    $player->getInventory()->setItem(4, Item::get(262, 10, 1)->setCustomName("§aRon's Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 6\n§5Attack Speed§8:§c 8"]));
    $player->getInventory()->setItem(5, Item::get(262, 22, 1)->setCustomName("§aHermione's Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 8\n§5Attack Speed§8:§c 6"]));
    $player->getInventory()->setItem(6, Item::get(262, 8, 1)->setCustomName("§aHarryPotter's Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 10\n§5Attack Speed§8:§c 9"]));
    $player->getInventory()->setItem(7, Item::get(262, 37, 1)->setCustomName("§aPhoenix Wand")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 0\n§5Attack Speed§8:§c 12"]));
    $player->getInventory()->setItem(8, Item::get(35, 14, 1)->setCustomName("§cBack"));
    $player->getInventory()->setItem(9, Item::get(290, 0, 1)->setCustomName("Nimbus 2000")->setLore(["§8[§eRight-Click§8] §aTo use\n§5Damage§8:§c 0\n§5Attack Speed§8:§c 12"]));
    $player->getInventory()->setItem(10, Item::get(373,27,1)->setCustomName("§8Skele-Gro §aP§bo§at§bi§ao§bn")->setLore(["§8Skele-Gro §aP§bo§at§bi§ao§bn"]));
    $player->getInventory()->setItem(11, Item::get(373,36,1)->setCustomName("§0Draught of Living Death")->setLore(["§0Draught of Living Death"]));
    $player->getInventory()->setItem(12, Item::get(403, 0, 1)->setCustomName("$p's §dWizarding Book"));
  }
}
