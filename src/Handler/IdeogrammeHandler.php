<?php

namespace App\Handler;

use App\Entity\Example;
use App\Entity\Ideogramme;
use App\Handler\ExampleHandler;
use Doctrine\ORM\PersistentCollection;

class IdeogrammeHandler
{
    private array $oldListExamples = [];

    public function __construct(private ExampleHandler $exampleHandler)
    {}

    public function addExamples(Ideogramme $ideogramme): void
    {
        $lists = $ideogramme->getExamples();
        foreach($lists as $list) {
            $this->AddExampleInIdeogramme($ideogramme, $list);

            //Suppression dans element de ArrayCollection
            $lists->removeElement($list);
        }
    }
    
    public function editExamples(Ideogramme $ideogramme): void
    {
        //Récupération des liste de mots de l'idéogramme
        $this->oldListExamples = $this->exampleHandler->getExamplesByIdeogramme($ideogramme);

        //Récupération des listes envoyer pour la modification de l'idéogramme
        /** @var PersistentCollection $listIdeogrammes */
        $listIdeogrammes = $ideogramme->getExamples();
        $newListsExamples = $listIdeogrammes->unwrap()->toArray();

        foreach($newListsExamples as $key => $value) {
            if ($this->isArrayExamples($value)) {
                $ideogramme->getExamples()->remove($key);
            } else {
                $this->AddExampleInIdeogramme($ideogramme, $value);
                $ideogramme->getExamples()->remove($key);
            }
        }

        $this->deleteExamplesInIdeogramme();
    }

    public function deleteExample(Ideogramme $ideogramme): void
    {
        $this->oldListExamples = $this->exampleHandler->getExamplesByIdeogramme($ideogramme);
        $this->deleteExamplesInIdeogramme();
    }
    
    /**
     * isArrayExamples
     * Permet de déterminer si une valeur est déjà enregistrer et la supprime dans $this->oldListExamples
     *
     * @param  string $example
     * @return bool
     */
    private function isArrayExamples(string $example): bool
    {
        foreach ($this->oldListExamples as $key => $value) {
            if ($value->getList() == $example) {
                unset($this->oldListExamples[$key]);
                return true;
            }
        }

        return false;
    }
    
    /**
     * deleteExamplesInIdeogramme
     * Supprime une entité Example
     *
     * @return void
     */
    private function deleteExamplesInIdeogramme(): void
    {
        foreach ($this->oldListExamples as $example) {
            $this->exampleHandler->delete($example);
        }
    }
    
    /**
     * AddExampleInIdeogramme
     * Ajoute l'entité Example dans une Entité Ideogramme 
     */
    private function AddExampleInIdeogramme(Ideogramme $ideogramme, string $value): void
    {
        $example = new Example();
        $example->setList($value);
        $ideogramme->addExample($example);
    }
}