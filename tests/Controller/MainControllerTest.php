<?php

namespace App\Tests\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomePageDisplaysForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testContactFormSubmission(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $client->submitForm('Envoyer', [
            'form[firstName]' => 'John',
            'form[name]' => 'Doe',
            'form[message]' => 'Test message',
        ]);

        $this->assertResponseRedirects('/');

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $contact = $em->getRepository(Contact::class)->findOneBy(['name' => 'Doe']);
        $this->assertNotNull($contact);
        $this->assertSame('new', $contact->getStatus());
    }

    public function testListPageWithSearch(): void
    {
        $client = static::createClient();
        $client->request('GET', '/liste/1', ['search' => 'Doe', 'status' => 'new']);

        $this->assertResponseIsSuccessful();
    }

    public function testLoginPageIsSuccessful(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');

        $this->assertResponseIsSuccessful();
    }

    public function testAdminRequiresAuthentication(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');

        $this->assertResponseRedirects();
    }
}