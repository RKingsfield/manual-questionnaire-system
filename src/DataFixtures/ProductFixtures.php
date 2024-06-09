<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const PROD_SILDE_50 = 'prod-silde-50';
    public const PROD_SILDE_100 = 'prod-silde-100';
    public const PROD_TADAL_10 = 'prod-tadal-10';
    public const PROD_TADAL_20 = 'prod-tadal-20';

    public function load(ObjectManager $manager): void
    {
        $silde100 = (new Product())
          ->setName('Sildenafil 100mg');
        $silde50 = (new Product())
          ->setName('Sildenafil 50mg');
        $tadal10 = (new Product())
          ->setName('Tadalafil 10mg');
        $tadal20 = (new Product())
          ->setName('Tadalafil 20mg');
        $products = [$silde100, $silde50, $tadal10, $tadal20];

        foreach ($products as $product) {
            $manager->persist($product);
        }
        $manager->flush();

        $this->addReference(self::PROD_SILDE_50, $silde50);
        $this->addReference(self::PROD_SILDE_100, $silde100);
        $this->addReference(self::PROD_TADAL_10, $tadal10);
        $this->addReference(self::PROD_TADAL_20, $tadal20);
    }
}
