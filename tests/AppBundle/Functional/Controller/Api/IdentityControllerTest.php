<?php


namespace Tests\AppBundle\Functional\Controller\Api;


use AppBundle\Entity\AbstractIdentity;
use AppBundle\Routing\FormType\IdentityFormType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IdentityControllerTest extends WebTestCase
{
    public function testGetIdentitiesAction(): void
    {
        $client = self::createClient();

        $client
            ->request(
                'GET',
                'api/identities'
            );

        $this->assertSame(
            200,
            $client
                ->getResponse()
                ->getStatusCode()
        );

        $this->assertJson(
            $client
                ->getResponse()
                ->getContent()
        );
    }

    public function testDeleteIdentitiesAction():void {
        $client = self::createClient();

        $client
            ->request(
                'DELETE',
                'api/identities/1'
            );

        $this
            ->assertSame(
                200,
                $client
                ->getResponse()
                ->getStatusCode()
            );

        $this
            ->assertJson(
                $client
                ->getResponse()
                ->getContent()
            );

        $this
            ->assertStringContainsString(
                'deleted',
                $client
                ->getResponse()
                ->getContent()
            );
    }

    public function testPutIdentitiesAction(): void
    {
        $client = self::createClient();

        $client
            ->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(AbstractIdentity::class)
            ->find(5);

        $form = $client
            ->getContainer()
            ->get('form.factory')
            ->create(IdentityFormType::class);

        $client
            ->request(
                'PUT',
                '/api/identities/5',
                [

                    'name' => 'Pippo',
                    'surname' => 'Pluto',
                    'codiceFiscale' => 'PPOPLT23R19D245G',
                    'type' => 'natural',
                ]
            );
        $form->handleRequest($client->getRequest());
//        $this->assertTrue($form->isSubmitted());
//        $this->assertTrue($form->isValid());
//        TODO Why with put method the form is not valid and submitted too??

        $this->assertJson(
            $client
                ->getResponse()
                ->getContent()
        );
        $this->assertStringContainsString(
            'Identity updated',
            $client
                ->getResponse()
                ->getContent()
        );
    }

    public function testPostIdentityAction(): void
    {
        $client = self::createClient();

        $entityManager = $client
            ->getContainer()
            ->get('doctrine.orm.default_entity_manager');

        $oldIdentitiesNumber = count(
            $entityManager
                ->getRepository(AbstractIdentity::class)
                ->findAll()
        );

        $form = $client
            ->getContainer()
            ->get('form.factory')
            ->create(IdentityFormType::class);

        $client
            ->request(
                'POST',
                '/api/identities',
                [

                    'name' => 'Pippo',
                    'surname' => 'Pluto',
                    'codiceFiscale' => 'PPOPLT23R19D245G',
                    'type' => 'natural',
                ]
            );
        $form->handleRequest($client->getRequest());
        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isValid());

        $newIdentitiesNumber = count(
            $entityManager
                ->getRepository(AbstractIdentity::class)
                ->findAll()
        );

        $this->assertSame($oldIdentitiesNumber + 1, $newIdentitiesNumber);
        $this->assertStringContainsString('posted', $client->getResponse()->getContent());
    }
}
