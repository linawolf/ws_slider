<?php
declare(strict_types=1);

namespace WapplerSystems\WsSlider\Configuration;


use TYPO3\CMS\Extbase\Configuration\FrontendConfigurationManager;

class ConfigurationManager extends \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
{


    public function __construct(
        private readonly FrontendConfigurationManager $feConfigManager,
        private readonly BackendConfigurationManager $beConfigManager,
    ) {}



}
