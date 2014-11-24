<?php

namespace Oneup\SecurityAdvisory\Module;

class ModuleSecurityAdvisory extends \BackendModule
{
    protected $strTemplate = 'be_maintenance';

    public function compile()
    {
        \System::loadLanguageFile('tl_security_advisory');

        // Back button
        $this->Template->content = '';
        $this->Template->href = $this->getReferer(true);
        $this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);
        $this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];

        foreach ($GLOBALS['TL_SECURITY_ADVISORY'] as $callback) {
            $this->import($callback);

            if (!$this->$callback instanceof \executable)
            {
                throw new \Exception("$callback is not an executable class");
            }

            $this->Template->content .= $this->$callback->run();
        }
    }
}
