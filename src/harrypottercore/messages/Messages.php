<?php

declare(strict_types = 1);

namespace harrypottercore\messages;

use harrpottercore\Main;
use pocketmine\utils\TextFormat;

interface Messages {

     const MESSAGE = [
        "cooldown" => self::RED . "Cooldown §5{seconds} §cseconds remaining",
        "basicTutorial" => self::RED . "You have not completed tutorial yet, do §7/§ctutorial",
        "noPermission" => self::RED . "You do not have permission to use this command",
        "canBeBought" => self::RED . "You do not have permission to use this command \n§bYou can buy this command here §a:: §6 https://mcpeprisonblock.buycraft.net/",
        "cannotBreak" => self::RED . "You cannot place anything here!",
        "cannotPlace" => self::RED . "You cannot break anything here!",
        //kills
        "playerDeath" => self::RED . "§e{player} §chas been killed by§e {killer} §cusing§r {item}",
        "broadcastDeath" => "{player} §chas been killed by§e {killer}",
        "gainToken" => self::GREEN . "You killed {player} and gained 1 token",
        //wands
        "cannotInteract" => self::RED . "You cannot interact with other objects while using spells",
        "noDefense" => self::YELLOW . "{prefix} {entityname} for 1 {suffix} {item}",
        "withDefense" => self::GREEN . "{prefix} {entityname} for {damage} {suffix} {item}",
        "healWand" => self::GREEN . "You healed yourself for {amount} hearts",
        //levelup
        "broadcastLevelUp" => self::WHITE . "{player} §fhas leveled their wizardry to §7[§3Level {nextlevel}§7]",
        "defenseUpgrade" => self::GREEN . "Your defense skill has increased to level {defense}",
        "defenseMax" => self::GREEN . "Your defense skill has increased to level Max",
        //potions
        "craftPotion" => self::GREEN . "You crafted a {potion}",
        "notEnoughMaterials" => self::RED . "You don't have the right ingredients to make a {potion}",
        "notCompletedTutorial" => self::RED . "To craft a {potion} you need to complete the tutorial",
        "consumed" => self::YELLOW . "Consumed {potion}",
        //gamemode
        "gamemode" => self::GREEN . "gamemode set to {type}",
        //wizarding home
        "noHome" => self::YELLOW . "You don't have a set house use the command §7/§csethome to set your hogwarts house",
        "setHome" => self::GREEN . "Your home has been set to§e {home}",
        //xp
        "xpSet" => self::GREEN . "You set§a {name}§a's xp to {amount}",
        "xpRemoved" => self::RED . "You removed {amount} from§c {player}§c's account",
        "xpSetTarget" => self::GREEN . "Your xp level was set to {amount} by {player}",
        "xpRemovedTarget" => self::RED . "{amount} xp was removed from your account by {player}",
        "levelSetTarget" => self::GREEN . "You set {player}'s wizarding level to {amount}",
        "levelRemovedTarget" => self::RED . "Your wizarding level is now set to {amount} by {player}",
        //tinker
        "notHoldingBook" => self::RED . "You're not holding a book",
        "soldBook" => self::GREEN . "You sold an enchanted book for {amount} tokens",
        //wandshop
        "purchaseFirstWand" => self::GREEN . "You have purchased your first wand for {amount} tokens",
        "purchaseWand" => self::GREEN . "You have purchased a wand for {amount} tokens",
        "notEnoughToken" => self::GREEN . "You do not have enough tokens to purchase a wand",
        //warps
        "notCreated" => self::YELLOW . "World has not been set yet",
        "playerWarping" => self::GREEN . "Warping...",
        "tutorialNotCompleted" => self::GREEN . "You need to complete tutorial to access warps",
        //essentials
        "setTime" => self::AQUA . "You set the time to {time}",
        "setHunger" => self::AQUA . "§2Your hunger is full", 
        "setHealth" => self::AQUA . "§dYour health is full",
        "deactivateBoost" => self::AQUA . "{boost} boost deactivated", 
        "activateBoost" => self::AQUA . "{boost} boost activated",
        //fly
        "flySet" => self::AQUA . "Fly has been enabled", 
        "flyRemoved" => self::RED . "Fly has been disabled", 
        "flySetTarget" => self::AQUA . "Fly has been enabled for {player}",
        "flyRemovedTarget" => self::RED . "Fly has been disabled for {player}",
        "notOnline" => self::YELLOW . "{player} is not online",
        //settings
        "setSound" => self::GREEN . "You turned your sound {type}",
        "scoreboardAdded" => self::GREEN . "You have added your scoreboard",
        "scoreboardRemoved" => self::GREEN . "You have removed your scoreboard",
        "clearedInventory" => self::GREEN . "Your inventory has been cleared",
        "setDefaultWizard" => self::GREEN . "Your house has been reset to default wizard",
        "wizardReset" => self::GREEN . "Your xp, xp progress and wizarding level has been reset",
        "mpReset" => self::GREEN . "Your magical power has been reset",
        "tokenReset" => self::GREEN . "Your tokens have been reset",
        //kit
        "noPermKit" => self::RED . "You don't have permission to use this kit",
        "claimKit" => self::AQUA . "You were given {kit} kit!!",
        //wand shop
        "purchaseWand" => self::GREEN . "You purchased {wand} for {amount}",
        "cantPurchaseWand" => self::RED . "You do not have enough tokens to purchase {wand} Wand",
        //spawn
        "setSpawn" => self::GREEN . "You set spawn in world§c {level} {x} {y} {z}",
        "spawnNotSet" => self::RED . "Spawn has not been set yet",
        "setLocation" => self::GREEN . "You set§c {area} {x} {y} {z}",
        //staff
        "broadcastBan" => self::RED . "{player} {type} {target} for {reason}", 
        "messageBan" => self::RED . "You successfully {type} {target} for {reason}",
        "whitelist" => self::GREEN . "{type} {player} from whitelist",
        "muteTarget" => self::RED . "You have been muted for {time} minutes by {player}",
        "mutePlayer" => self::GREEN . "You successfully muted {target} for {time}",
        "unmuteTarget" => self::GREEN . "You are no longer muted",
        "unmutePlayer" => self::AQUA . "{target} has been unmuted",
        "userNotMuted" => self::YELLOW . "{target} is not muted",
        //tags
        "noPermTag" => self::RED . "This tag is locked\n §bYou can buy this command here §a:: §6 https://mcpeprisonblock.buycraft.net/",
        "claimTag" => self::GREEN . "Your tag has been changed to {tag}",
        //tutorial
        "notCompleted" => self::RED . "You have not completed mission {level} yet",
        "tutorialCompleted" => self::AQUA . "You have already completed the tutorial",
        //get wands
        "allIngameItems" => self::AQUA . "You have gained all useable ingame items",
        //data
        "noStored" => self::RED . "You have not yet completed tutorial. You have no data file yet",
        "dataCurrupted" => self::RED . "Your data was corrupted. Your level has been set to your previous save"
    ];

    const RED = "§7(§c!§7)§r §c";

    const YELLOW = "§7(§e!§7)§r §c";
    
    const WHITE = "§7(§a!§7)§r §f";
    
    const GRAY = "§7(§8!§7)§r §7";

    const GREEN = "§7(§a!§7)§r §a";
    
    const AQUA = "§7(§3!§7)§r §3";
}
