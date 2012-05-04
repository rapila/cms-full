<?php
/**
* class CategorySubpagesFilterModule
* description:
* • add document categories as virtual navigation items to page tree
* • advantage: full_page cache
* • the page where CategorySubpages is configured requires additionally the identifier to be "photos"
* 
* @package modules.filter
*/
class CategorySubpagesFilterModule extends FilterModule {

	public function onNavigationItemChildrenRequested(NavigationItem $oCurrent) {
		if(!($oCurrent instanceof PageNavigationItem && $oCurrent->getIdentifier() === 'photos')) {
			return;
		}
		$aDocumentCategories = DocumentCategoryQuery::create()->filterByDocumentKind('image')->find();
		foreach($aDocumentCategories as $oDocumentCategory) {
			$oNavItem = new VirtualNavigationItem(get_class(), StringUtil::normalize($oDocumentCategory->getName()), $oDocumentCategory->getName(), null, $oDocumentCategory->getId());
			$oCurrent->addChild($oNavItem);
		}
	}
	
	public function onPageHasBeenSet($oPage, $bIsNotFound, $oNavigationItem) {
		if($bIsNotFound || !($oNavigationItem instanceof VirtualNavigationItem) || $oNavigationItem->getType() !== get_class()) {
			return;
		}
		$_REQUEST['document_category_id'] = $oNavigationItem->getData();
	}
}