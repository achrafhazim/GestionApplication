<?php

namespace Kernel\html\element\Form;

use Kernel\html\Components\Box_shadow;
use Kernel\html\element\Form\FormAbstract;
use Kernel\html\element\Form\input\Readonly;
use function implode;

class Form_view extends FormAbstract
{

    /**
     *
     * @return string
     */
    public function builder_form(): string
    {
        $form_grop = [];

        foreach ($this->inputs as $input) {
            $inputReadonly=new Readonly($input);

            $Panel = $this->style_Panel($inputReadonly);
            $form_grop[] = $Panel;
        }
        $content = implode(" ", $form_grop);

        return ( new Box_shadow("", $content, 16))->builder();
    }
}
