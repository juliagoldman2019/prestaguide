        <?php
        
        if(!class_exists('ModelTestimony'));
        require_once _PS_MODULE_DIR_.'testimony/classes/ModelTestimony.php';



        if (!defined('_PS_VERSION_')) {
            exit;
        }

        class Testimony extends Module
        {
            protected $config_form = false;

            public function __construct()
            {
                $this->name = 'Testimony';
                $this->tab = 'administration';
                $this->version = '0.0.1';
                $this->author = 'Hamaz';
                $this->need_instance = 0;

                $this->bootstrap = true;

                $this->tabs = array(
                  array('name'=>'Testimony Tabs', 'class_name'=>'ParentTestimony', 'parent'=>''),
                  array('name'=>'Testimony', 'class_name'=>'AdminTestimony', 'parent'=>'ParentTestimony'),
              );

                parent::__construct();

                $this->displayName = $this->l('Testimony');
                $this->description = $this->l('Desc pour Testimony Desc pour Testimony ');

                $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
            }

            

            public function install(){
               require _PS_MODULE_DIR_.'testimony/sql/install.php';
               return parent::install() &&
               $this->installTab(true) &&
               $this->installFolder() &&
               $this->registerHook('header') &&
               $this->registerHook('backOfficeHeader');
           }


           public function uninstall(){
               require _PS_MODULE_DIR_.'testimony/sql/uninstall.php';
               return parent::uninstall() && $this->installTab(false);;
           }


           public function installTab($install = true){
            if($install) {
                $languages = Language::getLanguages();

                foreach($this->tabs as $t){
                    $tab = new Tab();
                    $tab->module = $this->name;
                    $tab->class_name = $t['class_name'];
                    $tab->id_parent = Tab::getIdFromClassName($t['parent']);
                    foreach ($languages as $language){
                        $tab->name[$language['id_lang']] = $t['name'];
                    }
                    $tab->save();
                }
                return true;
            }else{
                foreach ($this->tabs as $t) {
                    $id = Tab::getIdFromClassName($t['parent']);
                    if($id){
                        $tab = new Tab($id);
                        $tab->delete();
                    }
                }

                return true;
            }
        }
        
        public function installFolder(){
            return mkdir(ModelTestimony::$img_dir, '0777');
        }

    }
