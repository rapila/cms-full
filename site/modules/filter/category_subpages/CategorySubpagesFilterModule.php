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

	public function onNavigationItemChildrenRequested($oNavigationItem) {
		if(!($oNavigationItem instanceof PageNavigationItem && $oNavigationItem->getIdentifier() === 'photos')) {
			return;
		}
		$aDocumentCategories = DocumentCategoryQuery::create()->filterByDocumentKind('image')->find();
		foreach($aDocumentCategories as $oDocumentCategory) {
			$oNavItem = new VirtualNavigationItem(get_class(), StringUtil::normalize($oDocumentCategory->getName()), $oDocumentCategory->getName(), null, $oDocumentCategory->getId());
			$oNavigationItem->addChild($oNavItem);
		}
	}

	public function onNavigationItemChildrenCacheDetectOutdated($oNavigationItem, $oCache, $aContainer) {
		$bIsOutdated = &$aContainer[0];
		if(!($oNavigationItem instanceof PageNavigationItem && $oNavigationItem->getIdentifier() === 'photos')) {
			return;
		}
		if($bIsOutdated) {
			return;
		}
		// Make sure the children are re-rendered when the items in the query are updated
		$bIsOutdated = $oCache->isOlderThan(DocumentQuery::create()->filterByDocumentKind('image')) || $oCache->isOlderThan(DocumentCategoryQuery::create()->filterByDocumentKind('image'));
	}
	
	public function onPageHasBeenSet($oPage, $bIsNotFound, $oNavigationItem) {
		if($bIsNotFound || !($oNavigationItem instanceof VirtualNavigationItem) || $oNavigationItem->getType() !== get_class()) {
			return;
		}
		$_REQUEST['document_category_id'] = $oNavigationItem->getData();
	}
}