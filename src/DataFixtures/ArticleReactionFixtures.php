<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ArticleReaction;
use App\Repository\ArticleRepository;
use App\Repository\ReactionRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleReactionFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    private $articleRepository;
    private $userRepository;
    private $reactionRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository, ReactionRepository $reactionRepository)
    {
        $this->faker = Factory::create();
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->reactionRepository = $reactionRepository;
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->userRepository->findAll();
        $articles = $this->articleRepository->findAll();
        $reactions = $this->reactionRepository->findAll();
        $reactionCount = count($reactions);

        foreach ($articles as $article) {
            foreach ($users as $user) {
                $articleReaction = new ArticleReaction();
                $articleReaction->setUser($user);
                $articleReaction->setArticle($article);
                $articleReaction->setReaction($reactions[rand(0, $reactionCount - 1)]);
                $manager->persist($articleReaction);
            }
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ArticleFixtures::class,
            ReactionFixtures::class
        ];
    }
}
