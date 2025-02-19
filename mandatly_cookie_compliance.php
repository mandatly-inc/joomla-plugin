<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Http\HttpFactory;

class plgSystemmandatly_cookie_compliance extends CMSPlugin
{
    protected $autoloadLanguage = true;

    public function onBeforeRender()
    {
        $app = Factory::getApplication();
        if ($app->isClient('administrator')) {
            $document = Factory::getDocument();
            $cssPath = Uri::root(true) . '/plugins/system/mandatly_cookie_compliance/assets/backend.css';
            $document->addStylesheet($cssPath);
            HTMLHelper::_('stylesheet', $cssPath, ['version' => 'auto']);
        }
    }

    public function onBeforeCompileHead()
    {
        $app = Factory::getApplication();

        if ($app->isClient('site')) {
            $doc = Factory::getDocument();

            $showBanner  = (int) $this->params->get('show_banner', 1);
            $demoMode    = (int) $this->params->get('demo_mode', 1);
            $websiteGuid = trim($this->params->get('website_guid', ''));

            $jsonUrl = 'https://cdnscript.mandatlyonline.com/cap/demobannersettings.json';
            $http = HttpFactory::getHttp();
            try {
                $response = $http->get($jsonUrl);
                $jsonData = $response->body;
                $jsonDecoded = json_decode($jsonData, true);
            } catch (Exception $e) {
                $jsonDecoded = [];
            }

            $baseUrl = rtrim($jsonDecoded['baseURL'] ?? '', '/'); 
            $demoBannerPath = ltrim($jsonDecoded['demoBannerPath'] ?? '', '/'); 
            $demoBannerScript = $baseUrl . '/' . $demoBannerPath;          

            $doc->addScriptDeclaration("
                window.mandatlyConfig = {
                    showBanner: $showBanner,
                    demoMode: $demoMode,
                    websiteGUID: '$websiteGuid',
                    demoBannerScript: '$demoBannerScript'
                };
            ");

            if ($showBanner) {
                if ($demoMode) {
                    $doc->addScript($demoBannerScript);
                    //$doc->addScriptDeclaration("console.log('Demo Mode: Running demo banner script.');");
                    //$doc->addScriptDeclaration("console.log('Demo Banner Script URL: $demoBannerScript');");
                } else {
                    if (!empty($websiteGuid)) {
                        $actualScript = $baseUrl . '/bn/' . $websiteGuid . '.js';
                        $doc->addScript($actualScript);
                      //  $doc->addScriptDeclaration("console.log('Cookie banner script loaded: $actualScript');");
                    } 
                    // else {
                    //     $doc->addScriptDeclaration("console.error('Cookie Banner: Website GUID is missing.');");
                    // }
                }
            }

            $doc->addScript(Uri::base() . 'plugins/system/mandatly_cookie_compliance/assets/customscript.js', ['type' => 'text/javascript']);
        }
    }
}
































