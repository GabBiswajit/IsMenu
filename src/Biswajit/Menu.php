<?php

namespace Biswajit;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use Vecnavium\FormsUI\CustomForm;
use Vecnavium\FormsUI\Form;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;

class Menu extends PluginBase implements Listener {
  
  public function onEnable() : void{
        $this->getLogger()->info("IslandMenu Is Enabled ✅");
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
    $form = new SimpleForm(function(Player $player, $data){
            
           if(is_null($data)){
            PluginUtils::PlaySound($player, "random.chestclosed", 1, 1);
              
              return true;
      }
      switch($data){
        case 0:
            $this->gs($player);
        break;

        case 1:
            $this->ps($player);
        break;
      }
    });
    $form->setTitle("§l§cSKYBLOCK SETTINGS");
    $form->setContent("§9Select The Next Menu For Open:");
    $form->addButton("§l§bGENERAL SETTINGS\n§l§d» §r§8Tap To Open", 1, "https://icons.iconarchive.com/icons/dtafalonso/android-lollipop/256/Settings-icon.png");
    $form->addButton("§l§bISLAND SETTINGS\n§l§d» §r§8Tap To Open", 1, "https://icons.iconarchive.com/icons/dtafalonso/android-lollipop/256/Settings-icon.png");
    $form->addButton("§l§cEXIT", 0, "textures/blocks/barrier");
    $form->sendToPlayer($player);
    return $form;
  }
  
  public function gs(Player $player){
    $form = new SimpleForm(function(Player $player, $data){
           
            if(is_null($data)){
              PluginUtils::PlaySound($player, "random.chestclosed", 1, 1);
              
              return true;
      }
      switch($data){
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
            $this->sbui($player);
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
  
  public function ps($player){
    $form = new SimpleForm(function(Player $player, $data){
           
         if(is_null($data)){
            PluginUtils::PlaySound($player, "random.chestclosed", 1, 1);
              
              return true;
      }
      switch($data){
        case 0:
            $this->getServer()->dispatchCommand($player, "is settings");
        break;

        case 1:
            $this->getServer()->dispatchCommand($player, "is leave");
        break;
              
        case 2:
            $this->getServer()->dispatchCommand($player, "is chat");
        break;

        case 3:
            $this->sbui($player);
        break;
      }
    });
    $form->setTitle("§l§cISLAND SETTINGS");
    $form->addButton("§l§bISLAND SETTINGS\n§l§d» §r§8Tap To Invite", 1, "https://pngimg.com/uploads/minecraft/minecraft_PNG63.png");
    $form->addButton("§l§bLEAVE ISLAND\n§l§d» §r§8Tap To Accept", 1, "https://pngimg.com/uploads/minecraft/minecraft_PNG63.png");
    $form->addButton("§l§bISLAND CHAT\n§l§d» §r§8Tap To Chat", 1, "https://pngimg.com/uploads/minecraft/minecraft_PNG63.png");
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
        $form->addInput("Type Your Island Name\n\nIsland Name Should Not Contain Spaces.\n", "Type String");
        $player->sendForm($form);
        return $form;
    }
}
