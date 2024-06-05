<?php

use ColorThief\ColorThief;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Injector\Injector;
use Psr\SimpleCache\CacheInterface;

class DominantColorImageExtension extends Extension
{
    /**
     * Get the primary dominant color of this Image
     * 
     * @return string|null color as hex i.e. #ff0000
     */
    public function DominantColor(): ?string
    {
        $image = $this->owner->AbsoluteLink();

        if (!$image || empty($image)) {
            return null;
        }

        /** @var CacheInterface $cache */
        $cache = Injector::inst()->get(CacheInterface::class . '.dominantcolor');
        $cacheKey = md5($this->owner->ID . $image);

        // check if cache is already set
        if ($cache->has($cacheKey)) {
            // return hex color
            return $cache->get($cacheKey);
        }

        // get dominant color from image
        $rgbColor = ColorThief::getColor($image);

        if (!$rgbColor || empty($rgbColor)) {
            return null;
        }

        // convert RGB color to hex
        $hexColor = self::rgbToHex($rgbColor);

        // set cache to new color hex
        $cache->set($cacheKey, $hexColor, 120);

        return $hexColor;
    }


    /**
     * Converts an RGB array into a hex string
     * 
     * @param array $color [red, green, blue]
     * @return string|null color as hex i.e. #ff0000
     */
    protected static function rgbToHex($color): ?string
    {
        if (empty($color)) {
            return null;
        } 
            
        $hex = dechex(($color[0] << 16) | ($color[1] << 8) | $color[2]);
        
        return '#' . str_pad($hex, 6, '0', STR_PAD_LEFT);
    }
}
