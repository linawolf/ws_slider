<?php


namespace WapplerSystems\WsSlider\Backend\Form\FormDataProvider;


use TYPO3\CMS\Backend\Form\FormDataProviderInterface;

class TcaSelectItemsEnhancer implements FormDataProviderInterface
{

    /**
     * @inheritDoc
     */
    public function addData(array $result)
    {

        $table = $result['tableName'];


        foreach ($result['processedTca']['columns'] as $fieldName => $fieldConfig) {
            if (empty($fieldConfig['config']['type']) || $fieldConfig['config']['type'] !== 'select') {
                continue;
            }

            if (isset($result['pageTsConfig']['TCEFORM.'][$table . '.'][$fieldName . '.']['placeholder'])) {
                $result['processedTca']['columns'][$fieldName]['config']['placeholder'] = $result['pageTsConfig']['TCEFORM.'][$table . '.'][$fieldName . '.']['placeholder'];
            }

        }

        return $result;
    }


}
