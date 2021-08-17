<?php

class ModelTestimony extends ObjectModel
{
   public $name;
   public $active = true;
   public $description;

   public static $img_dir = _PS_IMG_DIR_.'testimony';

 /**
  * @see ObjectModel::$definition
  */
 public static $definition = array(
   'table' => 'testimony',
   'primary' => 'id_testimony',
   'multilang' => true,
   'fields' => array(
       'name' => array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true,
           'size' => 255),
       'active' => array('type' => self::TYPE_BOOL),
       'description' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'),
   ),
);
}