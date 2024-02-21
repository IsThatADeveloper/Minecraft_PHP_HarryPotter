<?php

namespace harrypottercore\commands\cmd;

use harrypottercore\Main;
use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
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
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use harrypottercore\messages\Translation;

class Myhouse extends PluginCommand{

    private $owner;
	
    public $group; 

    public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->owner = $owner;
        $this->setDescription("Shows your information about your house");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
    $this->group = $this->getPlugin()->getServer()->getPluginManager()->getPlugin("PurePerms")->getUserDataMgr()->getGroup($sender)->getName();
       $guest = "Guest";
       $slytherin = "Slytherin";
       $gryffindor = "Gryffindor";
       $hufflepuff = "Hufflepuff";
       $ravenclaw = "Ravenclaw";
    if($this->group === $guest){
            $this->getPlugin()->message($sender, Translation::getMessage("noHome"));
    }elseif($this->group === $slytherin){
            $this->Slytherin($sender);
    }elseif($this->group === $gryffindor){
            $this->Gryffindor($sender);
    }elseif($this->group === $hufflepuff){
            $this->Hufflepuff($sender);
    }elseif($this->group === $ravenclaw){
            $this->Ravenclaw($sender);
    	    }
    }
	
    public function Slytherin(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
                break;  
            }
            }
        );
        $form->setTitle("§a§l-=Slytherin=-");
	$form->setContent("§2§lSlytherin§r\n\n§bTag: §2Slytherin\n\n§cAbout: §2Slytherin §7is one of the four Houses at Hogwarts School of Witchcraft and Wizardry, founded by Salazar Slytherin\n\n§5Ablities: §a");
        $form->addButton("§7[§c§lEXIT§7]");
        $form->sendToPlayer($sender);
    }
	
    public function Gryffindor(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
                break;  
            }
            }
        );
        $form->setTitle("§a§l-=Gryffindor=-");
	$form->setContent("§6§lGryffindor§r\n\n§bTag: §6Gryffindor\n\n§cAbout: §6Gryffindor §7is one of the four Houses at Hogwarts School of Witchcraft and Wizardry, founded by Godric Gryffindor\n\n§5Ablities: §a");
        $form->addButton("§7[§c§lEXIT§7]");
        $form->sendToPlayer($sender);
    }
	
    public function Hufflepuff(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
                break;  
            }
            }
        );
        $form->setTitle("§a§l-=HufflePuff=-");
	$form->setContent("§2§lHufflePuff§r\n\n§bTag: §eHufflePuff\n\n§cAbout: §eHufflepuff §7is one of the four Houses at Hogwarts School of Witchcraft and Wizardry, founded by Helga Hufflepuff\n\n§5Ablities: §a");
        $form->addButton("§7[§c§lEXIT§7]");
        $form->sendToPlayer($sender);
    }
	
    public function Ravenclaw(CommandSender $sender)
    {
        if(!($sender instanceof Player)){
                return true;
            }
        $form = new SimpleForm(function (Player $sender, $data){
            if ($data === null) {
                return;
            }
            switch ($data) {
            	case 0: 
                break;  
            }
            }
        );
        $form->setTitle("§a§l-=RavenClaw=-");
	$form->setContent("§bRavenClaw§r\n\n§bTag: §bRavenClaw\n\n§cAbout: §bRavenClaw §7is one of the four Houses at Hogwarts School of Witchcraft and Wizardry, founded by Rowena Ravenclaw\n\n§5Ablities: §a");
        $form->addButton("§7[§c§lEXIT§7]");
        $form->sendToPlayer($sender);
    }
	
    public function getHome(Player $player) { 
	    return $this->group;
    }
}
	    
