<?php

//
// modman clone https://github.com/gaiterjones/magento-customersales.git
//


class PAJ_Customersales_CustomersalesController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
    
	
	//echo $this->getFullActionName();
	
	$this->loadLayout()
		->_setActiveMenu('sales')
        ->_title($this->__('Customer Sales by VAT ID'));

    
	$this->_addContent($this->getLayout()->createBlock('adminhtml/template')->setTemplate('paj/customersales/customersales.phtml'));
    
	$this->renderLayout();	
		
    }
}