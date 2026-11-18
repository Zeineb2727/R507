<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $date = new \DateTimeImmutable('2026-01-01');

        $contact = (new Contact())
            ->setFirstName('John')
            ->setName('Doe')
            ->setMessage('Hello')
            ->setCreatedAt($date)
            ->setStatus('new');

        $this->assertNull($contact->getId());
        $this->assertSame('John', $contact->getFirstName());
        $this->assertSame('Doe', $contact->getName());
        $this->assertSame('Hello', $contact->getMessage());
        $this->assertSame($date, $contact->getCreatedAt());
        $this->assertSame('new', $contact->getStatus());
    }

    public function testNewContactIsEmpty(): void
    {
        $contact = new Contact();

        $this->assertNull($contact->getFirstName());
        $this->assertNull($contact->getStatus());
    }
}