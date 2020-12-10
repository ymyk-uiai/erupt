<?php

namespace Erupt\Interfaces;

interface Migrating
{
    public function getMigrationCommandSeeds($app);
}