<?php declare(strict_types=1);

namespace AppBundle\DataFixtures;

use AppBundle\Entity\AbstractIdentity;
use AppBundle\Entity\Event;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEvent extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var AbstractIdentity $organizer1 */
        $organizer1 = $manager->getRepository(AbstractIdentity::class)->find(5);
        $event1 = new Event(
            'Santiago Bernabeu',
            new DateTime(),
            'Finale Champions League',
            100000,
            'description',
            $organizer1,
            new ArrayCollection([$organizer1])
        );
        $manager->persist($event1);

        /** @var AbstractIdentity $organizer2 */
        $organizer2 = $manager->getRepository(AbstractIdentity::class)->find(7);
        $event2 = new Event(
            'Santiago Bernabeu',
            new DateTime(),
            'Finale Champions League',
            100000,
            'description',
            $organizer2,
            new ArrayCollection([$organizer2, $organizer1])
        );
        $manager->persist($event2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            LoadIdentity::class,
        );
    }
}
