<?php

namespace Corentin503ST;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Location;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use pocketmine\permission\PermissionParser;
use pocketmine\player\Player;
use pocketmine\Server;

class SimpleTeleportCommand extends Command
{
    private string $teleport;

    private string $transfer;

    private string $message;

    private string $type;

    public function __construct(string $name, string $description, string $usage, array $aliases, string $permission, string $teleport, string $transfer, string $message, string $no_perm_msg)
    {
        parent::__construct($name, $description, $usage, $aliases);

        $this->teleport = $teleport;
        $this->transfer = $transfer;
        $this->message = $message;

        $this->setPermissionMessage($no_perm_msg);

        if ($permission !== "no" && $permission !== "") {
            PermissionManager::getInstance()->addPermission(new Permission($permission));
            $this->setPermission($permission);
        } $this->setPermission(DefaultPermissionNames::GROUP_USER);

        if ($teleport !== "no" && $teleport !== "") {
            $this->type = "teleport";
        } else $this->type = "transfer";
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            switch ($this->type) {
                case "teleport":
                    $explode = explode(":", $this->teleport);
                    $loc = new Location($explode[0], $explode[1], $explode[2], Server::getInstance()->getWorldManager()->getWorldByName($explode[3]), 0, 0);
                    $sender->teleport($loc);
                    break;
                case "transfer":
                    $explode = explode(":", $this->transfer);
                    $sender->transfer($explode[0], $explode[1]);
                    break;
            }
            $sender->sendMessage($this->message);
        }
    }
}