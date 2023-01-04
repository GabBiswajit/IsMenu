<?php

declare(strict_types=1);

namespace Biswajit\Utils;

use pocketmine\player\Player;

final class Utils

{

    public const PREFIX = " §e";

    public const VERSION = "3.2.0";

    public function resetNick(Player $sender): void

    {

        $sender->setDisplayName($sender->getName());

        $sender->setNameTag($sender->getName());

        $sender->sendMessage(Utils::PREFIX . "§eYour nickname has been reset!");

    }

}
