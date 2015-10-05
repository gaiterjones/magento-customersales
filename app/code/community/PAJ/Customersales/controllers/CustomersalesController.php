<?php
class PAJ_Customersales_CustomersalesController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
    
	
	//echo $this->getFullActionName();
	
	$this->loadLayout()
        ->_title($this->__('Customer Sales by VAT ID'));

    
	$this->_addContent($this->getLayout()->createBlock('adminhtml/template')->setTemplate('paj/customersales/customersales.phtml'));
    
	$this->renderLayout();	
		
    }
}