<?php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default datafixtures for the Product entity.
 * @package App\DataFixtures
 */
class ProductFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {

        $product1 = new Product();
        $product1->setName('PULSERA PERLAS DE PLATA GRIS');
        $product1->setDescription('Pulsera en plata de primera ley y perlas cultivadas patata 1 cm. Placa: 0,6 cm. Largo: 16 cm.');
        $product1->setCategory($this->getReference(CategoryFixtures::BRACELET_CATEGORY_REFERENCE));
        $product1->setPrice(55000);
        $product1->setPhoto('uploads/products/defaults/bracelets/pulsera-perlas-plata-gris.jpg');
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('PULSERA BOLAS NEGRAS');
        $product2->setDescription('Pulsera elástica de bolas de piedra en color negro.');
        $product2->setCategory($this->getReference(CategoryFixtures::BRACELET_CATEGORY_REFERENCE));
        $product2->setPrice(21000);
        $product2->setPhoto('uploads/products/defaults/bracelets/pulsera-negra-bolas.jpg');
        $manager->persist($product2);

        $prodcut3 = new Product();
        $prodcut3->setName('PULSERA NAZARETH');
        $prodcut3->setDescription('Pulsera elastizada de cuentas engomadas estampadas y cuentas de metal. Tiene una medalla de San Benito.');
        $prodcut3->setCategory($this->getReference(CategoryFixtures::BRACELET_CATEGORY_REFERENCE));
        $prodcut3->setPrice(42000);
        $prodcut3->setPhoto('uploads/products/defaults/bracelets/pulsera-nazareth.jpg');
        $manager->persist($prodcut3);

        $product4 = new Product();
        $product4->setName('MUG DRAGON BALL Z - GOKU TRASNFORMÁNDOSE - DARK EDTION');
        $product4->setDescription('Mug de Dragon Ball Z con Goku transformándose en saiyajin. Color Negro.');
        $product4->setCategory($this->getReference(CategoryFixtures::MUG_CATEGORY_REFERENCE));
        $product4->setPrice(15000);
        $product4->setPhoto('uploads/products/defaults/mugs/mug-dbz-goku-transforming-dark-edition.jpg');
        $manager->persist($product4);

        $product5 = new Product();
        $product5->setName('MUG IRON MAIDEN - THE NUMBER OF THE BEAST');
        $product5->setDescription('Mug del albúm The Number of the beast de banda Iron Maiden. Color Negro.');
        $product5->setCategory($this->getReference(CategoryFixtures::MUG_CATEGORY_REFERENCE));
        $product5->setPrice(25000);
        $product5->setPhoto('uploads/products/defaults/mugs/mug-iron-maiden-the-number-of-the-beast.jpg');
        $manager->persist($product5);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}