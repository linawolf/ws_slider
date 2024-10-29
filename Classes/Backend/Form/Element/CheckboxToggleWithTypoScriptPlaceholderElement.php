<?php
declare(strict_types=1);

namespace WapplerSystems\WsSlider\Backend\Form\Element;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use WapplerSystems\WsSlider\Service\TypoScriptService;

/**
 * Generation of TCEform elements of the type "check"
 */
class CheckboxToggleWithTypoScriptPlaceholderElement extends AbstractFormElement
{

    /**
     * Default field information enabled for this element.
     *
     * @var array
     */
    protected $defaultFieldInformation = [
        'tcaDescription' => [
            'renderType' => 'tcaDescription',
        ],
    ];

    /**
     * Default field wizards enabled for this element.
     *
     * @var array
     */
    protected $defaultFieldWizard = [
        'localizationStateSelector' => [
            'renderType' => 'localizationStateSelector',
        ],
        'otherLanguageContent' => [
            'renderType' => 'otherLanguageContent',
            'after' => [
                'localizationStateSelector'
            ],
        ],
        'defaultLanguageDifferences' => [
            'renderType' => 'defaultLanguageDifferences',
            'after' => [
                'otherLanguageContent',
            ],
        ],
    ];


    public function __construct(readonly private TypoScriptService $typoScriptService)
    {

    }

    /**
     * This will render a checkbox or an array of checkboxes
     *
     * @return array As defined in initializeResultArray() of AbstractNode
     */
    public function render(): array
    {
        $resultArray = $this->initializeResultArray();

        $typoscript = $this->typoScriptService->getTypoScript($this->data['parentPageRow']['uid'], $this->data['request'], 0, $this->data['rootline'], $this->data['site']);


        $elementHtml = '';
        $disabled = false;
        if ($this->data['parameterArray']['fieldConf']['config']['readOnly']) {
            $disabled = true;
        }
        // Traversing the array of items
        $items = $this->data['parameterArray']['fieldConf']['config']['items'];

        $numberOfItems = is_countable($items) ? count($items) : 0;
        if ($numberOfItems === 0) {
            $items[] = ['', ''];
            $numberOfItems = 1;
        }
        $formElementValue = (int)$this->data['parameterArray']['itemFormElValue'];
        $cols = (int)$this->data['parameterArray']['fieldConf']['config']['cols'];
        if ($cols > 1) {
            [$colClass, $colClear] = $this->calculateColumnMarkup($cols);
            $elementHtml .= '<div class="row">';
            $counter = 0;
            // $itemKey is important here, because items could have been removed via TSConfig
            foreach ($items as $itemKey => $itemDefinition) {
                $label = $itemDefinition['label'];
                $elementHtml .=
                    '<div class="' . $colClass . '">'
                    . $this->renderSingleCheckboxElement($label, $itemKey, $formElementValue, $numberOfItems, $this->data['parameterArray'], $disabled) .
                    '</div>';
                ++$counter;
                if ($counter < $numberOfItems && !empty($colClear)) {
                    foreach ($colClear as $rowBreakAfter => $clearClass) {
                        if ($counter % $rowBreakAfter === 0) {
                            $elementHtml .= '<div class="clearfix ' . $clearClass . '"></div>';
                        }
                    }
                }
            }
            $elementHtml .= '</div>';
        } else {
            $counter = 0;
            foreach ($items as $itemDefinition) {
                $label = $itemDefinition['label'];
                $elementHtml .= $this->renderSingleCheckboxElement($label, $counter, $formElementValue, $numberOfItems, $this->data['parameterArray'], $disabled);
                ++$counter;
            }
        }
        if (!$disabled) {
            $elementHtml .= '<input type="hidden" name="' . htmlspecialchars($this->data['parameterArray']['itemFormElName']) . '" value="' . htmlspecialchars((string)$formElementValue) . '" />';
        }

        $fieldInformationResult = $this->renderFieldInformation();
        $fieldInformationHtml = $fieldInformationResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldInformationResult, false);

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

        $html = [];
        $html[] = '<div class="formengine-field-item t3js-formengine-field-item">';
        $html[] = $fieldInformationHtml;
        $html[] = '<div class="form-wizards-wrap">';
        $html[] = '<div class="form-wizards-element">';
        $html[] = $elementHtml;
        $html[] = '</div>';
        if (!$disabled && !empty($fieldWizardHtml)) {
            $html[] = '<div class="form-wizards-items-bottom">';
            $html[] = $fieldWizardHtml;
            $html[] = '</div>';
        }
        $html[] = '</div>';
        $html[] = '</div>';

        $resultArray['html'] = implode(LF, $html);
        return $resultArray;
    }

    /**
     * This functions builds the HTML output for the checkbox
     *
     * @param string $label Label of this item
     * @param int $itemCounter Number of this element in the list of all elements
     * @param int $formElementValue Value of this element
     * @param int $numberOfItems Full number of items
     * @param array $additionalInformation Information with additional configuration options.
     * @param bool $disabled TRUE if form element is disabled
     * @return string Single element HTML
     */
    protected function renderSingleCheckboxElement($label, $itemCounter, $formElementValue, $numberOfItems, $additionalInformation, $disabled): string
    {
        $config = $additionalInformation['fieldConf']['config'];
        $inline = !empty($config['cols']) && $config['cols'] === 'inline';
        $invert = isset($config['items'][0]['invertStateDisplay']) && $config['items'][0]['invertStateDisplay'] === true;
        $checkboxParameters = $this->checkBoxParams(
            $additionalInformation['itemFormElName'],
            $formElementValue,
            $itemCounter,
            $numberOfItems,
            implode('', $additionalInformation['fieldChangeFunc'])
        );
        $checkboxId = $additionalInformation['itemFormElID'] . '_' . $itemCounter;
        return '
            <div class="form-check form-switch' . (!$disabled ? '' : ' disabled') . '">
                <input type="checkbox"
                    class="checkbox-input"
                    value="1"
                    data-formengine-input-name="' . htmlspecialchars($additionalInformation['itemFormElName']) . '"
                    ' . $checkboxParameters . '
                    ' . (!$disabled ?: ' disabled="disabled"') . '
                    id="' . $checkboxId . '" />
                <label class="form-check-label" for="' . $checkboxId . '">
                    ' . $this->appendValueToLabelInDebugMode(($label ? htmlspecialchars($label) : ''), $formElementValue) . '
                </label>
            </div>';
    }

}
