<?php

namespace harrypottercore\task;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\scheduler\Task as PluginTask;
use pocketmine\plugin\Plugin;

use pocketmine\utils\config;

use harrypottercore\Main;
use harrypottercore\messages\Translation;

class RespawnUpdateTask extends PluginTask {

	private $player;
	private $plugin;

	public function __construct(Plugin $plugin, Player $player){
        $this->plugin = $plugin;
	$this->player = $player;
	}
	
	public function onRun(int $currentTick): void {
		$pk = new LevelEventPacket();
		$pk->evid = LevelEventPacket::EVENT_PARTICLE_SPAWN;
		$pk->data = 0;
		$pk->position = $this->player->asVector3();
		$this->player->dataPacket($pk);
	  	$config = new Config($this->plugin->playerFolder . $this->player->getLowerCaseName() . ".yml", Config::YAML);
	        $xp =  $this->plugin->getXpLevel($this->player, (int) $config->get("levelxp"));
	        $xpprogress =  $this->plugin->getXpProgress($this->player, (int) $config->get("xpprogress"));
		$wizard = $this->plugin->getLevel($this->player, (int) $config->get("level"));
   	        $this->player->setXpLevel($xp);
   	        $this->player->setXpProgress($xpprogress);
		//backup
		if($xp === 0 and $wizard === 0) {
		   $this->plugin->message($player, Translation::getMessage("noStored"));
   	           $this->player->setXpLevel(0);
		}elseif($xp === 0 and $wizard >= 0) {
			$this->player->setXpLevel($wizard * 5);
			$this->plugin->message($player, Translation::getMessage("dataCurrupted"));
		}
	}
}
