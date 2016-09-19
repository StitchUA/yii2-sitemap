<?php

namespace enchikiben\sitemap;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\caching\Cache;

/**
 * Yii2 module for automatically generating XML Sitemap.
 *
 * @author enchikiben
 * @package enchikiben\sitemap
 */
class Sitemap extends Module
{
    public $controllerNamespace = 'enchikiben\sitemap\controllers';
    /** @var int */
    public $cacheExpire = 86400;
    /** @var Cache|string */
    public $cacheProvider = 'cache';
    /** @var string */
    public $cacheKey = 'sitemap';

    public $controllerDirAlias = '@frontend/controllers';

    public function init()
    {
        parent::init();
        if (is_string($this->cacheProvider)) {
            $this->cacheProvider = Yii::$app->{$this->cacheProvider};
        }
        if (!$this->cacheProvider instanceof Cache) {
            throw new InvalidConfigException('Invalid `cacheKey` parameter was specified.');
        }
    }

    /**
     * Build and cache a site map.
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function buildSitemap()
    {
        $sitemap = new SitemapGenerator($this->controllerDirAlias);
        echo $sitemap->getAsXml();
    }
}