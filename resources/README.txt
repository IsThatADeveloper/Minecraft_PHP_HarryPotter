# Permissions just incase 
# are solid from version 5.0.0

| Permissions | Description | Default |
| --- | --- | --- |
| `can-use-xp` | Allows the player to collect xp | `after tutorial` |
| `complete[]->1-7` | Stages of tutorial | `during tutorial` |
| `magic[].use->1-22` | Wizarding stages/levels | `after tutorial` |
| `gma.use` | Change gamemode to a | `op` |
| `gmc.use` | Change gamemode to c | `op` |
| `gmspc.use` | Change gamemode to spc | `op` |
| `gms.use` | Change gamemode to s | `op` |
| `ravenclaw.use` | House of Ravenclaw | `op/default` |
| `slytherin.use` | House of Slytherin | `op/default` |
| `hufflepuff.use` | House of hufflepuff | `op/default` |
| `gryffindor.use` | House of gryffindor | `op/default` |
| `guest.use` | No house | `default` |
| `setxp.use` | set $player xp | `op` |
| `tinker.use` | allows the use of selling books | `op` |
| `getwand.use` | Tutorial mission 1 | `default set on start` |
| `wandshop.use` | Allows you to buy a wand | `op` |
| `day.use` | Set day | `op` |
| `feed.use` | Feed | `op` |
| `heal.use` | Heal | `op` |
| `jump.use` | Jump | `op` |
| `nv.use` | Nightvision | `op` |
| `night.use` | Set night | `op` |
| `speed.use` | Speed | `op` |
| `potion.use` | Potion crafter | `op` |
| `spawn.use` | Teleport to spawn | `op` |
| `ban.use` | Ban player | `op` |
| `kick.use` | Kick player | `op` |
| `whitelistremove.use` | Remove from whitelist | `op` |
| `whitelistadd.use` | Add to whitelist | `op` |
| `mute.use` | Mute player | `op` |
| `settag.permission.{tag}` | Permission for tags | `op` |
| `mute.use` | Mute player | `op` |

# ScoreBoard 
        \harrypottercore\utils\Scoreboard::new($player, 'harrypottercore', "§k§l§f-§r§cWizarding§3Mania§k§f§l-§r§l§f");

        \harrypottercore\utils\Scoreboard::setLine($player, 1, " " . "§7[§b" . $p . "§7]§r"); //player name
        \harrypottercore\utils\Scoreboard::setLine($player, 2, " " . "§8§l» ---- ");
        \harrypottercore\utils\Scoreboard::setLine($player, 3, " " . "§r§7[§3§lHogWarts Home§r§7]§1:"); //group 
	if($this->group == $guest) {
        \harrypottercore\utils\Scoreboard::setLine($player, 4, " " . "§7» §7" . $this->group);
	}elseif($this->group == $slytherin) {
        \harrypottercore\utils\Scoreboard::setLine($player, 4, " " . "§7» §a" . $this->group);
	}elseif($this->group == $gryffindor) {
        \harrypottercore\utils\Scoreboard::setLine($player, 4, " " . "§7» §6" . $this->group);
	}elseif($this->group == $hufflepuff) {
        \harrypottercore\utils\Scoreboard::setLine($player, 4, " " . "§7» §e" . $this->group);
	}elseif($this->group == $ravenclaw) {
        \harrypottercore\utils\Scoreboard::setLine($player, 4, " " . "§7» §b" . $this->group);
	}
        \harrypottercore\utils\Scoreboard::setLine($player, 5, " " . "§8§l» ---- ");
        \harrypottercore\utils\Scoreboard::setLine($player, 6, " " . "§7[§l§aWizarding Stats§r§7]§1:");
        \harrypottercore\utils\Scoreboard::setLine($player, 7, " " . "§7» §aLevel§7: §a" . $wizard);
        \harrypottercore\utils\Scoreboard::setLine($player, 8, " " . "§7» §aDefense§7: §a" . $defense);
        \harrypottercore\utils\Scoreboard::setLine($player, 9, " " . "§8§l» ----");
        \harrypottercore\utils\Scoreboard::setLine($player, 9, " " . "§7[§l§eEconomy Stats§r§7]§1:");
        \harrypottercore\utils\Scoreboard::setLine($player, 11, " " . "§7» §5MagicalPower§7: §5" . $mp);
        \harrypottercore\utils\Scoreboard::setLine($player, 13, " " . "§7» §aToken§7: §2" . $token);
        \harrypottercore\utils\Scoreboard::setLine($player, 14, " " . "§8§l» ---- ");
        \harrypottercore\utils\Scoreboard::setLine($player, 15, " " . "§dplay.§cWizarding§3Mania.§dtk");
