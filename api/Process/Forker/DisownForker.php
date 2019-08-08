<?php

declare(strict_types=1);

/*
 * This file is part of Contao Manager.
 *
 * (c) Contao Association
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao\ManagerApi\Process\Forker;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DisownForker extends AbstractForker
{
    /**
     * {@inheritdoc}
     */
    public function run(string $configFile): void
    {
        $commandline = sprintf(
            'exec %s %s >/dev/null 2>&1 </dev/null & disown',
            implode(' ', array_map([$this, 'escapeArgument'], $this->command)),
            $this->escapeArgument($configFile)
        );

        $this->startCommand($commandline);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported(): bool
    {
        try {
            Process::fromShellCommandline("exec echo '' & disown")->mustRun(null, $this->env);
        } catch (ProcessFailedException $e) {
            return false;
        }

        return true;
    }
}
