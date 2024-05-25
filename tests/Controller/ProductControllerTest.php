<?php

namespace App\Test\Controller;

use App\DataFixtures\AppFixtures;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/product/';

    private $databaseTool;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Product::class);

        // Get the database tool service
        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

         // Load the fixtures
        $this->databaseTool->loadFixtures([AppFixtures::class]);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product index');

        // Perform additional assertions
        // Example: Check if the number of products listed matches the number of fixtures loaded
        self::assertCount(10, $crawler->filter('.product-item'));

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());

        // Check if specific text is present
        for ($i = 1; $i <= 10; $i++) {
            self::assertSelectorTextContains('.product-item', 'Product ' . $i);
        }
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'product[name]' => 'Testing',
            'product[description]' => 'Testing',
            'product[price]' => 'Testing',
            'product[quantity]' => 'Testing',
            'product[image]' => 'Testing',
            'product[is_featured]' => 'Testing',
            'product[is_active]' => 'Testing',
            'product[meta_title]' => 'Testing',
            'product[meta_description]' => 'Testing',
            'product[slug]' => 'Testing',
            'product[feature_image]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setQuantity('My Title');
        $fixture->setImage('My Title');
        $fixture->setIsFeatured('My Title');
        $fixture->setIsActive('My Title');
        $fixture->setMetaTitle('My Title');
        $fixture->setMetaDescription('My Title');
        $fixture->setSlug('My Title');
        $fixture->setFeatureImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setPrice('Value');
        $fixture->setQuantity('Value');
        $fixture->setImage('Value');
        $fixture->setIsFeatured('Value');
        $fixture->setIsActive('Value');
        $fixture->setMetaTitle('Value');
        $fixture->setMetaDescription('Value');
        $fixture->setSlug('Value');
        $fixture->setFeatureImage('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'product[name]' => 'Something New',
            'product[description]' => 'Something New',
            'product[price]' => 'Something New',
            'product[quantity]' => 'Something New',
            'product[image]' => 'Something New',
            'product[is_featured]' => 'Something New',
            'product[is_active]' => 'Something New',
            'product[meta_title]' => 'Something New',
            'product[meta_description]' => 'Something New',
            'product[slug]' => 'Something New',
            'product[feature_image]' => 'Something New',
        ]);

        self::assertResponseRedirects('/product/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getQuantity());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getIs_featured());
        self::assertSame('Something New', $fixture[0]->getIs_active());
        self::assertSame('Something New', $fixture[0]->getMeta_title());
        self::assertSame('Something New', $fixture[0]->getMeta_description());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getFeature_image());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setPrice('Value');
        $fixture->setQuantity('Value');
        $fixture->setImage('Value');
        $fixture->setIsFeatured('Value');
        $fixture->setIsActive('Value');
        $fixture->setMetaTitle('Value');
        $fixture->setMetaDescription('Value');
        $fixture->setSlug('Value');
        $fixture->setFeatureImage('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/product/');
        self::assertSame(0, $this->repository->count([]));
    }
}
