<?php
/**
 * Sample Prestashop Module
 *
 * Module declaration
 *
 * @author Hhennes - https://www.h-hennes.fr/blog/
 *
 */
class samplemodule extends Module
{

    public function __construct()
    {
        $this->author = 'hhennes';
        $this->name = 'samplemodule';
        $this->tab = 'hhennes';
        $this->version = '0.1.0';
        $this->need_instance = 0;
        $this->controllers = ['sample'];

        parent::__construct();

        $this->displayName = $this->l('Prestashop sample Module');
        $this->description = $this->l('Prestashop sample Module with front controller');
    }

    /**
     * Installation du module
     */
    public function install()
    {
        return parent::install();
    }

    /**
     * Désinstalation du module
     */
    public function uninstall()
    {
        return parent::uninstall();
    }

}
