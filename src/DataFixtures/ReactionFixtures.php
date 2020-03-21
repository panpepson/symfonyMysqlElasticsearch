<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Reaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReactionFixtures extends Fixture
{
    private $reactionType = ['LIKE', 'HATE', 'LOVE', 'LAUGH'];

    public function load(ObjectManager $manager)
    {
        foreach ($this->reactionType as $type) {
            $reaction = new Reaction();
            $reaction->setName($type);
            $manager->persist($reaction);
        }
        $manager->flush();
    }
}