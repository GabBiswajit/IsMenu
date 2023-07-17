<?php

namespace Biswajit;

use pocketmine\Server;
use pocketmine\player\Player;
use Biswajit\libs\Utils\Utils as Utils;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use Biswajit\libs\jojoe77777\FormAPI\CustomForm;
use Biswajit\libs\jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;

class Menu extends PluginBase implements Listener {
  
  public function onEnable() : void{
        $this->getLogger()->info("IslandMenu By Biswajit Is Enabled ✅");
  }
  
  public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch($command->getName()){
            case "sbui":
              if($sender->hasPermission("sbui.cmd")){
                $this->sbui($sender);
              } else {
                $sender->sendMessage("You Don't Have Permission To Use This Command");
              }
        }
        return true;
  }
  
  public function sbui(Player $player){
    $form = new SimpleForm(function (Player $player, $data) {
        $result = $data;
        if ($result === null) {
            return true;
        }
        switch ($result) {
        case 0:
            $this->iscreate($player);
        break;

        case 1:
            $this->getServer()->dispatchCommand($player, "is tp");
        break;

        case 2:
            $this->getServer()->dispatchCommand($player, "is visit");
        break;

        case 3:
            $name = $player->getName();
            Server::getInstance()->getCommandMap()->dispatch($player, "is delete \"$name\"");
        break;

        case 4:
            
        break;
      }
    });
    $form->setTitle("§l§cGENERAL SETTINGS");
    $form->addButton("§l§bCREATE ISLAND\n§l§d» §r§8Tap To Create", 1, "https://www.clipartmax.com/png/full/162-1624622_brenz-block-is-a-skyblock-minecraft-logo.png");
    $form->addButton("§l§bJOIN ISLAND\n§l§d» §r§8Tap To Join", 1, "https://www.clipartmax.com/png/full/162-1624622_brenz-block-is-a-skyblock-minecraft-logo.png");
    $form->addButton("§l§bVISIT ISLAND\n§l§d» §r§8Tap To Visit", 1, "https://www.clipartmax.com/png/full/162-1624622_brenz-block-is-a-skyblock-minecraft-logo.png");
    $form->addButton("§l§bDELETE ISLAND\n§l§d» §r§8Tap To Delete", 1, "https://www.clipartmax.com/png/full/162-1624622_brenz-block-is-a-skyblock-minecraft-logo.png");
    $form->addButton("§l§cBACK", 0, "textures/ui/icon_import");
    $form->sendToPlayer($player);
    return $form;
  }

    public function iscreate($player): Form
    {
        $form = new CustomForm(function(Player $player, array $data = null){
            if($data === null){
                return true;
            }
            if($data[0] == null){
                $player->sendMessage(Utils::PREFIX . "Island Name Cannot Be Empty!");
                return;
            }
            Server::getInstance()->getCommandMap()->dispatch($player, "is create $data[0]");
        });
        $form->setTitle("§l§2Create Island");
        $form->addInput(TextFormat::GREEN . "Type Your Island Name\n\nIsland Name Should Not Contain Spaces.\n", "Type String");
        $player->sendForm($form);
        return $form;
    }
}
