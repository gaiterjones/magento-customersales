<?php
class PAJ_Customersales_Helper_Data extends Mage_Core_Helper_Abstract
{
	
	 /**
     * Configuration 
     */
    const PAJ_CUSTOMERSALES_FROM = '2015-01-01';
	const PAJ_CUSTOMERSALES_TO = '2015-02-01';
	
	public function getCustomerByVATID($_storeID=0)
	{
	
		$_collection = Mage::getModel('customer/customer')
				->getCollection()
				->addAttributeToSelect('firstname')
				->addAttributeToSelect('lastname')
				->addAttributeToSelect('email')
				->addAttributeToSelect('taxvat');

		$_result = array();
		foreach ($_collection as $_customer) {
			$_result[] = $_customer->toArray();
		}
		
		return ($_result);
	
	}
	
	public function getCustomerSales($_customerId,$fromDate,$toDate)
	{

		
		$fromDate = date('Y-m-d H:i:s', strtotime($fromDate));
		$toDate = date('Y-m-d H:i:s', strtotime($toDate));
		
		$orderCollection = Mage::getModel('sales/order')->getCollection()
			->addFilter('customer_id', $_customerId)
			->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
			->setOrder('created_at', Varien_Data_Collection_Db::SORT_ORDER_DESC)
		;
		$numberOfOrders = $orderCollection->count();
		$newestOrder = $orderCollection->getFirstItem();

		$orderCollection->clear()->getSelect()
			->columns(array('total_sales'=>'SUM(main_table.base_grand_total)'))
			->group('customer_id')
		;
		$totalSales = $orderCollection->getFirstItem()
			->getData('total_sales');		
		
		return array('customersales' => $totalSales);
		
	}

	public function getDataHeader()
	{
	
		$_header = array();

		array_push($_header,'customer_id');
		array_push($_header,'name');
		array_push($_header,'email');
		array_push($_header,'vat_id');
		array_push($_header,'total_sales');	
		
		return ($_header);
	}

	public function getTotalSales($_collection)
	{
		$_data=array();
		
		foreach ($_collection as $_customer)
		{
			$_customerData=array();
			
			if (strlen($_customer['taxvat']) > 2)
			{

				$_sales=self::getCustomerSales($_customer['entity_id'],self::PAJ_CUSTOMERSALES_FROM,self::PAJ_CUSTOMERSALES_TO);
				
				if($_sales['customersales'] > 0)
				{
					array_push($_customerData,$_customer['entity_id']);
					array_push($_customerData,$_customer['firstname']. ' '. $_customer['lastname']);
					array_push($_customerData,$_customer['email']);
					array_push($_customerData,$_customer['taxvat']);
					array_push($_customerData,number_format($_sales['customersales'],2));
					$_data[]=$_customerData;
				}
				
			}
		}
		
		return ($_data);
	}
}    