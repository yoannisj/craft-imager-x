<?php
/**
 * Imager X plugin for Craft CMS
 *
 * Ninja powered image transforms.
 *
 * @link      https://www.spacecat.ninja
 * @copyright Copyright (c) 2020 André Elvan
 */

namespace spacecatninja\imagerx\elementactions;


use spacecatninja\imagerx\services\ImagerService;
use Craft;
use craft\elements\Asset;
use craft\elements\db\AssetQuery;
use craft\elements\db\ElementQueryInterface;
use craft\base\ElementAction;

use spacecatninja\imagerx\ImagerX;

/**
 *
 * @property-read string $triggerLabel
 */
class GenerateTransformsAction extends ElementAction
{

    /**
     * @inheritdoc
     */
    public function getTriggerLabel(): string
    {
        return Craft::t('imager-x', 'Generate transforms');
    }

    /**
     * Generates transforms 
     *
     *
     */
    public function performAction(ElementQueryInterface $query): bool
    {
        if (!($query instanceof AssetQuery)) {
            $this->setMessage(Craft::t('imager-x', 'Invalid query, this action only works on assets'));
            return false;
        }
        
        $assetsToGenerate = $query->kind('image')->all();

        if (empty($assetsToGenerate)) {
            $this->setMessage(Craft::t('imager-x', 'No images to transform'));
            return true;
        }

        $generateConfig = ImagerService::$generateConfig['volumes'] ?? null;
        
        if (empty($generateConfig)) {
            $this->setMessage(Craft::t('imager-x', 'No generate transforms configured'));
            return false;
        }
        

        try {
            /** @var Asset $asset */
            foreach ($assetsToGenerate as $asset) {
                $volumeHandle = $asset->getVolume()->handle;
                $transforms = $generateConfig[$volumeHandle] ?? null;
                
                if ($transforms) {
                    ImagerX::$plugin->generate->createTransformJob($asset, $transforms);
                }
            }
        } catch (\Throwable $e) {
            $this->setMessage($e->getMessage());
            return false;
        }

        $this->setMessage(Craft::t('imager-x', 'Generating asset transforms...'));
        return true;
    }
}
