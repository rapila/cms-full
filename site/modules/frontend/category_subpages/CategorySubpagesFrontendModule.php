<?php
/**
 * @package modules.frontend
 */
class CategorySubpagesFrontendModule extends DynamicFrontendModule {
	private $iCategoryId = null;
	
	public function __construct($oLanguageObject, $aRequestPath = null) {
		if(isset($_REQUEST['document_category_id'])) {
			$this->iCategoryId = $_REQUEST['document_category_id'];
		}
		parent::__construct($oLanguageObject, $aRequestPath);
	}

	public function renderFrontend() {
		$oCriteria = DocumentQuery::create()->filterByDocumentKind('image');
		if(!Session::getSession()->isAuthenticated()) {
			$oCriteria->filterByIsProtected(false);
		}
		if($this->iCategoryId !== null) {
			$oCriteria->filterByDocumentCategoryId($this->iCategoryId);
		}
		$aDocuments = $oCriteria->find();
		$sTemplateName = 'helpers/gallery';
		
		try {
			$oListTemplate = new Template($sTemplateName);
			foreach($aDocuments as $i => $oDocument) {
				$oItemTemplate = new Template($sTemplateName.DocumentListFrontendModule::LIST_ITEM_POSTFIX);
				$oItemTemplate->replaceIdentifier('model', 'Document');
				$oDocument->renderListItem($oItemTemplate);
				$oListTemplate->replaceIdentifierMultiple('items', $oItemTemplate);
			}
		} catch(Exception $e) {
			$oListTemplate = new Template("", null, true);
		}
		
		return $oListTemplate;
	}

	public function renderBackend() {
		return null;
	}

	public function getSaveData() {
		return "";
	}
}