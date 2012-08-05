<?php
namespace Aura;

use Aura\Installer;
use Composer\Package\MemoryPackage;
use Composer\Composer;
use Composer\Config;

class InstallerTest extends TestCase
{
    private $composer;
    private $config;
    private $dm;
    private $repository;
    private $io;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        $this->composer = new Composer();
        $this->config = new Config();
        $this->composer->setConfig($this->config);

        $this->dm = $this->getMockBuilder('Composer\Downloader\DownloadManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->composer->setDownloadManager($this->dm);

        $this->repository = $this->getMock('Composer\Repository\InstalledRepositoryInterface');
        $this->io = $this->getMock('Composer\IO\IOInterface');
    }

    /**
     * testGetAuraSystemInstallPath
     */
    public function testGetAuraSystemInstallPath()
    {
        $installer = new Installer($this->io, $this->composer);
        $package = new MemoryPackage('aura/autoload', '1.0.0', '1.0.0');

        $consumerPackage = new MemoryPackage('hari/aura-system', '1.0.0', '1.0.0');
        $this->composer->setPackage($consumerPackage);
        $consumerPackage->setExtra(array(
            'aura-system-install' => true,
        ));

        $result = $installer->getInstallPath($package);
        $this->assertEquals('package/Aura.Autoload/', $result);
    }
}
