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

        if (strtolower($vendor) === 'aura') {
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
        return true;
    }
}
