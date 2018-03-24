<?php
declare(strict_types=1);

/*
 * @package    agitation/portal-bundle
 * @link       https://github.com/agitation/portal-bundle
 * @author     Alexander Günsche
 * @license    https://opensource.org/licenses/MIT
 */

namespace Agit\PortalBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('agit:portal:generate')
            ->setDescription('generate portal data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->getContainer()->get('agit.portal.processor')->execute();
    }
}
