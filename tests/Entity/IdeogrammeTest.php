<?php

namespace App\Tests\Entity;

use App\Entity\Ideogramme;

abstract class IdeogrammeTest extends Entity
{
    private Ideogramme $entity;

    abstract public function getEntity(): Ideogramme;

    protected function setUp(): void
    {
        $this->entity = $this->getEntity();
    }

    /**
     * testKanji
     * Vérifie que le champs :
     *      - n'est pas vide
     *      - est unique
     */
    public function testGoodLogoKanji(): void
    {
        //Non vide
        $this->entity->setLogo('');
        $this->assertHasErrors($this->entity, 1);

        //Unique
        $this->entity->setLogo('皇');
        $this->assertHasErrors($this->entity, 1);

        //Good
        $this->entity->setLogo('改');
        $this->assertHasErrors($this->entity);
    }
    
    /**
     * testGoodSignification
     */
    public function testGoodSignification(): void
    {
        //Non vide
        $this->entity->setSignification('');
        $this->assertHasErrors($this->entity, 1);

        //Good
        $this->entity->setSignification('une signification');
        $this->assertHasErrors($this->entity);
    }
    
    /**
     * testGoodStroke
     * Vérifie que le nombre de traits:
     *      - ne peut pas être inférieur ou égale à 0
     */
    public function testGoodStroke(): void
    {
        //Strictement positif
        $this->entity->setStroke(-1);
        $this->assertHasErrors($this->entity, 1);

        //Strictement positif
        $this->entity->setStroke(10);
        $this->assertHasErrors($this->entity);
    }
    
    /**
     * testGoodRead
     */
    public function testGoodRead(): void
    {
        $this->assertHasErrors($this->entity);
        $this->entity
            ->setKun('')
            ->setReadOn('')
        ;
        $this->assertHasErrors($this->entity, 2);
    }
    
    /**
     * testGoodJlpt
     * jplt doit être contenue entre 1 et 5
     *
     * @return void
     */
    public function testGoodJlpt()
    {
        //Supérieur à 5
        $this->entity->setJlpt(9);
        $this->assertHasErrors($this->entity, 1);

        //Inférieur à 1
        $this->entity->setJlpt(0);
        $this->assertHasErrors($this->entity, 1);

        //Compris entre 1 et 5
        $this->entity->setJlpt(1);
        $this->assertHasErrors($this->entity);
    }
}