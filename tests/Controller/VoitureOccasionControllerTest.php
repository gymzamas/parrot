<?php

namespace App\Tests\Controller;

use App\Entity\VoitureOccasion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class VoitureOccasionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/voiture/occasion/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(VoitureOccasion::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('VoitureOccasion index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'voiture_occasion[nom]' => 'Testing',
            'voiture_occasion[prix]' => 'Testing',
            'voiture_occasion[anneeMiseEnCirculation]' => 'Testing',
            'voiture_occasion[kilometrage]' => 'Testing',
            'voiture_occasion[description]' => 'Testing',
            'voiture_occasion[imagePrincipale]' => 'Testing',
            'voiture_occasion[galerieImages]' => 'Testing',
            'voiture_occasion[equipementsOptions]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new VoitureOccasion();
        $fixture->setNom('My Title');
        $fixture->setPrix('My Title');
        $fixture->setAnneeMiseEnCirculation('My Title');
        $fixture->setKilometrage('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImagePrincipale('My Title');
        $fixture->setGalerieImages('My Title');
        $fixture->setEquipementsOptions('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('VoitureOccasion');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new VoitureOccasion();
        $fixture->setNom('Value');
        $fixture->setPrix('Value');
        $fixture->setAnneeMiseEnCirculation('Value');
        $fixture->setKilometrage('Value');
        $fixture->setDescription('Value');
        $fixture->setImagePrincipale('Value');
        $fixture->setGalerieImages('Value');
        $fixture->setEquipementsOptions('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'voiture_occasion[nom]' => 'Something New',
            'voiture_occasion[prix]' => 'Something New',
            'voiture_occasion[anneeMiseEnCirculation]' => 'Something New',
            'voiture_occasion[kilometrage]' => 'Something New',
            'voiture_occasion[description]' => 'Something New',
            'voiture_occasion[imagePrincipale]' => 'Something New',
            'voiture_occasion[galerieImages]' => 'Something New',
            'voiture_occasion[equipementsOptions]' => 'Something New',
        ]);

        self::assertResponseRedirects('/voiture/occasion/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getAnneeMiseEnCirculation());
        self::assertSame('Something New', $fixture[0]->getKilometrage());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getImagePrincipale());
        self::assertSame('Something New', $fixture[0]->getGalerieImages());
        self::assertSame('Something New', $fixture[0]->getEquipementsOptions());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new VoitureOccasion();
        $fixture->setNom('Value');
        $fixture->setPrix('Value');
        $fixture->setAnneeMiseEnCirculation('Value');
        $fixture->setKilometrage('Value');
        $fixture->setDescription('Value');
        $fixture->setImagePrincipale('Value');
        $fixture->setGalerieImages('Value');
        $fixture->setEquipementsOptions('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/voiture/occasion/');
        self::assertSame(0, $this->repository->count([]));
    }
}
