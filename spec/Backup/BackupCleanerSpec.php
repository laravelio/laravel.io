<?php
namespace spec\Lio\Backup;

use League\Flysystem\FilesystemInterface;
use PhpSpec\ObjectBehavior;

class BackupCleanerSpec extends ObjectBehavior
{
    function let(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lio\Backup\BackupCleaner');
    }

    function it_can_remove_old_backups(FilesystemInterface $filesystem)
    {
        $files = [
            ['path' => '.gitignore'],
            ['path' => 'foo.sql'],
            ['path' => 'foo1.sql'],
            ['path' => 'foo2.sql'],
            ['path' => 'foo3.sql'],
            ['path' => 'foo4.sql'],
            ['path' => 'foo5.sql'],
            ['path' => 'foo6.sql'],
        ];

        $filesystem->listFiles()->willReturn($files);
        $filesystem->getTimestamp('foo.sql')->willReturn(10000);
        $filesystem->getTimestamp('foo1.sql')->willReturn(500);
        $filesystem->getTimestamp('foo2.sql')->willReturn(10000);
        $filesystem->getTimestamp('foo3.sql')->willReturn(10000);
        $filesystem->getTimestamp('foo4.sql')->willReturn(100);
        $filesystem->getTimestamp('.gitignore')->willReturn(50);
        $filesystem->getTimestamp('foo5.sql')->willReturn(10000);
        $filesystem->getTimestamp('foo6.sql')->willReturn(10000);
        $filesystem->delete('foo1.sql')->shouldBeCalled();
        $filesystem->delete('foo4.sql')->shouldBeCalled();

        $this->removeOldBackups(5)->shouldReturn(['foo4.sql', 'foo1.sql']);
    }
}
