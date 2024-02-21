<?php

namespace harrypottercore\task\blocks;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\plugin\Plugin;

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

//level
use pocketmine\level\Level;
use pocketmine\level\LevelExpection;
use pocketmine\level\LevelProvider;
use pocketmine\level\ProviderManager;
use pocketmine\level\Position;

use pocketmine\block\BlockFactory;
use pocketmine\block\Block;

use pocketmine\utils\config;

use harrypottercore\Main;

class AddBlocksStageFiveTask extends PluginTask {

	private $player;
	private $plugin;

	public function __construct(Plugin $plugin, Player $player){
        $this->plugin = $plugin;
	$this->player = $player;
	}
   
	/*
	$stairdown = Block::get(Block::BRICK_STAIRS,1); //side up, face left
	$stairdown2 = Block::get(Block::BRICK_STAIRS,0); //side up, face right
	$stairdown4 = Block::get(Block::BRICK_STAIRS,4); //side down, face right
	$stairdown5 = Block::get(Block::BRICK_STAIRS,5); //side down, face left
	*/
   
	public function onRun(int $currentTick): void {
	       $pk = new PlaySoundPacket();
	       $pk->x = $this->player->getX();
	       $pk->y = $this->player->getY();
	       $pk->z = $this->player->getZ();
	       $pk->volume = 3;
	       $pk->pitch = 3;
	       $pk->soundName = 'crackle1.fsb';
	       $pk2 = new PlaySoundPacket();
	       $pk2->x = $this->player->getX();
	       $pk2->y = $this->player->getY();
	       $pk2->z = $this->player->getZ();
	       $pk2->volume = 2;
	       $pk2->pitch = 2;
	       $pk2->soundName = 'dig.gravel';
	       $this->player->dataPacket($pk);
	       $this->player->dataPacket($pk2);
	       $level = $this->plugin->getServer()->getLevelByName("HogWarts");
               $brick = BlockFactory::get(Block::BRICK_BLOCK);
               $stair = BlockFactory::get(Block::BRICK_STAIRS);
	       $stairdownl = Block::get(Block::BRICK_STAIRS,5);
	       $stairdownr = Block::get(Block::BRICK_STAIRS,4);
	       $stairupl = Block::get(Block::BRICK_STAIRS,1);
	       $stairupr = Block::get(Block::BRICK_STAIRS,0);
               $slab = Block::get(Block::STONE_SLAB,5); //brick slabs
               $air = BlockFactory::get(Block::AIR);
	       //top to bottom ->
	       //row 1
	       $pos1 = new Position(("-330"), (4), (117), $level); //brick
	       $pos2 = new Position(("-330"), (5), (117), $level); //stairupright
	       $pos3 = new Position(("-330"), (6), (117), $level); 
	       $pos4 = new Position(("-330"), (7.5), (117), $level); //slab
	       $pos5 = new Position(("-330"), (8), (117), $level); //stairupright
	       //row 2
	       $pos6 = new Position(("-331"), (4), (117), $level); //brick
	       $pos7 = new Position(("-331"), (5), (117), $level); //slab
	       $pos8 = new Position(("-331"), (6), (117), $level); 
	       $pos9 = new Position(("-331"), (7), (117), $level); 
	       $pos10 = new Position(("-331"), (8), (117), $level); //slab
	       //row 3
	       $pos11 = new Position(("-332"), (4), (117), $level); //slab
	       $pos12 = new Position(("-332"), (5), (117), $level);
	       $pos13 = new Position(("-332"), (6), (117), $level);
	       $pos14 = new Position(("-332"), (7), (117), $level);
	       $pos15 = new Position(("-332"), (8), (117), $level);
	       //row 4
	       $pos16 = new Position(("-333"), (4), (117), $level); //slab
	       $pos17 = new Position(("-333"), (5), (117), $level);
	       $pos18 = new Position(("-333"), (6), (117), $level);
	       $pos19 = new Position(("-333"), (7), (117), $level);
	       $pos20 = new Position(("-333"), (8), (117), $level);
	       //row 5
	       $pos21 = new Position(("-334"), (4), (117), $level); //slab
	       $pos22 = new Position(("-334"), (5), (117), $level);
	       $pos23 = new Position(("-334"), (6), (117), $level);
	       $pos24 = new Position(("-334"), (7), (117), $level);
	       $pos25 = new Position(("-334"), (8), (117), $level); //brick
	       //row 6
	       $pos26 = new Position(("-335"), (4), (117), $level); //brick
	       $pos27 = new Position(("-335"), (5), (117), $level); //slab
	       $pos28 = new Position(("-335"), (6), (117), $level);
	       $pos29 = new Position(("-335"), (7), (117), $level);
	       $pos30 = new Position(("-335"), (8), (117), $level); //stairdownleft
	       //particles
	       $level->addParticle(new SmokeParticle(new Vector3($pos1->getX(), $pos1->getY(), $pos1->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos2->getX(), $pos2->getY(), $pos2->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos3->getX(), $pos3->getY(), $pos3->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos4->getX(), $pos4->getY(), $pos4->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos5->getX(), $pos5->getY(), $pos5->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos6->getX(), $pos6->getY(), $pos6->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos7->getX(), $pos7->getY(), $pos7->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos8->getX(), $pos8->getY(), $pos8->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos9->getX(), $pos9->getY(), $pos9->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos10->getX(), $pos10->getY(), $pos10->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos11->getX(), $pos11->getY(), $pos11->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos12->getX(), $pos12->getY(), $pos12->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos13->getX(), $pos13->getY(), $pos13->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos14->getX(), $pos14->getY(), $pos14->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos15->getX(), $pos15->getY(), $pos15->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos16->getX(), $pos16->getY(), $pos16->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos17->getX(), $pos17->getY(), $pos17->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos18->getX(), $pos18->getY(), $pos18->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos19->getX(), $pos19->getY(), $pos19->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos20->getX(), $pos20->getY(), $pos20->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos21->getX(), $pos21->getY(), $pos21->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos22->getX(), $pos22->getY(), $pos22->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos23->getX(), $pos23->getY(), $pos23->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos24->getX(), $pos24->getY(), $pos24->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos25->getX(), $pos25->getY(), $pos25->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos26->getX(), $pos26->getY(), $pos26->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos27->getX(), $pos27->getY(), $pos27->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos28->getX(), $pos28->getY(), $pos28->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos29->getX(), $pos29->getY(), $pos29->getZ())));
	       $level->addParticle(new SmokeParticle(new Vector3($pos30->getX(), $pos30->getY(), $pos30->getZ())));
	       //row 1
	       $level->setBlock($pos1, $brick, true, true); //brick 
	       $level->setBlock($pos2, $stairupr, true, true); //stairupright
	       $level->setBlock($pos3, $air, true, true); 
	       $level->setBlock($pos4, $slab, true, true); //slab
	       $level->setBlock($pos5, $stairupr, true, true); //stairupright
	       //row 2
	       $level->setBlock($pos6, $brick, true, true); //brick
	       $level->setBlock($pos7, $slab, true, true); //slab
	       $level->setBlock($pos8, $air, true, true);
	       $level->setBlock($pos9, $air, true, true);
	       $level->setBlock($pos10, $slab, true, true); //slab
	       //row 3
	       $level->setBlock($pos11, $slab, true, true); //slab
	       $level->setBlock($pos12, $air, true, true);
	       $level->setBlock($pos13, $air, true, true);
	       $level->setBlock($pos14, $air, true, true);
	       $level->setBlock($pos15, $air, true, true); 
	       //row 4
	       $level->setBlock($pos16, $slab, true, true); //slab
	       $level->setBlock($pos17, $air, true, true);
	       $level->setBlock($pos18, $air, true, true);
	       $level->setBlock($pos19, $air, true, true);
	       $level->setBlock($pos20, $air, true, true);
	       //row 5
	       $level->setBlock($pos21, $slab, true, true); //slab
	       $level->setBlock($pos22, $air, true, true);
	       $level->setBlock($pos23, $air, true, true);
	       $level->setBlock($pos24, $air, true, true);
	       $level->setBlock($pos25, $brick, true, true); //brick
	       //row 6
	       $level->setBlock($pos26, $brick, true, true); //brick
	       $level->setBlock($pos27, $slab, true, true); //slab
	       $level->setBlock($pos28, $air, true, true);
	       $level->setBlock($pos29, $air, true, true);
	       $level->setBlock($pos30, $stairdownl, true, true); //stairdownleft
	}
}
