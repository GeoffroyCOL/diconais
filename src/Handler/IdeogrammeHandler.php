<?php

namespace App\Handler;

use App\Entity\Example;
use App\Entity\Ideogramme;

class IdeogrammeHandler
{
    public function addExamples(Ideogramme $ideogramme): void
    {
        $lists = $ideogramme->getExamples();
        foreach($lists as $key => $list) {
            $example = new Example();
            $example->setList($list);

            $ideogramme->addExample($example);
            $lists->removeElement($list);
        }
    }
}