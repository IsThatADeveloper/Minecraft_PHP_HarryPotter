<?php

declare(strict_types = 1);

namespace harrypottercore\messages;

use pocketmine\utils\TextFormat;

class Translation implements Messages {


    public static function getMessage(string $identifier, array $args = []): string {
        $message = self::MESSAGE[$identifier];
        foreach($args as $arg => $value) {
            $message = str_replace("{" . $arg . "}", $value . TextFormat::RESET . TextFormat::GRAY, $message);
        }
        return (string)$message;
    }
}
