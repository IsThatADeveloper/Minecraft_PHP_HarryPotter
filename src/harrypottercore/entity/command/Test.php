<?php

namespace harrypottercore\entity\command;

use harrypottercore\Main;
use harrypottercore\messages\Translation;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\level\sound\PopSound;
use pocketmine\entity\Skin;
use pocketmine\entity\Entity;

//entities
use harrypottercore\entity\Magic;
use harrypottercore\entity\Golden;
use harrypottercore\entity\Bludger;
use harrypottercore\entity\Quaffle;
use harrypottercore\entity\Dragon;

class Test extends PluginCommand{

    private $owner;

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setPermission("test.use");
        $this->setDescription("Activates test entity");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender->hasPermission("test.use")) {
            if (!isset($args[0])) {
                $sender->sendMessage("§7(§c!§7) §cUsage §7/§ctest §7{§cgolden§7/§cquaffle§7/§cbludger§7/§cbroom§7/§cremove§7}");
                return false;
            }
            if ($args[0]) {
                switch (strtolower($args[0])) {
                    case 'golden':
        		    $this->spawnGolden($sender);
                        break;
                    case 'quaffle':
       	 		    $this->spawnQuaffle($sender);
                        break;
                    case 'bludger':
        		    $this->spawnBludger($sender);
                        break;
                    case 'remove':
           	 	    $level = $sender->getLevel();
			    $levelname = $level->getFolderName();
		   	    foreach($level->getEntities() as $entity) {
				    if($entity instanceof Entity) {
                      		    $entity->close(); 
            	    		    $sender->sendMessage("§7(§c!§7) §cCleared all mobs in " . $levelname);
				    }
			     }
                        break;
		}
	    }
        } else {
	    $this->getPlugin()->message(Translation::getMessage("noPermission"));
            return false;
        }
        return false;
    }
	
    /*public function spawnDragon(Player $player) : void {
        $nbt = Entity::createBaseNBT($player);
        $nbt->setTag($player->namedtag->getTag("Skin"));
        $dragonEntity = new Dragon($player->getLevel(), $nbt);
        $dragonEntity->setScale(0.2);
        $dragonEntity->spawnToAll();
    }*/
	
	
    public function spawnGolden(Player $player) : void {
        $nbt = Entity::createBaseNBT($player);
        $nbt->setTag($player->namedtag->getTag("Skin"));
        $goldenEntity = new Golden($player->getLevel(), $nbt);
        $image = imagecreatefrompng($this->getPlugin()->textureFolder . "golden.png");
        $bytes = "";
        $l = (int) @getimagesize($this->getPlugin()->textureFolder . "golden.png")[1];
        for ($y = 0; $y < $l; $y++) {
            for ($x = 0; $x < 64; $x++) {
                $rgba = @imagecolorat($image, $x, $y);
                $a = ((~((int)($rgba >> 24))) << 1) & 0xff;
                $r = ($rgba >> 16) & 0xff;
                $g = ($rgba >> 8) & 0xff;
                $b = $rgba & 0xff;
                $bytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        @imagedestroy($image);

        $goldenEntity->setSkin(new Skin("Golden", $bytes, "", "geometry.golden", file_get_contents($this->getPlugin()->textureFolder . "golden.json")));
        $goldenEntity->setScale(1);
        $goldenEntity->sendSkin();
        $goldenEntity->spawnToAll();
    }
	
    public function spawnQuaffle(Player $player) : void {
        $nbt = Entity::createBaseNBT($player);
        $nbt->setTag($player->namedtag->getTag("Skin"));
        $quaffleEntity = new Quaffle($player->getLevel(), $nbt);
        $image = imagecreatefrompng($this->getPlugin()->textureFolder . "quaffle.png");
        $bytes = "";
        $l = (int) @getimagesize($this->getPlugin()->textureFolder . "quaffle.png")[1];
        for ($y = 0; $y < $l; $y++) {
            for ($x = 0; $x < 64; $x++) {
                $rgba = @imagecolorat($image, $x, $y);
                $a = ((~((int)($rgba >> 24))) << 1) & 0xff;
                $r = ($rgba >> 16) & 0xff;
                $g = ($rgba >> 8) & 0xff;
                $b = $rgba & 0xff;
                $bytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        @imagedestroy($image);

        $quaffleEntity->setSkin(new Skin("Quaffle", $bytes, "", "geometry.quaffle", file_get_contents($this->getPlugin()->textureFolder . "quaffle.json")));
        $quaffleEntity->setScale(3);
        $quaffleEntity->sendSkin();
        $quaffleEntity->spawnToAll();
    }
	
    public function spawnBludger(Player $player) : void {
        $nbt = Entity::createBaseNBT($player);
        $nbt->setTag($player->namedtag->getTag("Skin"));
        $bludgerEntity = new Bludger($player->getLevel(), $nbt);
        $image = imagecreatefrompng($this->getPlugin()->textureFolder . "bludger.png");
        $bytes = "";
        $l = (int) @getimagesize($this->getPlugin()->textureFolder . "bludger.png")[1];
        for ($y = 0; $y < $l; $y++) {
            for ($x = 0; $x < 64; $x++) {
                $rgba = @imagecolorat($image, $x, $y);
                $a = ((~((int)($rgba >> 24))) << 1) & 0xff;
                $r = ($rgba >> 16) & 0xff;
                $g = ($rgba >> 8) & 0xff;
                $b = $rgba & 0xff;
                $bytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }
        @imagedestroy($image);

        $bludgerEntity->setSkin(new Skin("Bludger", $bytes, "", "geometry.bludger", file_get_contents($this->getPlugin()->textureFolder . "bludger.json")));
        $bludgerEntity->setScale(4);
        $bludgerEntity->sendSkin();
        $bludgerEntity->spawnToAll();
    }
}
