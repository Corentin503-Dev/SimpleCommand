<?php

namespace Corentin503ST;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{
    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $config = $this->getConfig();

        foreach ($config->getAll()["commands"] as $command) {
            $name = strtolower($command["name"]);
            $description = $command["description"];
            $usage = strtolower($command["usage"]);
            $aliases = $command["aliases"];
            $permission = $command["permission"];
            $teleport = $command["teleport"];
            $transfer = $command["transfer"];
            $message = $command["message"];

            $no_perm_msg = str_replace("{command}", $name, $config->get("no_perm_message"));

            $command = new SimpleTeleportCommand($name, $description, $usage, $aliases, $permission, $teleport, $transfer, $message, $no_perm_msg);
            $this->getServer()->getCommandMap()->register("", $command);
        }
    }
}