<?php
namespace Aura;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $prettyName = $package->getPrettyName();
        list($vendor, $name) = explode('/', $prettyName);

        if ($this->isAuraSystemInstall() && strtolower($vendor) === 'aura') {
            $vendor = ucfirst($vendor);
            $name = ucfirst($name);

            return 'package/' . $vendor . '.' . $name . '/';
        }

        return parent::getInstallPath($package);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return $this->isAuraSystemInstall();
    }

    /**
     * If package is an Aura System Install
     *
     * @return boolean
     */
    protected function isAuraSystemInstall()
    {
        $consumerPackage = $this->composer->getPackage();
        if ($consumerPackage) {
            $extra = $consumerPackage->getExtra();
            if (!empty($extra['aura-system-install'])) {
                return true;
            }
        }

        return false;
    }
}
