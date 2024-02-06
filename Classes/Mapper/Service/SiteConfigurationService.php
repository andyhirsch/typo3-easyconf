<?php

declare(strict_types=1);

/*
 * This file is part of the composer package buepro/typo3-easyconf.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Buepro\Easyconf\Mapper\Service;

use TYPO3\CMS\Core\Configuration\SiteConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SiteConfigurationService implements SingletonInterface, MapperServiceInterface
{
    protected ?SiteConfiguration $siteConfigurationManager = null;
    protected ?Site $site = null;
    protected array $siteData = [];

    public function init(int $pageUid): self
    {
        $this->siteConfigurationManager = GeneralUtility::makeInstance(SiteConfiguration::class);
        $sites = $this->siteConfigurationManager->getAllExistingSites();
        foreach ($sites as $site) {
            if ($site->getRootPageId() === $pageUid) {
                $this->site = $site;
                $this->siteData = $this->siteConfigurationManager->load($site->getIdentifier());
            }
        }
        return $this;
    }

    public function getSiteConfigurationManager(): ?SiteConfiguration
    {
        return $this->siteConfigurationManager;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function getSiteData(): array
    {
        return $this->siteData;
    }

    public function getPropertyByPath(string $path): array|string|int|float
    {
        if (
            ArrayUtility::isValidPath($this->siteData, $path, '.') &&
            (
                is_array($candidate = ArrayUtility::getValueByPath($this->siteData, $path, '.')) ||
                is_string($candidate) ||
                is_int($candidate) ||
                is_float($candidate)
            )
        ) {
            return $candidate;
        }
        return '';
    }

    public function writeSiteData(array $siteData): void
    {
        if ($this->siteConfigurationManager !== null && $this->getSite() !== null) {
            $this->siteConfigurationManager->write($this->getSite()->getIdentifier(), $siteData);
            $this->siteData = $this->siteConfigurationManager->load($this->getSite()->getIdentifier());
        }
    }
}
