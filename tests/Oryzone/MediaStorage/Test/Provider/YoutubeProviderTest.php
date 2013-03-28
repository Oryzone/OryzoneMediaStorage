<?php
namespace Oryzone\MediaStorage\Test\Provider;

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use org\bovigo\vfs\vfsStream;

use Oryzone\MediaStorage\Provider\YoutubeProvider;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-08 at 04:37:16.
 */
class YoutubeProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var YoutubeProvider
     */
    protected $provider;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $dir;

    /**
     * @var \Oryzone\MediaStorage\Model\MediaInterface
     */
    protected $media;

    /**
     * @var \Oryzone\MediaStorage\Variant\VariantInterface
     */
    protected $variant;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->dir = vfsStream::setup();
        $dir = $this->dir;
        $tempDir = vfsStream::url($dir->getName()) . '/';

        $this->media = $this->getMock('\Oryzone\MediaStorage\Model\MediaInterface');
        $this->media->expects($this->any())
            ->method('getContext')
            ->will($this->returnValue('default'));
        $this->media->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('sample'));
        $this->media->expects($this->any())
                    ->method('getContent')
                    ->will($this->returnValue('http://www.youtube.com/watch?v=CpfdBtk3oWY'));
        $this->media->expects($this->any())
                    ->method('getMetaValue')
                    ->will($this->returnValueMap(array(
                        array('id', null, 'CpfdBtk3oWY')
                    )));

        $this->variant = $this->getMock('\Oryzone\MediaStorage\Variant\VariantInterface');
        $this->variant->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('default'));
        $this->variant->expects($this->any())
            ->method('getOptions')
            ->will($this->returnValue(array(
            'width' => 50,
            'height' => 30,
            'resize' => 'stretch'
        )));
        $this->variant->expects($this->any())
            ->method('getMetaValue')
            ->will($this->returnValueMap(array(
            array('width', null, 50),
            array('height', null, 30)
        )));

        $image = $this->getMock('\Imagine\Image\ImageInterface');
        $image->expects($this->any())
            ->method('save')
            ->will($this->returnCallback(
                function($destFile) use ($dir) {
                    $temp = vfsStream::newFile(basename($destFile));
                    $dir->addChild($temp);

                    return true;
                }));
        $imagine = $this->getMock('\Imagine\Image\ImagineInterface');
        $imagine->expects($this->any())
            ->method('open')
            ->will($this->returnValue($image));

        $downloader = $this->getMock('\Oryzone\MediaStorage\Downloader\DownloaderInterface');
        $downloader->expects($this->any())
                   ->method('download')
                   ->will($this->returnCallback(
                       function($url, $destination) use ($dir) {
                           $temp = vfsStream::newFile(basename($destination));
                           $temp->setContent(file_get_contents(__DIR__.'/../fixtures/images/sample.jpg'));
                           $dir->addChild($temp);

                           return true;
                       }));

        $videoService = $this->getMock('\Oryzone\MediaStorage\Integration\Video\VideoServiceInterface');

        $this->provider = new YoutubeProvider($tempDir, $imagine, $videoService, $downloader);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    public function testGetName()
    {
        $this->assertEquals('youtube', $this->provider->getName());
    }

    public function testPrepare()
    {
        $context = $this->getMock('\Oryzone\MediaStorage\Context\ContextInterface');
        $this->provider->setOptions(array(
            'metadata' => 'title'
        ));
        $this->provider->prepare($this->media, $context);
    }

    public function testRender()
    {
        $url = 'http://www.example.com/sample.jpg';
        $options = array('attributes' => array('class' => 'videoPlayer'));
        $expectedHtml = '<iframe src="http://www.youtube.com/embed/CpfdBtk3oWY" frameborder="0" allowfullscreen class="videoPlayer" ></iframe>';
        $rendered = $this->provider->render($this->media, $this->variant, $url, $options);
        $this->assertEquals($expectedHtml, $rendered);

        $options['mode'] = 'image';
        $expectedHtml = '<img src="http://www.example.com/sample.jpg" title="sample" class="videoPlayer" />';
        $rendered = $this->provider->render($this->media, $this->variant, $url, $options);
        $this->assertEquals($expectedHtml, $rendered);

        $options['mode'] = 'embedUrl';
        $expected = sprintf(YoutubeProvider::EMBED_URL, 'CpfdBtk3oWY');
        $rendered = $this->provider->render($this->media, $this->variant, $url, $options);
        $this->assertEquals($expected, $rendered);

        $options['mode'] = 'url';
        $expected = sprintf(YoutubeProvider::CANONICAL_URL, 'CpfdBtk3oWY');
        $rendered = $this->provider->render($this->media, $this->variant, $url, $options);
        $this->assertEquals($expected, $rendered);
    }
}
