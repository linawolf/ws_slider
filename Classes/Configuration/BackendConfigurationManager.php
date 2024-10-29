<?php
declare(strict_types=1);

namespace WapplerSystems\WsSlider\Configuration;


use Symfony\Component\DependencyInjection\Attribute\Autowire;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Site\Set\SetRegistry;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\TypoScript\FrontendTypoScriptFactory;
use TYPO3\CMS\Core\TypoScript\IncludeTree\SysTemplateRepository;
use TYPO3\CMS\Core\TypoScript\IncludeTree\SysTemplateTreeBuilder;
use TYPO3\CMS\Core\TypoScript\IncludeTree\Traverser\ConditionVerdictAwareIncludeTreeTraverser;
use TYPO3\CMS\Core\TypoScript\Tokenizer\LossyTokenizer;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;

class BackendConfigurationManager
{


    public function __construct(
        private TypoScriptService $typoScriptService,
        #[Autowire(service: 'cache.typoscript')]
        private PhpFrontend $typoScriptCache,
        #[Autowire(service: 'cache.runtime')]
        private FrontendInterface $runtimeCache,
        private SysTemplateRepository $sysTemplateRepository,
        private SiteFinder $siteFinder,
        private FrontendTypoScriptFactory $frontendTypoScriptFactory,
        private ConnectionPool $connectionPool,
        private SetRegistry $setRegistry,
    ) {
        // extract page id from returnUrl GET parameter
        if (isset($_GET['returnUrl'])) {
            $url = parse_url($_GET['returnUrl']);
            parse_str($url['query'] ?? '', $params);
            $pageId = $params['id'] ?? -1;
            if ($pageId !== -1) {
                $this->currentPageId = (int)$pageId;
            }
        }

    }


}
