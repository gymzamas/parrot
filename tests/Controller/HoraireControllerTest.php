<?php

namespace App\Tests\Controller;

use App\Entity\Horaire;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HoraireControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/horaire/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Horaire::class);

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
        self::assertPageTitleContains('Horaire index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'horaire[Jour]' => 'Testing',
            'horaire[heureOuvertureMatin]' => 'Testing',
            'horaire[heureFermetureMatin]' => 'Testing',
            'horaire[heureOuvertureApresMidi]' => 'Testing',
            'horaire[heureFermetureApresMidi]' => 'Testing',
            'horaire[ferme]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Horaire();
        $fixture->setJour('My Title');
        $fixture->setHeureOuvertureMatin('My Title');
        $fixture->setHeureFermetureMatin('My Title');
        $fixture->setHeureOuvertureApresMidi('My Title');
        $fixture->setHeureFermetureApresMidi('My Title');
        $fixture->setFerme('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Horaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Horaire();
        $fixture->setJour('Value');
        $fixture->setHeureOuvertureMatin('Value');
        $fixture->setHeureFermetureMatin('Value');
        $fixture->setHeureOuvertureApresMidi('Value');
        $fixture->setHeureFermetureApresMidi('Value');
        $fixture->setFerme('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'horaire[Jour]' => 'Something New',
            'horaire[heureOuvertureMatin]' => 'Something New',
            'horaire[heureFermetureMatin]' => 'Something New',
            'horaire[heureOuvertureApresMidi]' => 'Something New',
            'horaire[heureFermetureApresMidi]' => 'Something New',
            'horaire[ferme]' => 'Something New',
        ]);

        self::assertResponseRedirects('/horaire/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getJour());
        self::assertSame('Something New', $fixture[0]->getHeureOuvertureMatin());
        self::assertSame('Something New', $fixture[0]->getHeureFermetureMatin());
        self::assertSame('Something New', $fixture[0]->getHeureOuvertureApresMidi());
        self::assertSame('Something New', $fixture[0]->getHeureFermetureApresMidi());
        self::assertSame('Something New', $fixture[0]->getFerme());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Horaire();
        $fixture->setJour('Value');
        $fixture->setHeureOuvertureMatin('Value');
        $fixture->setHeureFermetureMatin('Value');
        $fixture->setHeureOuvertureApresMidi('Value');
        $fixture->setHeureFermetureApresMidi('Value');
        $fixture->setFerme('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/horaire/');
        self::assertSame(0, $this->repository->count([]));
    }
}
