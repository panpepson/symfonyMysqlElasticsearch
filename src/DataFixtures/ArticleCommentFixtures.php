<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\ArticleComment;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleCommentFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    private $articleRepository;
    private $userRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->faker = Factory::create();
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->userRepository->findAll();
        $articles = $this->articleRepository->findAll();

        foreach ($articles as $article) {
            foreach ($users as $user) {
                for ($i = 0; $i < rand(1, 4); $i++) {
                    $articleComment = new ArticleComment();
                    $articleComment->setUser($user);
                    $articleComment->setArticle($article);
                    $articleComment->setContent($this->faker->text);
                    $manager->persist($articleComment);
                }
                $manager->flush();
            }
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ArticleFixtures::class
        ];
    }
}