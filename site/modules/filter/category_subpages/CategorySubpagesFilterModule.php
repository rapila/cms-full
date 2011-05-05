<?php
/**
* @package modules.filter
*/
class CategorySubpagesFilterModule extends FilterModule {
	public function onNavigationPathFound(NavigationItem $oRoot, NavigationItem $oCurrent) {
		$oPhotos = $oRoot->namedChild('photos');
		if($oPhotos === null) {
			return;
		}
		$aDocumentCategories = DocumentCategoryQuery::create()->filterByDocumentKind('image')->find();
		foreach($aDocumentCategories as $oDocumentCategory) {
			$oNavItem = new VirtualNavigationItem(get_class(), StringUtil::normalize($oDocumentCategory->getName()), $oDocumentCategory->getName(), null, $oDocumentCategory->getId());
			$oPhotos->addChild($oNavItem);
		}
	}
	
	public function onPageHasBeenSet($oPage, $bIsNotFound, $oNavigationItem) {
		if($bIsNotFound || !($oNavigationItem instanceof VirtualNavigationItem) || $oNavigationItem->getIdentifier() !== get_class()) {
			return;
		}
		$_REQUEST['document_category_id'] = $oNavigationItem->getData();
	}
}