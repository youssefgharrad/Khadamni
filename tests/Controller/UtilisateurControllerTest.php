<?php

namespace App\Test\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/utilisateur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Utilisateur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'utilisateur[nom]' => 'Testing',
            'utilisateur[prenom]' => 'Testing',
            'utilisateur[num]' => 'Testing',
            'utilisateur[adresse]' => 'Testing',
            'utilisateur[mdp]' => 'Testing',
            'utilisateur[description]' => 'Testing',
            'utilisateur[photo]' => 'Testing',
            'utilisateur[rate]' => 'Testing',
            'utilisateur[profession]' => 'Testing',
            'utilisateur[verified]' => 'Testing',
            'utilisateur[role]' => 'Testing',
            'utilisateur[ss]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setNum('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setMdp('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setRate('My Title');
        $fixture->setProfession('My Title');
        $fixture->setVerified('My Title');
        $fixture->setRole('My Title');
        $fixture->setSs('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setNum('Value');
        $fixture->setAdresse('Value');
        $fixture->setMdp('Value');
        $fixture->setDescription('Value');
        $fixture->setPhoto('Value');
        $fixture->setRate('Value');
        $fixture->setProfession('Value');
        $fixture->setVerified('Value');
        $fixture->setRole('Value');
        $fixture->setSs('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[nom]' => 'Something New',
            'utilisateur[prenom]' => 'Something New',
            'utilisateur[num]' => 'Something New',
            'utilisateur[adresse]' => 'Something New',
            'utilisateur[mdp]' => 'Something New',
            'utilisateur[description]' => 'Something New',
            'utilisateur[photo]' => 'Something New',
            'utilisateur[rate]' => 'Something New',
            'utilisateur[profession]' => 'Something New',
            'utilisateur[verified]' => 'Something New',
            'utilisateur[role]' => 'Something New',
            'utilisateur[ss]' => 'Something New',
        ]);

        self::assertResponseRedirects('/utilisateur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getNum());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getMdp());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPhoto());
        self::assertSame('Something New', $fixture[0]->getRate());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getVerified());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getSs());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setNum('Value');
        $fixture->setAdresse('Value');
        $fixture->setMdp('Value');
        $fixture->setDescription('Value');
        $fixture->setPhoto('Value');
        $fixture->setRate('Value');
        $fixture->setProfession('Value');
        $fixture->setVerified('Value');
        $fixture->setRole('Value');
        $fixture->setSs('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/utilisateur/');
        self::assertSame(0, $this->repository->count([]));
    }
}
