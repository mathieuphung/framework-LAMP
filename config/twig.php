<?php
namespace Config;

class Twig
{
    public $twig;
    public $template;

    public function __construct($template)
    {
        $loader = new \Twig_Loader_Filesystem('../application/views/'); // Dossier contenant les templates
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => false
        ));
        $this->template = $this->twig->loadTemplate($template);
    }

    public function render(array $array) {
        echo $this->template->render($array);
    }
}