<?php
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default datafixtures for the Category entity.
 * @package App\DataFixtures
 */
class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{

    const BRACELET_CATEGORY_REFERENCE = 'bracelet-category';

    const MUG_CATEGORY_REFERENCE = 'mug-category';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $bracelet = new Category();
        $bracelet->setName('Pulseras');
        $bracelet->setDescription('Pulseras de cualquier material');
        $manager->persist($bracelet);

        $cup = new Category();
        $cup->setName('Pocillos decorados');
        $cup->setDescription('Pocillos decorados con variedad de dibujos y figuras.');
        $manager->persist($cup);

        $manager->flush();

        $this->addReference(self::BRACELET_CATEGORY_REFERENCE, $bracelet);
        $this->addReference(self::MUG_CATEGORY_REFERENCE, $cup);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}