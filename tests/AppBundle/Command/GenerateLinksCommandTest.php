<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\GenerateLinksCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateLinksCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new GenerateLinksCommand());

        $command = $application->find('shorty:links:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'number' => 1
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('links generated', $output);
    }
}
