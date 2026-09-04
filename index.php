<?php

use SkillDo\Support\Path;

class Popup
{
    public function active(): void
    {
        \Popup\Services\ActivatorService::activate();
    }

    public function uninstall(): void
    {
        \Popup\Services\DeactivatorService::uninstall();
    }
}