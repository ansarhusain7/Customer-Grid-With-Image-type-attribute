<?php
namespace Customer\ImageGrid\Ui\Component\Listing\Column;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

	
class Photo extends Column
{
	protected $customerFactory;

    private $_urlBuilder;

	public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
		\Magento\Customer\Model\CustomerFactory $customerFactory,
        UrlInterface $urlBuilder,
        array $components = [], array $data = [])
    {
		$this->customerFactory = $customerFactory;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    public function prepareDataSource(array $dataSource)
    {	
        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as & $item) {
				$customer = $this->customerFactory->create()->load($item["entity_id"]);
                //echo "<pre>"; print_r($customer->getData('utr_number')); die;
				$item[$this->getData('name')] = '<img src='.$this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).'customer'.$customer->getData('photo').'/>';
				
            }
        }
        return $dataSource;
    }
}