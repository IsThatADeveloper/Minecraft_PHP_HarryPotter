<?php

namespace harrypottercore\texture;

use harrypottercore\Main;
use pocketmine\network\mcpe\RakLibInterface;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;

class Packet implements Listener{

    private $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
	
    public function getPlugin(){
	return $this->plugin;
    }
  
  public function enablePackets(): void {
        foreach ($this->plugin->getServer()->getNetwork()->getInterfaces() as $interface) {
            if($interface instanceof RakLibInterface) {
                $interface->setPacketLimit(PHP_INT_MAX);
                break;
            }
        }
  }
}
