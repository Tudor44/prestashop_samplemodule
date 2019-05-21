<?php
/**
 * 2002-2018 ADVISA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is available
 * through the world-wide-web at this URL: http://www.opensource.org/licenses/OSL-3.0
 * If you are unable to obtain it through the world-wide-web, please send an email
 * to mage@advisa.fr so we can send you a copy immediately.
 *
 * @author ADVISA
 * @copyright 2002-2018 ADVISA
 * @license http://www.opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

require_once _PS_MODULE_DIR_ . '/samplemodule/classes/Sample.php';

class AdminHhSampleController extends ModuleAdminController
{

    /**
     * Instanciation de la classe
     * Définition des paramètres basiques obligatoires
     */
    public function __construct()
    {
        $this->bootstrap = true; //Gestion de l'affichage en mode bootstrap
        $this->table = Sample::$definition['table']; //Table de l'objet
        $this->identifier = Sample::$definition['primary']; //Clé primaire de l'objet
        $this->className = Sample::class; //Classe de l'objet
        $this->lang = true; //Flag pour dire si utilisation de langues ou non

        //Appel de la fonction parente pour pouvoir utiliser la traduction ensuite
        parent::__construct();

        //Liste des champs de l'objet à afficher dans la liste
        $this->fields_list = [
            'id_sample' => [ //nom du champ sql
                'title' => $this->module->l('ID'),
                'align' => 'center',
                'class' => 'fixed-width-xs'
            ],
            'name' => [
                'title' => $this->module->l('name'),
                'align' => 'left',
            ],
            'code' => [
                'title' => $this->module->l('code'),
                'align' => 'left',
            ],
            'email' => [
                'title' => $this->module->l('email'),
                'align' => 'left',
            ],
            'title' => [
                'title' => $this->module->l('title'),
                'lang' => true,
                'align' => 'left',
            ]
        ];

        //Ajout d'action sur chaque ligne
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        /**
         * Ajout d'actions de masses
         */
        $this->bulk_actions = [
            'delete' => [
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            ],
            'status' => [
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            ],
        ];

        /**
         * Gestion des options
         * Lors de la sauvegarde des options, les clés des options sont enregistrée dans la table de configuration
         */
        $this->fields_options = [
            //Groupe d'option n 1
            'general' => [
                //Titre du groupe d'options
                'title' => $this->l('General configuration'),
                //Champs du group d'options
                'fields' => [
                    //Exemple option de type texte
                    'OPTION_KEY_TEXT' => [ //La clé du tableau correspond au nom de la configuration
                        'title' => $this->l('Field Text'),
                        'hint' => $this->l('Field Text Hint'),
                        'validation' => 'isWeightUnit', //Classe de validation ( de la classe Validate )
                        'required' => true, //Champ requis ou non
                        'type' => 'text', //Type de champ
                        'class' => 'fixed-width-sm' //classe css
                    ],
                    //Exemple option de type texte avec langue
                    'OPTION_KEY_TEXT_LANG' => [
                        'title' => $this->l('Field Text Lang'),
                        'hint' => $this->l('Field Text Lang Hint'),
                        'validation' => 'isWeightUnit',
                        'required' => true,
                        'type' => 'textLang', //Type de champ
                        'class' => 'fixed-width-sm'
                    ],
                    //Exemple option de type textarea
                    'OPTION_KEY_TEXTAREA' => [
                        'title' => $this->l('Field Textarea'),
                        'hint' => $this->l('Field Textarea Hint'),
                        'required' => true,
                        'type' => 'textarea',
                        'cols' => 150, //Champ requis Textarea
                        'rows' => 2 // Champ requis Textarea
                    ],
                    //Exemple option de type textarea lang
                    'OPTION_KEY_TEXTAREA_LANG' => [
                        'title' => $this->l('Field Textarea Lang'),
                        'hint' => $this->l('Field Textarea Hint'),
                        'required' => true,
                        'type' => 'textareaLang',
                        'cols' => 150, //Champ requis Textarea
                        'rows' => 2 // Champ requis Textarea
                    ],
                    //Exemple option de type textarea avec TinyMce
                    'OPTION_KEY_TEXTAREA_MCE' => [
                        'title' => $this->l('Field Textarea editor'),
                        'hint' => $this->l('Field Textarea editor Hint'),
                        'required' => true,
                        'type' => 'textarea',
                        'autoload_rte' => true ,//Flag pour afficher l'éditeur de texte
                        'cols' => 150, //Champ requis Textarea
                        'rows' => 2 // Champ requis Textarea
                    ],
                    //Exemple d'option de type "select"
                    'OPTION_KEY_SELECT' => [
                        'title' => $this->l('Sample select fields'),
                        'hint' => $this->l('This is a select field.'),
                        'cast' => 'intval', //Cast appliqué aux valeurs
                        'type' => 'select',
                        'identifier' => 'id_lang', //Champs requis select clé de l'identifiant
                        'list' => Language::getLanguages(false) //Champ requis select source des données
                    ],
                    //Exemple d'option de type boolean
                    'OPTION_KEY_BOOLEAN' => [
                        'title' => $this->l('Bolean Field'),
                        'hint' => $this->l('Bolean Field Hint'),
                        'validation' => 'isBool',
                        'cast' => 'intval',
                        'type' => 'bool',
                        'default' => '1' //Valeur défaut pour l'option boolean
                    ],
                    //Exemple d'option de type file
                    'OPTION_KEY_FILE' => [
                        'title' => $this->l('File Field'),
                        'hint' => $this->l('File Field Hint'),
                        'type' => 'file',
                        'name' => 'OPTION_KEY_FILE' //Champ requis file
                    ],
                    //Exemple d'option de type file avec un thumb
                    'OPTION_KEY_THUMB' => [
                        'title' => $this->l('Thumb Field'),
                        'hint' => $this->l('Thumb Field Hint'),
                        'type' => 'file',
                        'name' => 'OPTION_KEY_FILE',
                        'thumb' => 'https://upload.wikimedia.org/wikipedia/commons/e/ee/Thumbup.jpg' //Champ requis thumb
                    ],
                    //Exemple d'option de type color
                    'OPTION_KEY_COLOR' => [
                        'title' => $this->l('Color Field'),
                        'hint' => $this->l('Color Field Hint'),
                        'validation' => 'isColor',
                        'type' => 'color',
                        'name' => 'OPTION_KEY_COLOR', // Champs requis Color
                        'size' => 7, //CHamps requis Color
                    ],

                ],
                //Bouton de soumission
                'submit' => ['title' => $this->l('Save')]
            ],
            //Groupe d'option n'2
            'localization' => [
                'title' => $this->l('Option bloc 2'),
                'icon' => 'icon-globe',
                'fields' => [
                    'OPTION_KEY_TEXT_2' => [
                        'title' => $this->l('Field Text'),
                        'hint' => $this->l('Field Text Hint'),
                        'validation' => 'isWeightUnit',
                        'required' => true,
                        'type' => 'text',
                        'class' => 'fixed-width-sm'
                    ],
                ],
                'submit' => ['title' => $this->l('Save')]
            ],
        ];
    }

    /**
     * Affichage du formulaire d'ajout / création de l'objet
     * @return string
     * @throws SmartyException
     */
    public function renderForm()
    {
        //Définition du formulaire d'édition
        $this->fields_form = [
            //Entête
            'legend' => [
                'title' => $this->module->l('Edit Sample'),
                'icon' => 'icon-cog'
            ],
            //Champs
            'input' => [
                [
                    'type' => 'text', //Type de champ
                    'label' => $this->module->l('name'), //Label
                    'name' => 'name', //Nom
                    'class' => 'input fixed-width-sm', //classes css
                    'size' => 50, //longueur maximale du champ
                    'required' => true, //Requis ou non
                    'empty_message' => $this->l('Please fill the postcode'), //Message d'erreur si vide
                    'hint' => $this->module->l('Enter sample name') //Indication complémentaires de saisie
                ],
                [
                    'type' => 'text',
                    'label' => $this->module->l('code'),
                    'name' => 'code',
                    'class' => 'input fixed-width-sm',
                    'size' => 5,
                    'required' => true,
                    'empty_message' => $this->module->l('Please fill the code'),
                ],
                [
                    'type' => 'text',
                    'label' => $this->module->l('email'),
                    'name' => 'email',
                    'class' => 'input fixed-width-sm',
                    'size' => 5,
                    'required' => true,
                    'empty_message' => $this->module->l('Please fill email'),
                ],
                [
                    'type' => 'text',
                    'label' => $this->module->l('Title'),
                    'name' => 'title',
                    'class' => 'input fixed-width-sm',
                    'lang' => true, //Flag pour utilisation des langues
                    'required' => true,
                    'empty_message' => $this->l('Please fill the title'),
                ],
                [
                    'type' => 'textarea',
                    'label' => $this->module->l('Title'),
                    'name' => 'description',
                    'lang' => true,
                    'autoload_rte' => true, //Flag pour éditeur Wysiwyg
                ],
            ],
            //Boutton de soumission
            'submit' => [
                'title' => $this->l('Save'), //On garde volontairement la traduction de l'admin par défaut
            ]
        ];
        return parent::renderForm();
    }


    /**
     * General / Gestion de la toolbar / Gestion des boutons de la toolbar
     */
    public function initPageHeaderToolbar()
    {

        //Bouton d'ajout ( standard )
        $this->page_header_toolbar_btn['new'] = array(
            'href' => self::$currentIndex . '&add' . $this->table . '&token=' . $this->token,
            'desc' => $this->module->l('Add new Sample'),
            'icon' => 'process-icon-new'
        );

        //Ajout d'un bouton qui appelle une fonction du controller
        //La fonction appellée sera process{Action} => donc ProcessCustom
        $this->page_header_toolbar_btn['custom_button'] = array(
            'href' => self::$currentIndex . '&token=' . $this->token . '&action=custom',
            'desc' => $this->module->l('Custom button'),
            'icon' => 'process-icon-configure'
        );

        parent::initPageHeaderToolbar();
    }

    /**
     * General / Gestion de la toolbar / Gestion du titre
     * Affichage d'un titre personnalisé
     */
    public function initToolbarTitle()
    {
        parent::initToolbarTitle();

        switch ($this->display) {
            case '':
            case 'list':
                array_pop($this->toolbar_title);
                $this->toolbar_title[] = $this->module->l('Custom Title for sample listing');
                break;
            case 'add':
            case 'edit':
                array_pop($this->toolbar_title);
                if (($sample = $this->loadObject(true)) && Validate::isLoadedObject($sample)) {
                    $this->toolbar_title[] = sprintf($this->module->l('Editing sample %s'), $sample->name);
                } else {
                    $this->toolbar_title[] = $this->module->l('Creating a new sample');
                }
                break;
        }
    }

    /**
     * Action spécifique pour le controller
     */
    public function processCustom()
    {
        dump('custom Action called by the button toolbar');
    }
}