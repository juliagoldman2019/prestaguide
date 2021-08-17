	<?php

	class AdminTestimonyController extends ModuleAdminController
	{

		public function __construct()
		{
			$this->table = 'testimony';
			$this->className = 'ModelTestimony';
			$this->lang = true;
			$this->bootstrap = true;

			$this->deleted = false;
			$this->allow_export = true;
			$this->list_id = 'testimony';
			$this->identifier = 'id_testimony';
			$this->_defaultOrderBy = 'name';
			$this->_defaultOrderWay = 'ASC';
			$this->context = Context::getContext();

			$this->fieldImageSettings = array(
				'name' => 'logo',
				'dir' => 'testimony'
			);

			$this->addRowAction('edit');
			$this->addRowAction('delete');

			$this->bulk_actions = array(
				'delete' => array(
					'text' => $this->l('Delete selected'),
					'icon' => 'icon-trash',
					'confirm' => $this->l('Delete selected items?')
				)
			);
			$this->fields_list = array(
				'id_testimony'=>array(
					'title' => $this->l('ID'),
					'align'=>'center',
					'class'=>'fixed-width-xs'
				),
				'logo' => array(
					'title' => $this->l('Logo'),
					'image' => 'testimony',
					'orderby' => false,
					'search' => false,
					'align' => 'center',
				),
				'name'=>array(
					'title'=>$this->l('Name'),
					'width'=>'auto'
				),
				'description' => array(
					'title' => $this->l('Description'),
					'width' =>'auto'
				),
				'active' => array(
					'title' => $this->l('Enabled'),
					'active' =>'status',
					'type' =>'bool',
					'align' =>'center',
					'class' =>'fixed-width-xs',
					'orderby' => false,
				)
			);
			parent::__construct();
		}



		public function renderForm()
		{
			if (!($testimony = $this->loadObject(true))) {
				return;
			}

			$image = ModelTestimony::$img_dir.$testimony->id.'.jpg';
			$image_url = ImageManager::thumbnail($image, $this->table.'_'.(int)$testimony->id.'.'.$this->imageType, 350,
				$this->imageType, true, true);
			$image_size = file_exists($image) ? filesize($image) / 1000 : false;

			$this->fields_form = array(
				'tinymce' => true,
				'legend' => array(
					'title' => $this->l('Testimonies'),
					'icon' => 'icon-certificate'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Name'),
						'name' => 'name',
						'col' => 4,
						'required' => true,
						'hint' => $this->l('Invalid characters:').' <>;=#{}'
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('Description'),
						'name' => 'description',
						'lang' => true,
						'cols' => 60,
						'rows' => 10,
						'col' => 6,
						'autoload_rte'=>true,
						'hint' => $this->l('Invalid characters:').' <>;=#{}'
					),
					array(
						'type' => 'file',
						'label' => $this->l('Logo'),
						'name' => 'logo',
						'image' => $image_url ? $image_url : false,
						'size' => $image_size,
						'display_image' => true,
						'col' => 6,
						'hint' => $this->l('Upload a testimony logo from your computer.')
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Enable'),
						'name' => 'active',
						'required' => false,
						'class' => 't',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('Disabled')
							)
						)
					)
				)
			);

			if (!($testimony = $this->loadObject(true))) {
				return;
			}

			$this->fields_form['submit'] = array(
				'title' => $this->l('Save')
			);

			foreach ($this->_languages as $language) {
				$this->fields_value['description_'.$language['id_lang']] = htmlentities(stripslashes($this->getFieldValue(
					$testimony,
					'description',
					$language['id_lang']
				)), ENT_COMPAT, 'UTF-8');
			}

			return parent::renderForm();
		}

		public function l($string, $class = null, $addslashes = false, $htmlentities = true){
        if(_PS_VERSION_ >= '1.7'){
            return Context::getContext()->getTranslator()->trans($string);
        }else{
            return parent::l($string, $class, $addslashes, $htmlentities);
        }
    }

	}