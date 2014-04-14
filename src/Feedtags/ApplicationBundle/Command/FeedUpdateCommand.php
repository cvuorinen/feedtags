<?php

namespace Feedtags\ApplicationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FeedUpdateCommand
 *
 * @package Feedtags\ApplicationBundle\Command
 */
class FeedUpdateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('feedtags:feeds:update')
            ->setDescription('Update all feeds by fetching new items');
    }

    /**
     * Update all feeds
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $feedService = $this->getContainer()->get('feedtags_application.feed');

        $updated = $feedService->updateAllFeeds();

        $output->writeln('Updated ' . $updated . ' feeds');

        return 0;
    }
}
